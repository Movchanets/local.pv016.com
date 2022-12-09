<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Головна сторінка</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/cropper.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Style all input fields */
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
        }

        /* Style the submit button */
        input[type=submit] {
            background-color: #04AA6D;
            color: white;
        }



        /* The message box is shown when the user clicks on the password field */
        #message {
            display:none;
            background: #f1f1f1;
            color: #000;
            position: relative;
            padding: 20px;
            margin-top: 10px;
        }

        #message p {
            padding: 10px 35px;
            font-size: 18px;
        }

        /* Add a green text color and a checkmark when the requirements are right */
        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "✔";
        }

        /* Add a red text color and an "x" when the requirements are wrong */
        .invalid {
            color: red;
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "✖";
        }
    </style>
</head>
<body>

<?php include($_SERVER['DOCUMENT_ROOT'].'/_header.php'); ?>

<div class="container">
    <h1 class="text-center">Реєстрація</h1>
</div>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Реєстрація</h3>


                        <div class="row">
                            <div class="col-md-6 mb-4">

                                <div class="form-outline">
                                    <input type="text" id="firstName" class="form-control form-control-lg"/>
                                    <label class="form-label" for="firstName">Ім'я</label>
                                </div>

                            </div>
                            <div class="col-md-6 mb-4">

                                <div class="form-outline">
                                    <input type="text" id="lastName" class="form-control form-control-lg"/>
                                    <label class="form-label" for="lastName">Прізвище</label>
                                </div>

                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-4">

                                <h6 class="mb-2 pb-1">Стать: </h6>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                           id="femaleGender"
                                           value="option1" checked/>
                                    <label class="form-check-label" for="femaleGender">Жіноча</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                           id="maleGender"
                                           value="option2"/>
                                    <label class="form-check-label" for="maleGender">Чоловіча</label>
                                </div>


                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4 pb-2">

                                <div class="form-outline">
                                    <input type="email" id="emailAddress" class="form-control form-control-lg"/>
                                    <label class="form-label" for="emailAddress">Пошта</label>
                                </div>

                            </div>
                            <div class="col-md-6 mb-4 pb-2">

                                <div class="form-outline">
                                    <input type="tel" id="phoneNumber" class="form-control form-control-lg"/>
                                    <label class="form-label" for="phoneNumber">Номер телефону</label>
                                </div>

                            </div>
                        </div>
                        <div class="row m-2">

                            <label for="psw">Пароль</label>
                            <input type="password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            <label for="psw">Підтвердити пароль</label>
                            <input type="password" id="Check_psw" name="Check_psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>

                            <div id="message">
                                <h3>Пароль мусить містити:</h3>
                                <p id="letter" class="invalid">символ <b>нижнього регістру</b> </p>
                                <p id="capital" class="invalid">символ <b>верхнього регістру</b></p>
                                <p id="number" class="invalid"> <b>число</b></p>
                                <p id="length" class="invalid">Мінімум <b>8 знаків</b></p>
                                <p id="psw_status" class="invalid"><b>Паролі мусять збігатися</b>   </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">

                                <select class="select form-control-lg">
                                    <option value="1" disabled>Країна</option>
                                    <option value="2">Україна</option>
                                    <option value="3">Польща</option>
                                    <option value="4">Литва</option>
                                </select>
                                <label class="form-label select-label">Країна</label>

                            </div>

                        </div>
                        <div class="row m-2">
                            <div class='col-8'>
                                <label for="fileInput">

                                    <img id="image" src="images/placeholder.jpg">
                                </label>
                                <input type="file" id="fileInput" accept="image/*" style="display: none;"/>
                            </div>
                            <div class="col-4 ">
                                <button id="btnCrop" class="btn btn-primary m-2 col-12">Crop</button>
                                <button id="btnRotate" class="btn btn-primary m-2 col-12">Rotate</button>
                                <button id="btnRestore" class="btn btn-primary m-2 col-12">Restore</button>
                                <img id="preview" src="images/placeholder.jpg">
                            </div>

                        </div>

                        <div class="mt-4 pt-2">
                            <input class="btn btn-primary btn-lg" type="submit" value="Зареєструватися"/>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="js/bootstrap.bundle.min.js"></script>

<script src="js/cropper.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/mycropper.js"></script>
<script src ='js/register.js'>

</script>
</body>
</html>