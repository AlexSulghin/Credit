var app = angular.module('myApp', [])
app.controller('myController', function ($scope, $http, $filter) {

    $scope.initAddInfo = function () {
        $scope.divAddCredit = true;
        $scope.divAddClient = false;
        $scope.divAddCreditType = false;
        $scope.divAddPayment = false;

        $scope.typeInfo = 'credit';
        $scope.clientId = ''
        $scope.creditTypeId = ''
        $scope.suma = 0

        $scope.name = ''
        $scope.surname = ''
        $scope.address = ''
        $scope.phone = ''
        $scope.contact = ''

        $scope.denCreditType = ''
        $scope.conditions = ''
        $scope.rate = ''
        $scope.period = ''

        $scope.creditId = ''
    }

    $scope.changeAddTypeInfo = function () {
        switch ($scope.typeInfo) {
            case 'credit' :
                $scope.divAddCredit = true;
                $scope.divAddClient = false;
                $scope.divAddCreditType = false;
                $scope.divAddPayment = false;
                break;
            case 'client' :
                $scope.divAddCredit = false;
                $scope.divAddClient = true;
                $scope.divAddCreditType = false;
                $scope.divAddPayment = false;
                break;
            case 'creditType' :
                $scope.divAddCredit = false;
                $scope.divAddClient = false;
                $scope.divAddCreditType = true;
                $scope.divAddPayment = false;
                break;
            case 'payment' :
                $scope.divAddCredit = false;
                $scope.divAddClient = false;
                $scope.divAddCreditType = false;
                $scope.divAddPayment = true;
                break;
        }
    }

    $scope.addClient = function () {
        $http.post('insertClient.php', {
            'client_name': $scope.name,
            'client_surname': $scope.surname,
            'client_address': $scope.address,
            'client_phone': $scope.phone,
            'client_contact': $scope.contact
        }).success(function (data) {
            alert(data);
            $scope.loadTables();
            $scope.name = null;
            $scope.surname = null;
            $scope.address = null;
            $scope.phone = null;
            $scope.contact = null;

        })
    }

    $scope.addCreditType = function () {
        $http.post('insertCreditType.php', {
            'credit_type_den': $scope.denCreditType,
            'credit_type_conditions': $scope.conditions,
            'credit_type_rate': $scope.rate,
            'credit_type_period': $scope.period
        }).success(function (data) {
            alert(data);
            $scope.loadTables();
            $scope.denCreditType = null;
            $scope.conditions = null;
            $scope.rate = null;
            $scope.period = null;
        })
    }

    $scope.addCredit = function () {
        $scope.currentCreditType = $filter('filter')($scope.creditTypes, {
            id: $scope.creditTypeId
        });
        $scope.finalSum = $scope.suma + ($scope.suma * $scope.currentCreditType[0].rata / 100)

        $http.post('insertCredit.php', {
            'clientId': $scope.clientId,
            'creditTypeId': $scope.creditTypeId,
            'suma': $scope.finalSum
        }).success(function (data) {
            alert(data);
            $scope.loadTables();
            $scope.clientId = null;
            $scope.creditTypeId = null;
            $scope.suma = null;
        })
    }

    $scope.addPayment = function () {
        $scope.currentCredit = $filter('filter')($scope.credits, {
            id: $scope.creditId
        });
        if ($scope.suma <= $scope.currentCredit[0].sumaRamasa) {
            $http.post('insertPayments.php', {
                'creditId': $scope.creditId,
                'suma': $scope.suma
            }).success(function () {
                $http.post('updateCredit.php', {
                    'id': $scope.creditId,
                    'suma': $scope.suma
                }).success(function (data) {
                    alert(data);
                    $scope.loadTables();
                    $scope.creditId = null;
                    $scope.suma = null;
                })
            })
        } else {
            alert("Ati introdus o suma prea mare!");
        }
    }

    $scope.$watch('allClients', function () {
        const checkClients = document.getElementsByName("checkClients")
        checkClients.forEach((checkClient) => {
            checkClient.checked = $scope.allClients;
        })
        $scope.ckClients();
    })

    $scope.$watch('allCreditTypes', function () {
        const checkCreditTypes = document.getElementsByName("checkCreditTypes")
        checkCreditTypes.forEach((checkCreditType) => {
            checkCreditType.checked = $scope.allCreditTypes;
        })
        $scope.ckCreditTypes();
    })

    $scope.$watch('clientPayment', function () {
        if ($scope.clientPayment === 'all') {
            $scope.filteredPayments = $filter('filter')($scope.payments, {
                creditId: $scope.creditPayment
            });
            if ($scope.creditPayment === 'all') {
                $scope.filteredPayments = $scope.payments
            }
        } else {
            $scope.filteredPayments = $filter('filter')($scope.payments, {
                clientId: $scope.clientPayment,
                creditId: $scope.creditPayment
            });
        }
    })

    $scope.$watch('creditPayment', function () {
        if ($scope.creditPayment === 'all') {
            $scope.filteredPayments = $filter('filter')($scope.payments, {
                clientId: $scope.clientPayment
            });
            if ($scope.clientPayment === 'all') {
                $scope.filteredPayments = $scope.payments
            }
        } else {
            $scope.filteredPayments = $filter('filter')($scope.payments, {
                creditId: $scope.creditPayment,
                clientId: $scope.clientPayment
            });
        }
    })

    $scope.editClient = function (index, clientId) {
        var buttonName = document.getElementById("btnClient_" + index).value;
        if (buttonName === 'Actualizeaza') {
            document.getElementById("name_" + index).disabled = false;
            document.getElementById("name_" + index).style.color = 'black';

            document.getElementById("surname_" + index).disabled = false;
            document.getElementById("surname_" + index).style.color = 'black';

            document.getElementById("address_" + index).disabled = false;
            document.getElementById("address_" + index).style.color = 'black';

            document.getElementById("phone_" + index).disabled = false;
            document.getElementById("phone_" + index).style.color = 'black';

            document.getElementById("contact_" + index).disabled = false;
            document.getElementById("contact_" + index).style.color = 'black';

            document.getElementById("btnClient_" + index).value = 'Salveaza';
        } else if (buttonName === 'Salveaza') {
            $scope.clientToUpdate = $filter('filter')($scope.clients, {id: clientId});
            $scope.clientId = clientId;
            $scope.clientName = document.getElementById("name_" + index).value;
            $scope.clientSurname = document.getElementById("surname_" + index).value;
            $scope.clientAddress = document.getElementById("address_" + index).value;
            $scope.clientPhone = document.getElementById("phone_" + index).value;
            $scope.clientContact = document.getElementById("contact_" + index).value;
            $http.post('updateClients.php', {
                'clientId': $scope.clientId,
                'clientName': $scope.clientName,
                'clientSurname': $scope.clientSurname,
                'clientAddress': $scope.clientAddress,
                'clientPhone': $scope.clientPhone,
                'clientContact': $scope.clientContact
            }).success(function (data) {
                alert(data);
                document.getElementById("name_" + index).disabled = true;
                document.getElementById("name_" + index).style.color = 'white';

                document.getElementById("surname_" + index).disabled = true;
                document.getElementById("surname_" + index).style.color = 'white';

                document.getElementById("address_" + index).disabled = true;
                document.getElementById("address_" + index).style.color = 'white';

                document.getElementById("phone_" + index).disabled = true;
                document.getElementById("phone_" + index).style.color = 'white';

                document.getElementById("contact_" + index).disabled = true;
                document.getElementById("contact_" + index).style.color = 'white';

                document.getElementById("btnClient_" + index).value = 'Actualizeaza';
                $scope.loadTables();
            });
        }
    }

    $scope.editCreditType = function (index, creditTypeId) {
        var buttonName = document.getElementById("btnCreditType_" + index).value;
        if (buttonName === 'Actualizeaza') {
            document.getElementById("den_" + index).disabled = false;
            document.getElementById("den_" + index).style.color = 'black';

            document.getElementById("conditions_" + index).disabled = false;
            document.getElementById("conditions_" + index).style.color = 'black';

            document.getElementById("rate_" + index).disabled = false;
            document.getElementById("rate_" + index).style.color = 'black';

            document.getElementById("period_" + index).disabled = false;
            document.getElementById("period_" + index).style.color = 'black';

            document.getElementById("btnCreditType_" + index).value = 'Salveaza';
        } else if (buttonName === 'Salveaza') {
            $scope.creditTypeToUpdate = $filter('filter')($scope.creditTypes, {id: creditTypeId});
            $scope.creditTypeId = creditTypeId;
            $scope.creditTypeDen = document.getElementById("den_" + index).value;
            $scope.creditTypeConditions = document.getElementById("conditions_" + index).value;
            $scope.creditTypeRate = document.getElementById("rate_" + index).value;
            $scope.creditTypePeriod = document.getElementById("period_" + index).value;
            $http.post('updateCreditTypes.php', {
                'creditTypeId': $scope.creditTypeId,
                'creditTypeDen': $scope.creditTypeDen,
                'creditTypeConditions': $scope.creditTypeConditions,
                'creditTypeRate': $scope.creditTypeRate,
                'creditTypePeriod': $scope.creditTypePeriod,
            }).success(function (data) {
                alert(data);
                document.getElementById("den_" + index).disabled = true;
                document.getElementById("den_" + index).style.color = 'white';

                document.getElementById("conditions_" + index).disabled = true;
                document.getElementById("conditions_" + index).style.color = 'white';

                document.getElementById("rate_" + index).disabled = true;
                document.getElementById("rate_" + index).style.color = 'white';

                document.getElementById("period_" + index).disabled = true;
                document.getElementById("period_" + index).style.color = 'white';

                document.getElementById("btnCreditType_" + index).value = 'Actualizeaza';
                $scope.loadTables();
            });
        }
    }

    $scope.ckClients = function () {
        $scope.clientsToDelete = []
        angular.forEach($scope.clients, function (client) {
            if (document.getElementById(client.id).checked) {
                $scope.clientsToDelete.push(client.id)
            }
        })
        if ($scope.clientsToDelete.length > 0) {
            $scope.btnDeleteClients = false;
        } else {
            $scope.btnDeleteClients = true;
        }
    }

    $scope.selectCreditTypeForNewCredit = function () {
        $scope.selectedCreditType = $filter('filter')($scope.creditTypes, {id: $scope.creditTypeId});
    }

    $scope.selectCreditForPayment = function () {
        $scope.selectedCredit = $filter('filter')($scope.credits, {id: $scope.creditId});
    }

    $scope.ckCreditTypes = function () {
        $scope.creditTypesToDelete = []
        angular.forEach($scope.creditTypes, function (creditType) {
            if (document.getElementById(creditType.id).checked) {
                $scope.creditTypesToDelete.push(creditType.id)
            }
        })
        if ($scope.creditTypesToDelete.length > 0) {
            $scope.btnDeleteCreditTypes = false;
        } else {
            $scope.btnDeleteCreditTypes = true;
        }
    }

    $scope.deleteClients = function () {
        $scope.clientsToDelete = []
        angular.forEach($scope.clients, function (client) {
            if (document.getElementById(client.id).checked) {
                $scope.clientsToDelete.push(client.id)
            }
        })
        var data = {
            array: $scope.clientsToDelete
        }
        $http.post('deleteClients.php').success(function () {
            if (confirm('Esti sigur ca doresti sa stergi clientii selectati?')) {
                $http.post('deleteClients.php', data)
                    .success(function (data) {
                        alert(data);
                        $scope.loadTables();
                    })
            } else {
                false;
            }
        })
    }

    $scope.deleteCreditTypes = function () {
        $scope.creditTypesToDelete = []
        angular.forEach($scope.creditTypes, function (creditType) {
            if (document.getElementById(creditType.id).checked) {
                $scope.creditTypesToDelete.push(creditType.id)
            }
        })
        var data = {
            array: $scope.creditTypesToDelete
        }
        $http.post('deleteCreditTypes.php').success(function () {
            if (confirm('Esti sigur ca doresti sa stergi tipurile de credit selectate?')) {
                $http.post('deleteCreditTypes.php', data)
                    .success(function (data) {
                        alert(data);
                        $scope.loadTables();
                    })
            } else {
                false;
            }
        })
    }

    $scope.loadTables = function () {
        $scope.btnDeleteClients = true;
        $scope.btnDeleteCreditTypes = true;
        $http.get('selectClients.php')
            .success(function (data) {
                $scope.clients = data;
            })
        $http.get('selectCreditTypes.php')
            .success(function (data) {
                $scope.creditTypes = data;
            })
        $http.get('selectPayments.php')
            .success(function (data) {
                $scope.payments = data;
                $scope.filteredPayments = $scope.payments
            })
        $http.get('selectCredits.php')
            .success(function (data) {
                $scope.credits = data;
                checkCredits();
            })
    }

    function checkCredits() {
        angular.forEach($scope.credits, function (credit) {
            if (credit.sumaRamasa === '0' && credit.status !== 'FINISHED') {
                $http.post('updateCredit2.php', {
                    'id': credit.id
                })
                    .success(function () {
                        $scope.loadTables();
                    })
            }
        })
    }
})