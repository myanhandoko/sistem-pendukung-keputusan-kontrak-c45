<?php
if(isset($_GET['aksi'])){
  if($_GET['aksi']=="tambah"){
    $nama = $_POST['nama'];
    $bobot = $_POST['bobot'];
    $id_variabel = $_POST['id_variabel'];
    $min = $_POST['min'];
    $max = $_POST['max'];

    $query = mysqli_query($koneksi, "SELECT * FROM variabel WHERE id_variabel='".$id_variabel."'");
    $result = mysqli_fetch_array($query);
    $nama_k = $result['nama'];
    $jenis = $result['jenis'];

    $query = "INSERT INTO subvariabel(min, max, bobot, id_variabel) VALUES('".$min."', '".$max."', '".$bobot."', '".$id_variabel."')";

    if($jenis=="Pilihan"){
      $query = "INSERT INTO subvariabel(nama, bobot, id_variabel) VALUES('".$nama."', '".$bobot."', '".$id_variabel."')";
    }

    $result = mysqli_query($koneksi, $query) or die(mysqli_error($query));
    if($result) {
      $_SESSION['success']= 1;
      $_SESSION['message']= "Berhasil Menambah Data Pilihan";
      header('location:home.php?page=subvariabel&id_variabel='.$id_variabel);
    } else {
      $_SESSION['success']= 0;
      $_SESSION['message']= "Gagal Menambah Data Pilihan";
      header('location:home.php?page=subvariabel&id_variabel='.$id_variabel);
    }
  } else if($_GET['aksi']=="edit"){
    $id = $_POST['id_subvariabel'];
    $nama = $_POST['nama'];
    $bobot = $_POST['bobot'];
    $id_variabel = $_POST['id_variabel'];
    $min = $_POST['min'];
    $max = $_POST['max'];

    $query = mysqli_query($koneksi, "SELECT * FROM variabel WHERE id_variabel='".$id_variabel."'");
    $result = mysqli_fetch_array($query);
    $nama_k = $result['nama'];
    $jenis = $result['jenis'];

    $query = "UPDATE subvariabel SET min='".$min."', max='".$max."', bobot='".$bobot."' WHERE id_subvariabel='".$id."'";

    if($jenis=="Pilihan"){
      $query = "UPDATE subvariabel SET nama='".$nama."', bobot='".$bobot."' WHERE id_subvariabel='".$id."'";
    }

    $result = mysqli_query($koneksi, $query) or die(mysqli_error($query));
    if($result) {
      $_SESSION['success']= 1;
      $_SESSION['message']= "Berhasil Mengedit Data Pilihan";
      header('location:home.php?page=subvariabel&id_variabel='.$id_variabel);
    } else {
      $_SESSION['success']= 0;
      $_SESSION['message']= "Gagal Mengedit Data Pilihan";
      header('location:home.php?page=subvariabel&id_variabel='.$id_variabel);
    }
  } else {
    $query = "DELETE FROM subvariabel WHERE id_subvariabel = '".$_GET['id']."'";
		$result = mysqli_query($koneksi, $query);
		if ($result) {
			$_SESSION['success']= 1;
			$_SESSION['message']= "Data Pilihan Berhasil Dihapus";
			header('location:home.php?page=subvariabel&id_variabel='.$_GET['id_variabel']);
		} else {
			$_SESSION['success']= 0;
			$_SESSION['message']= "Gagal Menghapus Data Pilihan";
			header('location:home.php?page=subvariabel&id_variabel='.$_GET['id_variabel']);
		}
  }
} else {
  $query = mysqli_query($koneksi, "SELECT * FROM variabel WHERE id_variabel='".$_GET['id_variabel']."'");
  $result = mysqli_fetch_array($query);
  $nama_k = $result['nama'];
  $jenis = $result['jenis'];
  $satuan = $result['satuan'];
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
          Pilihan <?php echo $nama_k ?>
        </h2>
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="#" class="btn btn-info d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
            Tambah
          </a>
          <a href="#" class="btn btn-info d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card p-4">
      <table id="example" class="table align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Pilihan</th>
            <!-- <th>Bobot</th> -->
            <th class="text-center" style="width:100px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = mysqli_query($koneksi, "SELECT * FROM subvariabel WHERE id_variabel='".$_GET['id_variabel']."'
          ORDER BY bobot");
          $i = 1;
          while($result=mysqli_fetch_array($query)) {
            $id=$result['id_subvariabel'];
            $nama=$result['nama'];
            // $bobot=$result['bobot'];
            // $min=$result['min'];
            // $max=$result['max'];
            // if(!is_decimal($min)){
            //   $min = (int) $min;
            // }
            //
            // if(!is_decimal($max)){
            //   $max = (int) $max;
            // }
          ?>
          <tr>
            <td data-table-header="id"><?php echo $i; ?></td>
            <?php
            if($jenis=="Pilihan"){
            ?>
            <td data-table-header="nama"><?php echo $nama." ".$satuan; ?></td>
            <?php
            } else {
            ?>
            <td data-table-header="nama"><?php echo $min." - ".$max." ".$satuan; ?></td>
            <?php
            }
            ?>
            <!-- <td data-table-header="nama"><?php echo $bobot; ?></td> -->
            <td class="text-center">
              <a class="btn btn-info btn-icon" href="#" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $id; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /><line x1="13.5" y1="6.5" x2="17.5" y2="10.5" /></svg>
              </a>
              <a class="btn btn-info btn-icon" href="<?php echo "?page=subvariabel&aksi=hapus&id=".$id."&id_variabel=".$_GET['id_variabel']; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M10 10l4 4m0 -4l-4 4" /></svg>
              </a>
            </td>
          </tr>
          <div class="modal fade" id="modalEdit<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="?page=subvariabel&aksi=edit">
                <div class="modal-body">
                  <input type="hidden" value="<?php echo $_GET['id_variabel']; ?>" name="id_variabel" />
                  <input type="hidden" value="<?php echo $id; ?>" name="id_subvariabel" />
                  <?php
                  if($jenis=="Pilihan"){
                  ?>
                  <label>Nama Pilihan</label>
                  <input type="text" value="<?php echo $nama; ?>" class="form-control mb-3" placeholder="Nama" autocomplete="off" aria-label="Nama" name="nama">
                  <?php
                  } else {
                  ?>
                  <label>Nilai Min</label>
                  <input type="number" value="<?php echo $min; ?>" step="0.1" class="form-control mb-3" placeholder="Nilai Minimal" autocomplete="off" aria-label="Nama" name="min">
                  <label>Nilai Max</label>
                  <input type="number" value="<?php echo $max; ?>" step="0.1" class="form-control mb-3" placeholder="Nilai Maximal" autocomplete="off" aria-label="Nama" name="max">
                  <?php
                  }
                  ?>
                  <!-- <label>Bobot</label>
                  <input type="number" name="bobot" class="form-control mb-3" value='<?php echo $bobot; ?>' id="w3lName" placeholder="Bobot Pilihan" required autocomplete="off"> -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-info">Simpan</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        <?php
          $i++;
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="?page=subvariabel&aksi=tambah">
      <div class="modal-body">
        <input type="hidden" value="<?php echo $_GET['id_variabel']; ?>" name="id_variabel" />
        <?php
        if($jenis=="Pilihan"){
        ?>
        <label>Nama Pilihan</label>
        <input type="text" class="form-control mb-3" placeholder="Nama" autocomplete="off" aria-label="Nama" name="nama">
        <?php
        } else {
        ?>
        <label>Nilai Min</label>
        <input type="number" class="form-control mb-3" step="0.1" placeholder="Nilai Minimal" autocomplete="off" aria-label="Nama" name="min">
        <label>Nilai Max</label>
        <input type="number" class="form-control mb-3" step="0.1" placeholder="Nilai Maximal" autocomplete="off" aria-label="Nama" name="max">
        <?php
        }
        ?>
        <!-- <label>Bobot</label>
        <input type="number" name="bobot" class="form-control mb-3" value='<?php echo $nama; ?>' id="w3lName" placeholder="Bobot Pilihan" required autocomplete="off"> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php
}
?>
