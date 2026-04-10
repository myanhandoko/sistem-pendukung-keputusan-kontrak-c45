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
          Beranda
        </h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="row">
      <div class="col-4">
        <form class="card p-3" action="login.php" method="post" autocomplete="off">
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
              <button type="submit" class="btn btn-info w-100">Login</button>
            </div>
            <hr />
            <h2>Lihat Pengumuman</h2>
            <p>Jika anda karyawan PT. Duta Agung Jaya, lihat pengumuman pengangkatan di menu Pengumuman</p>
          </div>
        </form>
      </div>
      <div class="col-8">
        <div class="card">
          <div class="card-body px-4 py-3">
            <h1 class="mt-2">PT. Duta Agung Jaya</h1>
            <h5>Jl. Rawe Raya Pasar VI No.28-29, Tangkahan, Kec. Medan Labuhan, Kota Medan, Sumatera Utara 20251</h5>
            <h5>(061) 88810459</h5>
            <img class="mb-3" src="static/banner.jpg" style="width:100%" />
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
