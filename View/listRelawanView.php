<?php
// Create database connection using config file
include_once("../Config/condb.php");

session_start();

?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/img/basic/favicon.ico" type="image/x-icon">
    <title>Rangkul</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="../assets/css/sweetalert.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
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

<?php
if (!isset($_SESSION['id_login'])){
    mysqli_close($mysqli);
    header("Location: ../index.php");
    die();
}

// Fetch all aktivitas data from database
$result = mysqli_query($mysqli, "
    SELECT gr.*, r.`R_NAMA`, r.`R_PROFESI`, r.`R_TELP`, r.`R_KOTA_DOM`
    FROM GABUNG_RELAWAN gr, RELAWAN r
    WHERE gr.`R_ID` = r.`R_ID`
    AND gr.`A_ID` = '".$_GET['a_id']."'");
?>

<body class="light sidebar-collapse sidebar-offCanvas-lg">
<!-- Pre loader -->
<?php include('../Partials/_loader.php')?>
<div id="app">
    <div class="page">
        <header class="indigo lighten-2 relative shadow pb-5">
            <div class="navbar navbar-expand navbar-dark d-flex justify-content-between bd-navbar">
                <div class="relative offset-9" style="height: 50px;">
                    <form action="../Controller/authController.php" method="post">
                        <span class="text-white">hello <b><?= $_SESSION['o_nama']; ?></b>!</span>
                        <input type="hidden" name="act" value="logout">
                        <input type="submit" class="btn btn-danger" value="Logout">
                    </form>
                </div>
            </div>
            <div class="container text-white pb-5">
                <div class="mb-4">
                    <h4>
                        <i class="icon-contact_phone"></i>
                        List Relawan
                    </h4>
                </div>
            </div>
        </header>

        <div class="container relative animatedParent animateOnce pull-up-lg">
            <div class="animated fadeInUpShort my-3 mb-5">
                <div class="card my-3 no-b">
                        <div class="card-body">
                            <a href="kegiatanView.php" class="btn btn-primary btn-sm" style="margin-bottom: 10px">
                                <i class="icon-angle-left"></i>
                                Kembali
                            </a>
                            <table class="table table-bordered table-hover data-tables"
                                   data-options='{"searching":true}' id="datatable">
                                <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Telepon</th>
                                    <th>Profesi</th>
                                    <th>Kota Domisili</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while($row = mysqli_fetch_array($result)){
                                    $status = '';
                                    if($row['GR_STATUS'] == "Diterima"){
                                        $status = 'bg-success text-white';
                                    }
                                    else if($row['GR_STATUS'] == "Ditolak"){
                                        $status = 'bg-danger text-white';
                                    }
                                    ?>
                                    <tr class="<?= $status ?>">
                                        <input class="r_id" type="hidden" value="<?= $row['R_ID']; ?>">
                                        <input class="a_id" type="hidden" value="<?= $row['A_ID']; ?>">
                                        <td class="nama"><?= $row['R_NAMA']; ?></td>
                                        <td class="telp"><?= $row['R_TELP']; ?></td>
                                        <td class="telp"><span class="badge badge-dark r-3"><?= $row['R_PROFESI']; ?></span></td>
                                        <td class="kota"><?= $row['R_KOTA_DOM']; ?></td>
                                        <td>
                                            <?php if ($row['GR_STATUS'] == "Menunggu"){?>
                                            <button type="button" class="btn btn-success btn-sm" id="btnAcc">
                                                <i class="icon-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" id="btnTolak">
                                                <i class="icon-close"></i>
                                            </button>
                                            <?php }?>
                                        </td>
                                    </tr>
                                <?php }
                                mysqli_close($mysqli);
                                ?>
                                </tfoot>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/app.js"></script>
<script src="../assets/js/sweetalert.min.js"></script>
<script>(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).bind("ready",f)})})(jQuery,document)</script>
<script>
    $(document).ready(function() {
//        $('#datatable').DataTable( {
//            dom: 'Bfrtip',
//            buttons: [
//                'copy', 'csv', 'excel', 'pdf', 'print'
//            ]
//        } );


        <?php //if (isset($status)) {?>
//        swal({
//            position: 'center',
//            type: 'success',
//            title: "<?php ////echo $status;?>//",
//            showConfirmButton: false,
//            timer: 1500
//        });
        <?php //}?>

        $('#datatable').on('click', '[id^=btnAcc]', function() {
            var $item = $(this).closest("tr");
            var R_ID = $.trim($item.find(".r_id").val());
            var A_ID = $.trim($item.find(".a_id").val());
            var nama = $.trim($item.find(".nama").text());

            swal({
                    title: "Ingin memvalidasi relawan?",
                    text: "Relawan dengan nama " + nama + " akan divalidasi",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#26C6DA",
                    confirmButtonText: "Ya, validasi!",
                    cancelButtonText: "Tidak, batalkan!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.location.href = "../Controller/kegiatanController.php?act=acc&r_id=" + R_ID + "&a_id=" + A_ID;
                    } else {
                        swal("Dibatalkan", "Relawan tidak jadi divalidasi", "error");
                    }
                });
        });

        $('#datatable').on('click', '[id^=btnTolak]', function() {
            var $item = $(this).closest("tr");
            var R_ID = $.trim($item.find(".r_id").val());
            var A_ID = $.trim($item.find(".a_id").val());
            var nama = $.trim($item.find(".nama").text());

            swal({
                    title: "Ingin menolak relawan?",
                    text: "Relawan dengan nama " + nama + " akan ditolak",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#26C6DA",
                    confirmButtonText: "Ya, validasi!",
                    cancelButtonText: "Tidak, batalkan!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.location.href = "../Controller/kegiatanController.php?act=tolak&r_id=" + R_ID + "&a_id=" + A_ID;
                    } else {
                        swal("Dibatalkan", "Relawan tidak jadi divalidasi", "error");
                    }
                });
        });
    });
</script>
</body>
</html>