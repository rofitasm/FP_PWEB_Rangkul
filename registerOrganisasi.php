<?php
// Create database connection using config file
include_once("Config/condb.php");
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/basic/favicon.ico" type="image/x-icon">
    <title>Register - Rangkul</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/app.css">
    <style>
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>
    <script>(function(w,d,u){w.readyQ=[];w.bindReadyQ=[];function p(x,y){if(x=="ready"){w.bindReadyQ.push(y);}else{w.readyQ.push(x);}};var a={ready:p,bind:p};w.$=w.jQuery=function(f){if(f===d||f===u){return a}else{p(f)}}})(window,document)</script>
    <script>
        function validateUsername(field) {
            if (field == "")
                return "No Name was entered.\n";
            else if (field.length < 5)
                return "Name must be at least 5 characters.\n";
            else if (/[^a-zA-Z0-9_-]/.test(field))
                return "Only a-z, A-Z, 0-9, - and _ allowed in Name.\n";
            return "";
        }

        function validateTelp(field) {
            if (field == "")
                return "Telephone number is empty\n";
            else if (/[^0-9]/.test(field))
                return "Only 0-9 allowed in Telephone Number\n";
            return "";
        }

        function validatePassword(field) {
            if (field == "") return "No Password was entered.\n";
            else if (field.length < 6)
                return "Passwords must be at least 6 characters.\n";
            else if (!/[a-z]/.test(field) || ! /[A-Z]/.test(field) ||
                !/[0-9]/.test(field))
                return "Passwords require one each of a-z, A-Z and 0-9.\n";
            return ""
        }

        function validate(form) {
            var fail = "";
            fail += validateUsername(form.nama.value);
            fail += validatePassword(form.password.value);
            fail += validateTelp(form.telp.value);
            if (fail == "") return true
            else {
                alert(fail); return false
            }
        }
    </script>
</head>
<body class="light">
<!-- Pre loader -->
<div id="loader" class="loader">
    <div class="plane-container">
        <div class="preloader-wrapper small active">
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="app">
    <main>
        <div id="primary" class="p-t-b-100 height-full">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mx-md-auto paper-card">
                        <div class="text-center" style="margin-bottom: 10px">
                            <h3>Register Organisasi</h3>
                            <span>Mari beri kesempatan para relawan untuk bisa membantu!</span>
                        </div>
                        <form action="Controller/authController.php" method="post" id="regOr" onsubmit="return validate(this);">
                            <label for="nama">Nama Organisasi</label>
                            <div class="form-group has-icon"><i class="icon-text_fields"></i>
                                <input type="text" name="nama" class="form-control form-control-lg"
                                       placeholder="Nama Organisasi" id="nama">
                            </div>
                            <label for="telp">No Telepon</label>
                            <div class="form-group has-icon"><i class="icon-phone"></i>
                                <input type="text" name="telp" class="form-control form-control-lg"
                                       placeholder="No Telepon" id="telp">
                            </div>
                            <label for="tglBerdiri">Tanggal Berdiri</label>
                            <div class="form-group has-icon"><i class="icon-calendar"></i>
                                <input type="date" name="tglBerdiri" class="form-control form-control-lg" id="tglBerdiri">
                            </div>
                            <label for="deskripsi">Deskripsi Organisasi</label>
                            <div class="form-group has-icon">
                                <textarea name="deskripsi" class="form-control" form="regOr"></textarea>
                            </div>
                            <label for="web">Alamat Website</label>
                            <div class="form-group has-icon"><i class="icon-id-card"></i>
                                <input type="text" name="web" class="form-control form-control-lg"
                                       placeholder="Alamat Website" id="web">
                            </div>
                            <label for="lokasi">Alamat Lokasi</label>
                            <div class="form-group has-icon"><i class="icon-map-marker"></i>
                                <input type="text" name="lokasi" class="form-control form-control-lg"
                                       placeholder="Alamat Lokasi" id="lokasi">
                            </div>
                            <label for="email">Email</label>
                            <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                                <input type="email" name="email" class="form-control form-control-lg"
                                       placeholder="Email" required>
                            </div>
                            <label for="password">Password</label>
                            <div class="form-group has-icon"><i class="icon-user-secret"></i>
                                <input type="password" name="password" class="form-control form-control-lg"
                                       placeholder="Password" id="password">
                            </div>
                            <input type="hidden" name="act" value="registerOrganisasi">
                            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Register">
                            <p class="forget-pass"><a href="index.php">Log in Now</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #primary -->
    </main>
</div>
<!--/#app -->
<script src="assets/js/app.js"></script>
<script>(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).bind("ready",f)})})(jQuery,document)</script>
</body></html>