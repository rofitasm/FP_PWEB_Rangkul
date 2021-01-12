<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/basic/favicon.ico" type="image/x-icon">
    <title>Login - Rangkul</title>
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
</head>
<body class="light">
<!-- Pre loader -->
<?php include('Partials/_loader.php')?>
<div id="app">
    
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Halo! ingin Register Sebagai?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a href="registerOrganisasi.php">
                        <button type="submit" class="col-4 btn btn-primary" name="act" value="toRegOrganisasi">Organisasi</button>
                    </a>
                    <a href="registerRelawan.php">
                        <button type="submit" class="col-4 btn btn-primary" name="act" value="toRegRelawan">Relawan</button>
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                </div>
            </div>
        </div>
    </div>

    <main>
        <div id="primary" class="p-t-b-100 height-full">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mx-md-auto paper-card">
                        <div class="text-center">
                            <img src="assets/img/dummy/u4.png" alt="">
                            <h3 class="mt-2">Selamat Datang di Rangkul!</h3>
                            <p class="p-t-b-20"></p>
                        </div>
                        <form action="Controller/authController.php" method="post">
                            <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                                <input type="email" name="email" class="form-control form-control-lg"
                                       placeholder="Email Address">
                            </div>
                            <div class="form-group has-icon"><i class="icon-user-secret"></i>
                                <input type="password" name="password" class="form-control form-control-lg"
                                       placeholder="Password">
                            </div>
                            <input type="hidden" name="act" value="login">
                            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Log In">
                        </form>
                        <div class="text-center "> OR </div>
                        <button type="button" class="btn btn-secondary btn-lg btn-block" id="toRegister" data-toggle="modal" data-target="#exampleModal" > Register </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- #primary -->
    </main>
</div>
<!--/#app -->
<script src="assets/js/app.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).bind("ready",f)})})(jQuery,document)</script>
<script>
    $(document).ready(function() {

        $('#toRegister').click(function () {
            $("#name").val('');
            $("#email").val('');
            $("#address").val('');
            $("#city").val('');
            $("#msg").val('');
            $("#id").val('');
            $("#act").val('add');
            $('.modal-title').text('Halo! ingin Register Sebagai Apa?');
        });

    });
</script>
</body></html>