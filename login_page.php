<?php
include 'koneksi.php';
session_start();
ob_start();
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

    <link rel="stylesheet" href="js/leaflet/leaflet-search.min.css" />
    <link rel="stylesheet" href="js/leaflet/leaflet.css" />
    <link rel="stylesheet" href="js/leaflet/leaflet.coordinates-0.1.5.css" />
    <link rel="stylesheet" href="js/route/leaflet-routing-machine.css" />
    <!-- //custom Theme files -->
    <!-- js -->
    <script src="js/jquery.min.js"></script>
    <script src="js/leaflet/leaflet.js"></script>
    <script src="js/leaflet/leaflet.coordinates-0.1.5.min.js"></script>
    <script src="js/route/leaflet-routing-machine.js"></script>
    <script src="js/route/lrm-graphhopper.js"></script>
    <script src="js/leaflet/leaflet-search.min.js"></script>

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
              <img src="./static/logo.png" height="32" alt="Tabler" class="navbar-brand-image">
            </a>
          </h1>

          <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
              <ul class="navbar-nav">
                <li class="nav-item <?php if(!isset($_GET['page'])){ echo "active"; } ?>">
                  <a class="nav-link" href="index.php">
                    <span class="nav-link-icon d-md-none d-lg-inline-block text-white"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title text-white">
                      Beranda
                    </span>
                  </a>
                </li>
                <li class="nav-item <?php if(!isset($_GET['page'])){ echo "active"; } ?>">
                  <a class="nav-link" href="pengumuman.php">
                    <span class="nav-link-icon d-md-none d-lg-inline-block text-white"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title text-white">
                      Pengumuman Insentif
                    </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="login_page.php">
                    <span class="nav-link-icon d-md-none d-lg-inline-block text-white"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title text-white">
                      Login Pengguna
                    </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </header>

      <div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Halaman
                </div>
                <h2 class="page-title">
                  Login Pengguna
                </h2>
              </div>
              <!-- Page title actions -->
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <form class="card col-4 card-md" action="login.php" method="post" autocomplete="off">
              <div class="card-body">
                <h2 class="text-dark mb-3">Login Pengguna</h2>
                <p class="small">Login sebagai Administrator atau Pimpinan</p>
                <?php
                if(isset($_SESSION['success'])){
                  if($_SESSION['success']==1){
                    echo "<div class=\"alert alert-primary\">".$_SESSION['message']."</div>";
                  } else {
                    echo "<div class=\"alert alert-warning\">".$_SESSION['message']."</div>";
                  }
                  unset($_SESSION['success']);
                }
                ?>
                <div class="mb-3">
                  <label class="form-label">Username</label>
                  <input type="text" required autocomplete="off" name="username" class="form-control" placeholder="Username">
                </div>
                <div class="mb-2">
                  <label class="form-label">Password</label>
                  <div class="input-group input-group-flat">
                    <input type="password" class="form-control" name="password" placeholder="Password"  autocomplete="off">
                  </div>
                </div>

                <div class="form-footer">
                  <button type="submit" class="btn btn-danger w-100">Login</button>
                </div>

              </div>
            </form>
          </div>
        </div>
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
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New report</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Your report name">
            </div>
            <label class="form-label">Report type</label>
            <div class="form-selectgroup-boxes row mb-3">
              <div class="col-lg-6">
                <label class="form-selectgroup-item">
                  <input type="radio" name="report-type" value="1" class="form-selectgroup-input" checked>
                  <span class="form-selectgroup-label d-flex align-items-center p-3">
                    <span class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </span>
                    <span class="form-selectgroup-label-content">
                      <span class="form-selectgroup-title strong mb-1">Simple</span>
                      <span class="d-block text-white">Provide only basic data needed for the report</span>
                    </span>
                  </span>
                </label>
              </div>
              <div class="col-lg-6">
                <label class="form-selectgroup-item">
                  <input type="radio" name="report-type" value="1" class="form-selectgroup-input">
                  <span class="form-selectgroup-label d-flex align-items-center p-3">
                    <span class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </span>
                    <span class="form-selectgroup-label-content">
                      <span class="form-selectgroup-title strong mb-1">Advanced</span>
                      <span class="d-block text-white">Insert charts and additional advanced analyses to be inserted in the report</span>
                    </span>
                  </span>
                </label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Report url</label>
                  <div class="input-group input-group-flat">
                    <span class="input-group-text">
                      https://tabler.io/reports/
                    </span>
                    <input type="text" class="form-control ps-0"  value="report-01" autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Visibility</label>
                  <select class="form-select">
                    <option value="1" selected>Private</option>
                    <option value="2">Public</option>
                    <option value="3">Hidden</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Client name</label>
                  <input type="text" class="form-control">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Reporting period</label>
                  <input type="date" class="form-control">
                </div>
              </div>
              <div class="col-lg-12">
                <div>
                  <label class="form-label">Additional information</label>
                  <textarea class="form-control" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <a href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
              <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              Create new report
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <script src="./dist/libs/apexcharts/dist/apexcharts.min.js"></script>
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js"></script>
    <script src="./dist/js/demo.min.js"></script>
    <script src="js/instascan.min.js"></script>
    <script>
    if (window.location.href.indexOf("scan") > -1) {
      let scanner = new Instascan.Scanner({video: document.getElementById('preview')});
      scanner.addListener('scan', function(content){
        $("#id_transaksi").val(content);
      });
      Instascan.Camera.getCameras().then(function(cameras){
        if (cameras.length > 1) {
            scanner.start(cameras[1]);
        } else if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            console.error('No cameras found.');
        }
      }).catch(function(e){
        alert(e);
      });
    }
      $(document).ready(function(){
        $("#koordinat").click(function(){
          $("#modaltambah").modal('show');
          return false;
        });
        $("#koordinatedit").click(function(){
          $("#modaledit").modal('show');
          return false;
        });
      });
    </script>
  </body>
</html>
