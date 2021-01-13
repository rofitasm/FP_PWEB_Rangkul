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


if ($_SESSION['role'] == "O"){

    $result = mysqli_query($mysqli, "
    SELECT a.*, 
    (SELECT COUNT(*) FROM GABUNG_RELAWAN gr WHERE gr.A_ID = a.A_ID AND gr.GR_STATUS = 'Diterima') AS terdaftar
    FROM AKTIVITAS a WHERE O_ID = '".$_SESSION['o_id']."'");
}

else if ($_SESSION['role'] == "R"){

    $result = mysqli_query($mysqli, "
    SELECT a.*, 
    (SELECT COUNT(*) FROM GABUNG_RELAWAN gr WHERE gr.A_ID = a.A_ID AND gr.GR_STATUS = 'Diterima') AS terdaftar
    FROM AKTIVITAS a 
    "
);

}


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
                    <span class="text-white">hello 
                    <?php 
                    if($_SESSION['role'] == "O"){
                        echo $_SESSION['o_nama']; 
                    }
                    else if($_SESSION['role'] == "R"){
                        echo $_SESSION['r_nama']; 
                    }
                    ?>
                    !</span>
                    <input type="hidden" name="act" value="logout">
                    <input type="submit" class="btn btn-danger" value="Logout">
                </form>
            </div>
        </div>
        <div class="container text-white pb-5">
            <div class="mb-4">
                <h4>
                    <i class="icon-contact_phone"></i>
                    List Kegiatan <?=($_SESSION['role'] == 'O'? "Saya" : "")?>
                </h4>
            </div>
        </div>
    </header>

    <div class="container relative animatedParent animateOnce pull-up-lg">
      <div class="animated fadeInUpShort my-3 mb-5">
          <?php while($row = mysqli_fetch_object($result)){?>
          <div class="card my-3 no-b">
              <div class="card-body">
              <?php if($_SESSION['role']=="O") { ?>
                  <div class="col-md-2 offset-11">
                  <a class="btn btn-warning btn-sm" href="../View/editKegiatanView.php?a_id=<?= $row->A_ID ?>">
                  <i class="icon-pencil"></i>
                  </a>
                  <a class="btn btn-danger btn-sm" href="../Controller/kegiatanController.php?a_id=<?= $row->A_ID ?>&act=delete">
                  <i class="icon-trash"></i>
                  </a>
                  </div>
               <?php  }?>  
               
                  <div class="row d-md-flex align-items-center">
                      <div class="col-md-9 d-flex align-items-center">
                          <img class="mr-3 r-3" width="100" src="../assets/img/kegiatan/<?= $row->A_PATH ?>" alt="Gambar kegiatan" style="width: 400px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                          <div>
                              <h1 style="position: absolute; top: 0;"><?= $row->A_NAMA ?></h1>
                              <br><br>
                              <span><?= $row->A_DETAIL ?></span>
                              <br><br>
                              <span><i class="icon icon-map-marker"></i> <?= $row->A_LOKASI ?></span>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="col-md-12 s-24">
                              <i class="icon icon-date_range"></i>
                              <?= date('d-M-Y', strtotime($row->A_BATAS_REGIS)) ?>
                          </div>
                          <hr>
                          <div class="col-md-12 s-24">
                              <span class=""></span>
                              <i class="icon icon-people_outline"></i>
                              <?= $row->terdaftar."/".$row->A_KEBUTUHAN_RELAWAN ?>
                          </div>
                          <?php if ($_SESSION['role'] == "R"){?>
                          <br>
                          <div class="col-md-12">
                              <a type="button" class="btn btn-primary btn-sm" href="../Controller/kegiatanController.php?a_id=<?= $row->A_ID ?>&act=daftarKegiatan">
                                  <i class="icon-list"></i>
                                  Ajukan Sebagai Relawan
                              </a>
                          </div>
                          <?php }?>
                          <?php if (!$_SESSION['role'] == "R"){?>
                              <br>
                              <div class="col-md-12">
                                  <a type="button" class="btn btn-primary btn-sm"  href="listRelawanView.php?a_id=<?= $row->A_ID; ?>">
                                      <i class="icon-list"></i>
                                      Lihat Daftar Relawan
                                  </a>
                              </div>
                          <?php }?>
                      </div>
                  </div>
              </div>
          </div>
          <?php }?>
          <div class="card my-3 no-b">
              <div class="card-body">
                <?php if (!$_SESSION['role']=="R") {?> 
                  <div class="col-sm-12">
                      <center>
                      <a type="button" class="btn btn-success btn-sm" href="tambahKegiatanView.php">
                          <i class="icon-add"></i>
                          Tambah Kegiatan
                      </a>
                      </center>
                  </div>
                <?php  }?>
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
        <?php //if (isset($status)) {?>
//        swal({
//            position: 'center',
//            type: 'success',
//            title: "<?php ////echo $status;?>//",
//            showConfirmButton: false,
//            timer: 1500
//        });
        <?php //}?>

        $('#btnAdd').click(function () {
            $("#desc").val('');
            $("#priority").val('');
            $("#date").val('');
            $("#id").val('');
            $("#act").val('add');
            $('.modal-title').text('Tambah Data');
        });

        $('#datatable').on('click', '[id^=btnEdit]', function() {
            var $item = $(this).closest("tr");
            $("#desc").text($.trim($item.find(".desc").text()));
            $("#priority").val($.trim($item.find(".priority").val()));
            $("#date").val($.trim($item.find(".date").text()));
            $("#id").val($.trim($item.find(".id").val()));
            $("#act").val('edit');
            $('.modal-title').text('Edit Data');
        });

        $('#datatable').on('click', '[id^=btnDelete]', function() {
            var $item = $(this).closest("tr");
            var ID = $.trim($item.find(".id").val());
            var desc = $.trim($item.find(".desc").text());

            swal({
                    title: "Ingin menghapus data?",
                    text: "Todo " + desc + " akan dihapus",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#26C6DA",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Tidak, batalkan!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.location.href = "todoController.php?act=delete&id=" + ID;
                    } else {
                        swal("Dibatalkan", "Todo tidak jadi dihapus", "error");
                    }
                });
        });
    });
</script>
</body>
</html>