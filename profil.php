<?php
if(isset($_GET['aksi'])){
  $nama = $_POST['nama'];
  $password = $_POST['password'];
  $handphone = $_POST['handphone'];
  $alamat = $_POST['alamat'];
  $kriteria = $_POST['kriteria'];
  $sub = $_POST['sub'];
  $foto = $_FILES['foto']['name'];
  $dokumen = $_FILES['dokumen']['name'];

  $query = "UPDATE pelamar SET nama='".$nama."', password='".$password."', alamat='".$alamat."'";

  if($foto != ""){
    $foto = str_replace(".png", "", $foto);
    $foto = str_replace(".jpg", "", $foto);
    $foto_name = str_replace(" ", "_", $foto);
    $foto_name .= "foto".date('d-m-Y_hia').".png";
    $query .= ", foto='".$foto_name."'";
  }

  if($dokumen != ""){
    $dokumen = str_replace(".pdf", "", $dokumen);
    $dok_name = str_replace(" ", "_", $dokumen);
    $dok_name .= "dok".date('d-m-Y_hia').".pdf";
    $query .= ", dokumen='".$dok_name."'";
  }

  $query .= " WHERE id_pelamar='".$_SESSION['id_pelamar']."'";

  $result = mysqli_query($koneksi, $query) or die(mysqli_error($query));
  if ($result) {
    $id_pelamar = $_SESSION['id_pelamar'];

    for($i=0; $i<count($kriteria); $i++){
      $query3 = mysqli_query($koneksi, "SELECT * FROM kriteria WHERE id_kriteria='".$kriteria[$i]."'");
      $result3 = mysqli_fetch_array($query3);
      $id_subkriteria = $sub[$i];
      if($result3['jenis']=="Angka Dengan Range"){
        $query4 = mysqli_query($koneksi, "SELECT * FROM subkriteria WHERE id_kriteria='".$kriteria[$i]."' AND min <= '".$sub[$i]."' AND max >= '".$sub[$i]."'");
        if($result4 = mysqli_fetch_array($query4)){
          $id_subkriteria = $result4['id_subkriteria'];
        }
      }

      $query2 = "DELETE FROM kriteria_pelamar WHERE id_pelamar='".$id_pelamar."' AND id_kriteria='".$kriteria[$i]."'";
      $result2 = mysqli_query($koneksi, $query2) or die(mysqli_error($query2));

      $query2 = "INSERT INTO kriteria_pelamar(id_pelamar, id_kriteria, id_subkriteria, nilai_inputan) VALUES('".$id_pelamar."', '".$kriteria[$i]."', '".$id_subkriteria."', '".$sub[$i]."')";
      $result2 = mysqli_query($koneksi, $query2) or die(mysqli_error($query2));
    }
    if($foto != ""){
      move_uploaded_file($_FILES['foto']['tmp_name'], "dokumen/".$foto_name);
    }
    if($dokumen != ""){
      move_uploaded_file($_FILES['dokumen']['tmp_name'], "dokumen/".$dok_name);
    }
    $_SESSION['success']= 1;
    $_SESSION['message']= "Profil Anda Berhasil Diupdate";
    header('location:index.php?page=profil');
  } else {
    $_SESSION['success']= 0;
    $_SESSION['message']= "Update Gagal, Kesalahan Sistem, Coba Lagi Nanti...";
    header('location:index.php?page=profil');
  }
} else {
  $query = mysqli_query($koneksi, "SELECT * FROM pelamar WHERE id_pelamar='".$_SESSION['id_pelamar']."'");
  $result=mysqli_fetch_array($query);
  $id=$result['id_pelamar'];
  $nama_alt=$result['nama'];
  $no_registrasi=$result['no_registrasi'];
  $alamat=$result['alamat'];
  $foto=$result['foto'];
  $password=$result['password'];
  $dokumen=$result['dokumen'];
  $handphone=$result['handphone'];
?>
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
          Profil
        </h2>
      </div>
      <!-- Page title actions -->
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <form class="card card-md" action="?page=profil&aksi=profil" enctype="multipart/form-data" method="post" autocomplete="off">
      <div class="card-body">
        <h2 class="text-primary mb-3">Profil Anda</h2>
        <?php
        if(isset($_SESSION['success'])){
          if($_SESSION['success']==1){
            echo "<div class=\"alert alert-primary bg-primary text-white\">".$_SESSION['message']."</div>";
          } else {
            echo "<div class=\"alert alert-warning bg-warning text-white\">".$_SESSION['message']."</div>";
          }
          unset($_SESSION['success']);
        }
        ?>
        <div class="row">
          <div class="col-md-4">
            <label class="fw-bold">Nama Lengkap</label>
            <input type="text" value="<?php echo $nama_alt ?>" class="form-control mb-3" placeholder="Nama Lengkap" autocomplete="off" aria-label="Nama" name="nama" required>
          </div>
          <div class="col-md-4">
            <label class="fw-bold">Handphone</label>
            <input type="text" value="<?php echo $handphone ?>" class="form-control mb-3" placeholder="Handphone" maxlength="12" autocomplete="off" aria-label="Handphone" name="handphone" required>
          </div>
          <div class="col-md-4">
            <label class="fw-bold">Password</label>
            <input type="password" value="<?php echo $password ?>" class="form-control mb-3" placeholder="Password" autocomplete="off" aria-label="Password" name="password">
          </div>
          <div class="col-md-8">
            <label class="fw-bold">Alamat</label>
            <input type="alamat" value="<?php echo $alamat ?>" class="form-control mb-3" placeholder="Alamat" autocomplete="off" aria-label="Alamat" name="alamat" required>
          </div>

          <div class="col-md-4">
            <label class="fw-bold">Pas Foto (JPEG / PNG)</label>
            <input type="file" class="form-control mb-3" placeholder="Foto" autocomplete="off" aria-label="Foto" name="foto">
          </div>
          <div class="col-md-12">
            <label class="fw-bold">Berkas Lamaran (ZIP/RAR)</label><br />
            <label style="font-size:12px;">Gabungkan semua berkas menjadi 1 file ZIP/RAR, yang isinya terdapat Scan Ijazah Pendidikan Terakhir, Scan KTP, Scan CV / Resume</label>
            <input type="file" class="form-control mb-3" placeholder="Foto" autocomplete="off" aria-label="Dokumen" name="dokumen" required>
          </div>
          <?php
          $query = mysqli_query($koneksi, "SELECT * FROM kriteria WHERE penginput='Diinput Calon Karyawan'");
          while($result=mysqli_fetch_array($query)) {
            $id_kriteria = $result['id_kriteria'];
            $nama = $result['nama'];
            $jenis = $result['jenis'];
            $satuan = $result['satuan'];

            $query4 = mysqli_query($koneksi, "SELECT * FROM kriteria_pelamar WHERE id_kriteria='".$id_kriteria."'
            AND id_pelamar='".$_SESSION['id_pelamar']."'");
            $result4 = mysqli_fetch_array($query4);
            $id_subkriteria = $result4['id_subkriteria'];
            $nilai_inputan = $result4['nilai_inputan'];
          ?>
          <div class="col-md-4">
            <input type="hidden" name="kriteria[]" value="<?php echo $id_kriteria ?>" />
            <?php
            if($satuan==""){
            ?>
            <label class="fw-bold"><?php echo $nama ?></label>
            <?php
            } else {
            ?>
            <label class="fw-bold"><?php echo $nama." (".$satuan.")" ?></label>
            <?php
            }
            ?>
            <?php
            if($jenis=="Pilihan Combobox"){
            ?>
            <select name="sub[]" class="form-control mb-3">
              <?php
              $query2 = mysqli_query($koneksi, "SELECT * FROM subkriteria WHERE id_kriteria='".$id_kriteria."'");
              while($result2=mysqli_fetch_array($query2)) {
              ?>
              <option value="<?php echo $result2['id_subkriteria'] ?>" <?php if($result2['id_subkriteria']==$id_subkriteria){ echo "selected"; } ?>><?php echo $result2['nama'] ?></option>
              <?php
              }
              ?>
            </select>
            <?php
            } else {
              $query2 = mysqli_query($koneksi, "SELECT MIN(min) AS min, MAX(max) as max FROM subkriteria WHERE id_kriteria='".$id_kriteria."'");
              $result2=mysqli_fetch_array($query2);
              $min = $result2['min'];
              $max = $result2['max'];
            ?>
            <input type="number" name="sub[]" value="<?php echo $nilai_inputan ?>" class="form-control mb-3" step="0.1" placeholder="<?php echo $nama ?>" min="<?php echo $min ?>" max="<?php echo $max ?>" autocomplete="off"
            aria-label="<?php echo $nama ?>" required>
            <?php
            }
            ?>
          </div>
          <?php
          }
          ?>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary col-md-12">Update Profil</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php
}
?>
