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
    <link rel="stylesheet" href="../assets/css/filepond.min.css">
    <link rel="stylesheet" href="../assets/css/filepond-plugin-image-edit.css">
    <link rel="stylesheet" href="../assets/css/filepond-plugin-image-preview.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/ui/trumbowyg.min.css">
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
$result = mysqli_query($mysqli, "SELECT * FROM aktivitas WHERE A_ID = '".$_GET['a_id']."'");
// Fetch all aktivitas data from database
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
                        <i class="icon-add"></i>
                        Edit Kegiatan
                    </h4>
                </div>
            </div>
        </header>

        <div class="container relative animatedParent animateOnce pull-up-lg">
            <div class="animated fadeInUpShort my-3 mb-5">
                <div class="card my-3 no-b">
                    <div class="card-body">
                        <div class="row">
                            <form action="../Controller/kegiatanController.php" method="post" enctype="multipart/form-data" class="col-md-12">
                                <?php while($row = mysqli_fetch_object($result)){?>
                                <div class="form-group">
                                    <label for="nama" class="col-form-label">Nama</label>
                                    <input type="text" name="a_nama" id="nama" class="form-control" required value="<?= $row->A_NAMA ?>">
                                </div>
                                <div class="form-group">
                                    <label for="lokasi" class="col-form-label">Lokasi</label>
                                    <input type="text" name="a_lokasi" id="lokasi" class="form-control" required value="<?= $row->A_LOKASI ?>">
                                </div>
                                <div class="form-group">
                                    <label for="batas_regis" class="col-form-label">Batas Regis</label>
                                    <input type="date" class="form-control" id="batas_regis" name="a_batas_regis" placeholder="Date" required value="<?= date('Y-m-d', strtotime($row->A_BATAS_REGIS)) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="kebutuhan_relawan" class="col-form-label">Kebutuhan Relawan</label>
                                    <input type="number" name="a_kebutuhan_relawan" id="kebutuhan_relawan" class="form-control" required value="<?= $row->A_KEBUTUHAN_RELAWAN ?>">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control detail" name="a_detail" placeholder="Detail Kegiatan"><?= $row->A_DETAIL?></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="file" class="filepond" name="a_path" data-allow-reorder="true" data-max-file-size="1MB" data-max-files="3">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="act" value="edit">
                                    <input type="hidden" name="a_id" value="<?= $_GET['a_id'] ?>">
                                    <center><a href="kegiatanView.php" class="btn btn-danger">Kembali</a>
                                    <input type="submit" class="btn btn-primary" value="Simpan"></center>
                                </div>
                                <?php }?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
<script src="../assets/js/app.js"></script>
<script src="../assets/js/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/trumbowyg.min.js"></script>
<script src="../assets/js/filepond.min.js"></script>
<script src="../assets/js/filepond-plugin-file-validate-size.js"></script>
<script src="../assets/js/filepond-plugin-file-validate-type.js"></script>
<script src="../assets/js/filepond-plugin-image-exif-orientation.js"></script>
<script src="../assets/js/filepond-plugin-image-preview.js"></script>
<script>(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).bind("ready",f)})})(jQuery,document)</script>
<script>
    $(document).ready(function() {
        $('.detail').trumbowyg();

        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageExifOrientation,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType,
        );

       FilePond.create(
            document.querySelector('input[name="fa_path"]'), {
                labelIdle: 'Geser dan Letakkan gambar atau <span class="filepond--label-action">Cari</span>',
                imagePreviewHeight: 170,
                imageCropAspectRatio: '1:1',
                acceptedFileTypes : ['image/*'],
                labelFileTypeNotAllowed : 'Hanya gambar yang diperbolehkan',
                imageResizeTargetWidth: 200,
                imageResizeTargetHeight: 200,
            }
        );
    });
</script>
</body>
</html>