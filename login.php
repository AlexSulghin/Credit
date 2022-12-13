<?php
session_start();
require 'config.php';
require_once 'connection.php';

echo '<style type="text/css"> #errorMessage{visibility: hidden !important;}</style>';
if (array_key_exists('signin', $_POST)) {

    $login = mysqli_real_escape_string($conn, $_POST["login"]);
    $parola = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT *FROM users WHERE BINARY login=?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $login);

    $stmt->execute();

    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    if ($row) {
        $hashedPassword = $row["password"];
        if (md5($_POST["password"]) == $hashedPassword) {
            $_SESSION['id_user'] = $row['id'];
            header('Location: http://' . $_SERVER['SERVER_NAME'] . $caleMain);
        } else {
            echo '<style type="text/css"> #errorMessage{visibility: visible !important;}</style>';
        }
    } else {
        echo '<style type="text/css"> #errorMessage{visibility: visible !important;}</style>';
    }
    mysqli_close($conn);
}
$login = $parola = "";

if (array_key_exists('signup', $_POST)) {
    echo 'dskalsd';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: url("./images/background.jpeg");
            background-size: cover;
            color: white;
        }

        input[type=text], input[type=password] {
            width: 30% !important;
            padding: 6px 10px;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            background-color: wheat;
            border-radius: 30px;
        }

        input[type=submit] {
            background-color: olivedrab;
            padding: 7px 10px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 30% !important;
            color: white;
            border-radius: 30px;
        }

        button {
            background-color: olivedrab;
            padding: 7px 10px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 30%;
            color: white !important;
            border-radius: 30px;
        }

        button:hover {
            opacity: 0.8;
        }

        input[type=submit]:hover {
            opacity: 0.8;
        }

        .container {
            padding: 16px;
        }

        span.psw {
            float: right;
            padding-top: 16px;
        }

        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }
        }

        label {
            color: white;
        }

        .center {
            margin: auto;
            width: 30%;
            padding: 10px;
        }

        .title {
            margin-top: auto;
            padding-left: 32%;
            padding-bottom: 1%;
            color: white;
        }

        .modalWindow {
            color: white !important;
            background-color: #3a3a3a;
        }

        .modalWindow input {
            width: 50% !important;
            padding: 6px 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            background-color: white !important;
            border-radius: 10px !important;
            color: black;
        }

        .containers {
            margin-top: 1%;
            min-width: 150px;
            min-height: 150px;
            background: #3a3a3a;
            padding: 20px 20px;
            border-radius: 30px;
            box-shadow: 1px 1px 15px black;
            opacity: 90%;
        }

    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"/>

</head>
<body ng-app="app2" ng-controller='ModalDemoCtrl as $ctrl' class="modal-demo">

<div class="center containers">
    <h2 class="title">Autentificare</h2>
    <form action="<?php $_SERVER['SCRIPT_NAME'] ?>" method="post">

        <div class="container">
            <div class="form-group col-md-12">
                <div class="col-md-1"><label for="login"><b>Login</b></label></div>
                <div class="col-md-8"><input id="login" type="text" autocomplete="off"
                                             placeholder="Introduceti login-ul" name="login"></div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-1"><label for="password"><b>Parola</b></label></div>
                <div class="col-md-8"><input id="password" type="password" autocomplete="off"
                                             placeholder="Introduceti parola" name="password"></div>
            </div>

            <div class="form-group">
                <span id="errorMessage"
                      style="color: red; visibility: hidden; margin-left: 2%">Date incorecte! Incercati din nou.</span>
            </div>

            <div class="form-group col-md-12">
                <div class="col-md-1"></div>
                <div class="col-md-8">
                    <button type="submit" name='signin'>Logheaza-te</button>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-1"></div>
                <div class="col-md-8">
                    <button type="button" ng-click="$ctrl.openModalWindow()">Inregistreaza-te</button>
                    <!--                    <button type="button" data-toggle="modal" href="#signup">Inregistreaza-te</button>-->
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/ng-template" id="myModalContent.html">
    <div class="modalWindow">
        <div class="modal-header">
            <h4>Inregistrare</h4>
        </div>
        <div class="modal-body">
            <div class="form">
                <div class="row form-group col-md-12">
                    <div class="col-md-2">
                        <label style="margin-top: 15px;" class="modalWindow" for="loginNew"><b>Login</b></label>
                    </div>
                    <div class="col-md-10">
                        <input id="loginNew" type="text" placeholder="Introduceti un nou login"
                               name="loginNew" autocomplete="off" ng-model="newLogin">
                    </div>
                </div>
                <div class="row form-group col-md-12">
                    <div class="col-md-2">
                        <label style="margin-top: 15px;" class="modalWindow" for="passwordNew"><b>Parola</b></label>
                    </div>
                    <div class="col-md-10">
                        <input id="passwordNew" type="password" placeholder="Introduceti o parola"
                               name="passwordNew" autocomplete="off" ng-model="newPassword">
                    </div>
                </div>
                <span id="errorMessageSignUp" style="color: red; visibility: hidden; ">Introduceti login-ul si parola!</span>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" ng-click="$ctrl.cancel()" type="button">Cancel</button>
            <button class="btn btn-primary" type="button" name='signup' ng-click="$ctrl.addNewUser()">Inregistreaza-te
            </button>
        </div>
    </div>
</script>
</body>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-touch/1.8.3/angular-touch.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-animate/1.8.3/angular-animate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.6/ui-bootstrap-tpls.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='signUp.js'></script>
</html>
