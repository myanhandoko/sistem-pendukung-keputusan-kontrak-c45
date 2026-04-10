<?php
include 'koneksi.php';
session_start();
ob_start();
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

?>
<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta5
* @link https://tabler.io
* Copyright 2018-2022 The Tabler Authors
* Copyright 2018-2022 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>PT. Duta Agung Jaya</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
    <link rel='stylesheet' href='https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap4.css'>

    <!-- js -->
    <script src="js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap4.js"></script>

    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="ckfinder/ckfinder.js"></script>

    <style>
    .page-body{
      padding-bottom: 100px;
    }
    #map-input{
      height: 360px;
      width: 100%;
      border-width: 1px;
      border-color: #2196F3;
      border-style: solid;
      margin-bottom: 10px;
      z-index: 1;
    }
    .leaflet-control-container .leaflet-routing-container-hide {
  		display: none;
  	}

  	.leaflet-control-search .search-input{
  		font-family: "Open Sans";
  		font-size: 12px;
  	}

  	.leaflet-popup-content-wrapper {
  		font-family: "Open Sans";
  	}
    .leaflet-control-search .search-cancel {
  		position: static;
  		float: left;
  		margin-left: -22px;
  	}
    .page-title, .page-pretitle{
      color: #ffffff;
    }
    .ckeditor{
      font-family: 'Titillium Web';
    }
    .bg-warning {
      background: #00aeed !important;
    }
    </style>
  </head>
  <body >
    <div class="wrapper">
      <header class="navbar navbar-expand-md navbar-overlap d-print-none bg-warning">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
              <img src="./static/logo.png" height="50" alt="Tabler" class="navbar-brand-image">
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
              <?php
              if(isset($_SESSION['id_pengguna'])){
                $id_pengguna = $_SESSION['id_pengguna'];
                $query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE id_pengguna='".$id_pengguna."' LIMIT 1");
                $result=mysqli_fetch_array($query);
                $nama = $result['nama'];

              }
              ?>
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <span class="avatar avatar-sm" style="background-image: url(./static/avatar.png);"></span>
                <div class="d-none d-xl-block ps-2">
                  <div class="text-white"><?php echo $nama ?></div>
                  <div class="mt-1 small text-white"><?php echo $_SESSION['level'] ?></div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="login.php?aksi=out" class="dropdown-item">Logout</a>
              </div>
            </div>
          </div>
          <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
              <ul class="navbar-nav">
                <?php if($_SESSION['level']=="Administrator") { ?>
                <li class="nav-item <?php if(!isset($_GET['page'])){ echo "active"; } ?>">
                  <a class="nav-link" href="home.php" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block text-white"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                    </span>
                    <span class="nav-link-title text-white">
                      Variabel
                    </span>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-white" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block text-white"><!-- Download SVG icon from http://tabler-icons.io/i/star -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17.8 19.817l-2.172 1.138a0.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a0.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a0.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a0.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a0.39 .39 0 0 1 -.567 .411l-2.172 -1.138z" /><path d="M6.2 19.817l-2.172 1.138a0.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a0.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a0.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a0.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a0.39 .39 0 0 1 -.567 .411l-2.172 -1.138z" /><path d="M12 9.817l-2.172 1.138a0.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a0.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a0.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a0.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a0.39 .39 0 0 1 -.567 .411l-2.172 -1.138z" /></svg>
                    </span>
                    <span class="nav-link-title text-white">
                      Pilihan Variabel
                    </span>
                  </a>
                  <div class="dropdown-menu">
                    <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM variabel WHERE jenis='Pilihan'");
                    $i = 1;
                    while($result=mysqli_fetch_array($query)) {
                      $id=$result['id_variabel'];
                      $nama=$result['nama'];
                    ?>
                    <a class="dropdown-item" href="?page=subvariabel&id_variabel=<?php echo $id ?>" >
                      <?php echo $nama ?>
                    </a>
                    <?php
                    }
                    ?>
                  </div>
                </li>

                <li class="nav-item <?php if($_GET['page']=="karyawan"){ echo "active"; } ?>">
                  <a class="nav-link" href="?page=karyawan" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block text-white"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                    </span>
                    <span class="nav-link-title text-white">Karyawan</span>
                  </a>
                </li>

                <li class="nav-item <?php if($_GET['page']=="pohon"){ echo "active"; } ?>">
                  <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <span class="nav-link-icon d-md-none d-lg-inline-block text-white"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                    	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 13l-2 -2" /><path d="M12 12l2 -2" /><path d="M12 21v-13" /><path d="M9.824 15.995a3 3 0 0 1 -2.743 -3.69a2.998 2.998 0 0 1 .304 -4.833a3 3 0 0 1 4.615 -3.707a3 3 0 0 1 4.614 3.707a2.997 2.997 0 0 1 .305 4.833a3 3 0 0 1 -2.919 3.695h-4z" /></svg>
                    </span>
                    <span class="nav-link-title text-white">Pohon & Aturan</span>
                  </a>
                </li>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-white" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block text-white"><!-- Download SVG icon from http://tabler-icons.io/i/star -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" /><circle cx="16.5" cy="17.5" r="2.5" /><line x1="18.5" y1="19.5" x2="21" y2="22" /></svg>
                    </span>
                    <span class="nav-link-title text-white">
                      Analisa & Evaluasi
                    </span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-testing">Analisa ID3</a>
                    <a class="dropdown-item" href="?page=evaluasi" >Evaluasi Model</a>
                  </div>
                </li>

                <li class="nav-item <?php if($_GET['page']=="baru"){ echo "active"; } ?>">
                  <a class="nav-link" href="?page=baru" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block text-white"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="3" y1="18" x2="17" y2="18" /><path d="M9 9l3 3l-3 3" /><path d="M14 15l3 3l-3 3" /><line x1="3" y1="3" x2="3" y2="21" /><line x1="3" y1="12" x2="12" y2="12" /><path d="M18 3l3 3l-3 3" /><line x1="3" y1="6" x2="21" y2="6" /></svg>
                    </span>
                    <span class="nav-link-title text-white">
                      Data Baru
                    </span>
                  </a>
                </li>

                <?php
                }
                if($_SESSION['level']=="Pimpinan"){
                ?>

                <li class="nav-item <?php if($_GET['page']=="pengumuman"){ echo "active"; } ?>">
                  <a class="nav-link" href="?page=pengumuman" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block text-white"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 8a3 3 0 0 1 0 6" /><path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5" /><path d="M12 8h0l4.524 -3.77a0.9 .9 0 0 1 1.476 .692v12.156a0.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8" /></svg>
                    </span>
                    <span class="nav-link-title text-white">
                      Pengumuman
                    </span>
                  </a>
                </li>
                <?php } ?>
                <li class="nav-item">
                  <a class="nav-link" href="lap_analisa.php" target="_blank">
                    <span class="nav-link-icon d-md-none d-lg-inline-block text-white"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg>
                    </span>
                    <span class="nav-link-title text-white">
                      Lap. Analisa
                    </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </header>

      <div class="page-wrapper">
        <?php
        include 'section.php';
        ?>
        <footer class="footer footer-transparent d-print-none text-white fixed-bottom bg-warning">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Copyright &copy; 2025
                    <a href="." class="text-white">PT. Duta Agung Jaya</a>.
                    All rights reserved.
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tampilkan Pohon & Aturan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="post" action="?page=pohon">
            <div class="modal-body">
              <input type="hidden" name="jenis" value="<?php echo "Training" ?>" />
              <label>Mulai dari data ke</label>
              <input type="number" value="<?php echo "1" ?>" class="form-control mb-3" placeholder="Data Awal" autocomplete="off" aria-label="Nama" name="min">
              <label>Hingga data ke</label>
              <input type="number" value="<?php echo "950" ?>" name="max" class="form-control mb-3"  id="w3lName" placeholder="Data Akhir" required autocomplete="off">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Lanjut</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal modal-blur fade" id="modal-testing" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Mulai Analisa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="post" action="?page=analisa">
            <div class="modal-body">
              <input type="hidden" name="jenis" value="<?php echo "Testing" ?>" />
              <label>Mulai dari data ke</label>
              <input type="number" value="<?php echo "951" ?>" class="form-control mb-3" placeholder="Data Awal" autocomplete="off" aria-label="Nama" name="min">
              <label>Hingga data ke</label>
              <input type="number" value="<?php echo "975" ?>" name="max" class="form-control mb-3"  id="w3lName" placeholder="Data Akhir" required autocomplete="off">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Lanjut</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <script src="./dist/libs/apexcharts/dist/apexcharts.min.js"></script>
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js"></script>
    <script src="./dist/js/demo.min.js"></script>

    <script>
      $(document).ready(function(){
        new DataTable('#example, #example1, #example2, #example3, #example4', {
          "ordering": false,
        });
      });
    </script>
  </body>
</html>
