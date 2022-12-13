var signUp = angular.module('app2', ['ngTouch', 'ngAnimate', 'ui.bootstrap']);
signUp.controller('ModalDemoCtrl', function ($uibModal, $log, $document) {
    var $ctrl = this;
    $ctrl.items = ['item1', 'item2', 'item3'];

    $ctrl.animationsEnabled = true;

    $ctrl.openModalWindow = function (size, parentSelector) {
        var parentElem = parentSelector ?
            angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
        var modalInstance = $uibModal.open({
            animation: $ctrl.animationsEnabled,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',
            controllerAs: '$ctrl',
            size: size,
            appendTo: parentElem,
            resolve: {
                items: function () {
                    return $ctrl.items;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $ctrl.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };
});

signUp.controller('ModalInstanceCtrl', function ($uibModalInstance, items, $scope, $http) {
    var $ctrl = this;
    $ctrl.items = items;
    $ctrl.selected = {
        item: $ctrl.items[0]
    };

    $ctrl.addNewUser = function () {
        if (isUndefined($scope.newLogin) || isUndefined($scope.newPassword)) {
            document.getElementById("errorMessageSignUp").style.visibility = 'visible';
        } else {
            document.getElementById("errorMessageSignUp").style.visibility = 'hidden';
            $scope.errorAddUser = false;
            $http.post('insertUser.php', {
                'login': $scope.newLogin,
                'parola': $scope.newPassword
            })
                .then(function (data) {
                    alert(data.data);
                    if (data.data != null && data.data === 'Utilizatorul a fost adaugat cu succes!') {
                        $uibModalInstance.dismiss('cancel');
                    }
                })
        }
    };

    function isUndefined(value) {
        return value == null || value === 'undefined' || value.length === 0 || value === '';
    }

    $ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

signUp.component('modalComponent', {
    templateUrl: 'myModalContent.html',
    bindings: {
        resolve: '<',
        close: '&',
        dismiss: '&'
    },
    controller: function () {
        var $ctrl = this;

        $ctrl.$onInit = function () {
            $ctrl.items = $ctrl.resolve.items;
            $ctrl.selected = {
                item: $ctrl.items[0]
            };
        };

        $ctrl.addNewUser = function () {

        };

        $ctrl.cancel = function () {
            $ctrl.dismiss({$value: 'cancel'});
        };
    }
});