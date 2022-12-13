<?php
session_start();
require 'config.php';
if (!$_SESSION['id_user']) {
    header('Location: http://' . $_SERVER['SERVER_NAME'] . $caleSignIn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Credite</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <script src='main.js'></script>
</head>
<body>
<div class="containers">
    <div ng-app='myApp' ng-controller='myController' ng-init='loadTables()'>
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#credits">Credite</a></li>
            <li><a data-toggle="pill" href="#clients">Clienti</a></li>
            <li><a data-toggle="pill" href="#creditTypes">Tipuri de credite</a></li>
            <li><a data-toggle="pill" href="#payments">Plati</a></li>
            <li><a data-toggle="pill" href="#addInfo" ng-click="initAddInfo()">Adauga</a></li>
            <li><a data-toggle="pill" href="#aboutUs">Despre noi</a></li>
            <li style="float: right"><h5><a style="color: white" id="signOut" href="logout.php">Sign out</a></h5></li>
        </ul>

        <div class="tab-content">

            <!--Credits-->
            <div id="credits" class="tab-pane fade in active">
                <div class="col-md-12">
                    <h3>Lista creditelor</h3>
                    <div class='tableHolder'>
                        <table class="table table-bordered">
                            <tr>
                                <th>Nume</th>
                                <th>Prenume</th>
                                <th>Ref nr.</th>
                                <th>Tip de credit</th>
                                <th>Rata</th>
                                <th>Termen</th>
                                <th>Suma</th>
                                <th>Data emiterii</th>
                                <th>Suma ramasa</th>
                                <th>Status</th>
                            </tr>

                            <tr ng-repeat="cr in credits | orderBy : 'dataEmit' track by $index"
                                ng-hide="cr.status === 'FINISHED'">
                                <td>{{cr.nume}}</td>
                                <td>{{cr.prenume}}</td>
                                <td>{{cr.refNr}}</td>
                                <td>{{cr.tipCredit}}</td>
                                <td>{{cr.rata}}</td>
                                <td>{{cr.termen}}</td>
                                <td>{{cr.suma}}</td>
                                <td>{{cr.dataEmit}}</td>
                                <td>{{cr.sumaRamasa}}</td>
                                <td>{{cr.status}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>


            <!--Clients-->
            <div id="clients" class="tab-pane fade">
                <h3>Lista clienti</h3>
                <div class='tableHolder'>
                    <table class="table table-bordered">
                        <tr>
                            <th><input type="checkbox" ng-model="allClients"></th>
                            <th>Nume</th>
                            <th>Prenume</th>
                            <th>Adresa</th>
                            <th>Telefon</th>
                            <th>Persoana de contact</th>
                            <th>Actiuni</th>
                        </tr>
                        <tr ng-repeat="cl in clients track by $index ">
                            <td><input type="checkbox" id="{{cl.id}}" name="checkClients" ng-click="ckClients()"></td>
                            <td><input class="inputUpdate" type="text" id="name_{{$index}}" disabled
                                       value="{{cl.nume}}"></td>
                            <td><input class="inputUpdate" type="text" id="surname_{{$index}}" disabled
                                       value="{{cl.prenume}}"></td>
                            <td><input class="inputUpdate" type="text" id="address_{{$index}}" disabled
                                       value="{{cl.adresa}}"></td>
                            <td><input class="inputUpdate" type="text" id="phone_{{$index}}" disabled
                                       value="{{cl.telefon}}"</td>
                            <td><input class="inputUpdate" type="text" id="contact_{{$index}}" disabled
                                       value="{{cl.contact}}"></td>
                            <td>
                                <input type="submit" value="Actualizeaza" class='btn btn-success'
                                       ng-click='editClient($index, cl.id)' id="btnClient_{{$index}}">
                            </td>
                        </tr>
                    </table>
                </div>
                <button style="margin-left: 45%" class='btn btn-danger' ng-click='deleteClients()'
                        ng-disabled="btnDeleteClients">Delete selected
                </button>
            </div>


            <!--Credit Types-->
            <div id="creditTypes" class="tab-pane fade">
                <h3>Lista tipurilor de credit</h3>
                <div class='tableHolder'>
                    <table class="table table-bordered">
                        <tr>
                            <th><input type="checkbox" ng-model="allCreditTypes"></th>
                            <th>Denumire tip credit</th>
                            <th>Conditii</th>
                            <th>Rata (%)</th>
                            <th>Termen (luni)</th>
                            <th>Actualizare</th>
                        </tr>

                        <tr ng-repeat='ct in creditTypes track by $index'>
                            <td><input type="checkbox" id="{{ct.id}}" name="checkCreditTypes"
                                       ng-click="ckCreditTypes()"></td>
                            <td><input class="inputUpdate" type="text" id="den_{{$index}}" disabled
                                       value="{{ct.denumire}}"></td>
                            <td><input class="inputUpdate" type="text" id="conditions_{{$index}}" disabled
                                       value="{{ct.conditii}}"></td>
                            <td><input class="inputUpdate" type="text" id="rate_{{$index}}" disabled
                                       value="{{ct.rata}}"></td>
                            <td><input class="inputUpdate" type="text" id="period_{{$index}}" disabled
                                       value="{{ct.termen}}"</td>
                            <td>
                                <input type="submit" value="Actualizeaza" class='btn btn-success'
                                       ng-click='editCreditType($index, ct.id)' id="btnCreditType_{{$index}}">
                            </td>
                        </tr>
                    </table>
                </div>
                <button style="margin-left: 45%" class='btn btn-danger' ng-click='deleteCreditTypes()'
                        ng-disabled="btnDeleteCreditTypes">Delete selected
                </button>
            </div>

            <!--Payments-->
            <div id="payments" class="tab-pane fade">
                <h3>Lista platilor</h3>
                <div id="paymentFilters">
                    <div>
                        <label for="clientPayment">Client</label>
                        <select id="clientPayment" ng-model='clientPayment'
                                style="width: 30%; margin-right: 5%; padding-left: 10px; border-radius: 7px;">
                            <option value='' disabled>Selectati clientul</option>
                            <option value='all'>Toti</option>
                            <option ng-repeat="cl in clients" value={{cl.id}}>{{cl.nume}} {{cl.prenume}}</option>
                        </select>
                        <label for="creditPayment">Credit</label>
                        <select id="creditPayment" ng-model='creditPayment'
                                style="width: 30%; padding-left: 10px; border-radius: 7px;">
                            <option value='' disabled>Selectati creditul</option>
                            <option value='all'>Toate</option>
                            <option ng-repeat="cr in credits" value={{cr.id}}>{{cr.refNr}}</option>
                        </select>
                    </div>
                </div>
                <div class='tableHolder'>
                    <table class="table table-bordered">
                        <tr>
                            <th>Client</th>
                            <th>Credit</th>
                            <th>Suma</th>
                            <th>Data achitarii</th>
                        </tr>

                        <tr ng-repeat="p in filteredPayments | orderBy : '-dataPlata' | limitTo : 4 track by $index">
                            <td>{{p.nume}} {{p.prenume}}</td>
                            <td>{{p.refNr}}</td>
                            <td>{{p.suma}}</td>
                            <td>{{p.dataPlata}}</td>
                        </tr>
                    </table>
                </div>
            </div>


            <!--Add something info-->
            <div id="addInfo" class="tab-pane fade">
                <h3>Alege tipul de informatie</h3>
                <select id="typeInfo" ng-model='typeInfo' ng-change="changeAddTypeInfo()"
                        style="width: 100%; padding-left: 10px; border-radius: 7px;">
                    <option value='' disabled>Selectati tipul de informatie</option>
                    <option value='credit'>Credit</option>
                    <option value='client'>Client</option>
                    <option value='creditType'>Tip de credit</option>
                    <option value='payment'>Plata</option>
                </select>

                <div id="divAddCredit" class='withForm' ng-show="divAddCredit">
                    <div class="row form-group">
                        <div class="col-md-3"><label for="client">Client</label></div>
                        <div class="col-md-9">
                            <select id="client" class="form-control" ng-model='clientId' style="width: 170%">
                                <option value='' disabled>Selectati clientul</option>
                                <option ng-repeat="cl in clients" value={{cl.id}}>{{cl.nume}} {{cl.prenume}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"><label for="creditType">Tip de credit</label></div>
                        <div class="col-md-9">
                            <select id="creditType" class="form-control" ng-model='creditTypeId' style="width: 170%"
                                    ng-change="selectCreditTypeForNewCredit()">
                                <option value='' disabled>Selectati tipul de credit</option>
                                <option ng-repeat="ct in creditTypes" value='{{ct.id}}'>{{ct.denumire}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"><label for="sum">Suma</label></div>
                        <div class="col-md-9">
                            <input id="sum" type="number" placeholder="Introduceti suma" ng-model="suma" required
                                   onfocus="this.value=''">
                        </div>
                        <br>
                    </div>
                    <p style="color: white; ">Total: <span
                                ng-bind="(suma + (suma * selectedCreditType[0].rata / 100)) || 0"></span>;
                        Lunar: <span
                                ng-bind="((suma + (suma * selectedCreditType[0].rata / 100)) / selectedCreditType[0].termen | number : 2) || 0"></span>
                    </p>
                    <div style="margin-left: 40%">
                        <input type="submit" value="Aplica" class='btn btn-success' ng-click='addCredit()'>
                    </div>
                </div>

                <div id="divAddClient" class='withForm' ng-show="divAddClient">
                    <div class="row form-group">
                        <div class="col-md-3"><label for="name">Nume</label></div>
                        <div class="col-md-9">
                            <input class="inputAdd" id="name" type="text" placeholder="Introduceti numele"
                                   ng-model="name">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"><label for="surname">Prenume</label></div>
                        <div class="col-md-9">
                            <input class="inputAdd" id="surname" type="text" placeholder="Introduceti prenumele"
                                   ng-model="surname">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"><label for="address">Adresa</label></div>
                        <div class="col-md-9">
                            <input class="inputAdd" id="address" type="text" placeholder="Introduceti adresa"
                                   ng-model="address">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"><label for="phone">Telefon</label></div>
                        <div class="col-md-9">
                            <input class="inputAdd" id="phone" type="text" placeholder="Introduceti numarul de telefon"
                                   ng-model="phone">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"><label for="contact">Contact</label></div>
                        <div class="col-md-9">
                            <textarea id="contact" placeholder="Introduceti contactul" ng-model="contact"></textarea>
                        </div>
                    </div>
                    <div style="margin-left: 40%">
                        <input type="submit" value="Salveaza" class='btn btn-success' ng-click='addClient()'>
                    </div>
                </div>

                <div id="divAddCreditType" class='withForm' ng-show="divAddCreditType">
                    <div class="row form-group">
                        <div class="col-md-3"><label for="denCreditType">Denumire</label></div>
                        <div class="col-md-9">
                            <input class="inputAdd" id="denCreditType" type="text" placeholder="Introduceti denumirea"
                                   ng-model="denCreditType">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"><label for="conditions">Conditii</label></div>
                        <div class="col-md-9">
                            <input class="inputAdd" id="conditions" type="text"
                                   placeholder="Introduceti conditiile de primire"
                                   ng-model="conditions">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"><label for="rate">Rata (%)</label></div>
                        <div class="col-md-9">
                            <input class="inputAdd" id="rate" type="text" placeholder="Introduceti rata"
                                   ng-model="rate">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"><label for="period">Termen (luni)</label></div>
                        <div class="col-md-9">
                            <input class="inputAdd" id="period" type="text" placeholder="Introduceti termenul"
                                   ng-model="period">
                        </div>
                    </div>
                    <div style="margin-left: 40%">
                        <input type="submit" value="Salveaza" class='btn btn-success' ng-click='addCreditType()'>
                    </div>
                </div>

                <div id="divAddPayment" class='withForm' ng-show="divAddPayment">
                    <div class="row form-group">
                        <div class="col-md-3"><label for="client">Credit</label></div>
                        <div class="col-md-9">
                            <select id="client" class="form-control" ng-model='creditId' style="width: 170%"
                                    ng-change="selectCreditForPayment()">
                                <option value='' disabled>Selectati creditul</option>
                                <option ng-repeat="cr in credits" value='{{cr.id}}' ng-hide="cr.status ==='FINISHED'">
                                    {{cr.refNr}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3"><label for="sum">Suma</label></div>
                        <div class="col-md-9">
                            <input id="sum" type="number" placeholder="Introduceti suma" ng-model="suma" required
                                   onfocus="this.value=''">
                        </div>
                    </div>
                    <p style="color: white; ">Suma ramasa spre achitare pentru creditul selectat este: <span
                                ng-bind="selectedCredit[0].sumaRamasa || 0"></span>
                    </p>
                    <div style="margin-left: 40%">
                        <input type="submit" value="Achita" class='btn btn-success' ng-click='addPayment()'>
                    </div>
                </div>
            </div>

            <!--About us-->
            <div id="aboutUs" class="tab-pane fade">
                <div class="form-group row col-md-12" style="margin-top: 2%">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2719.43027169602!2d28.82124514562737!3d47.03178715225821!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c97dc9da955555%3A0x8cd6a070d77330c8!2sIuteCredit%20Moldova!5e0!3m2!1sru!2s!4v1670859736093!5m2!1sru!2s"
                             height="250px" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <img src="images/logo.png" style="width: 300px; height: 200px; margin-left: 5%; vertical-align: inherit"/>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>