<?php
if(isset($_GET['aksi'])){
  if($_GET['aksi']=="tambah"){
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $query = "INSERT INTO variabel(nama, jenis) VALUES('".$nama."', '".$jenis."')";
    $result = mysqli_query($koneksi, $query) or die(mysqli_error($query));
    if($result) {
      $_SESSION['success']= 1;
      $_SESSION['message']= "Berhasil Menambah Data Variabel";
      header('location:home.php?page=variabel');
    } else {
      $_SESSION['success']= 0;
      $_SESSION['message']= "Gagal Menambah Data Variabel";
      header('location:home.php?page=variabel');
    }
  } else if($_GET['aksi']=="edit"){
    $id = $_POST['id_variabel'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $query = "UPDATE variabel SET nama='".$nama."', jenis='".$jenis."' WHERE id_variabel='".$id."'";
    $result = mysqli_query($koneksi, $query) or die(mysqli_error($query));
    if($result) {
      $_SESSION['success']= 1;
      $_SESSION['message']= "Berhasil Mengedit Data Variabel";
      header('location:home.php?page=variabel');
    } else {
      $_SESSION['success']= 0;
      $_SESSION['message']= "Gagal Mengedit Data Variabel";
      header('location:home.php?page=variabel');
    }
  } else {
    $query = "DELETE FROM variabel WHERE id_variabel = '".$_GET['id']."'";
		$result = mysqli_query($koneksi, $query);
		if ($result) {
			$_SESSION['success']= 1;
			$_SESSION['message']= "Data Variabel Berhasil Dihapus";
			header('location:home.php?page=variabel');
		} else {
			$_SESSION['success']= 0;
			$_SESSION['message']= "Gagal Menghapus Data Variabel";
			header('location:home.php?page=variabel');
		}
  }
} else {
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
          Variabel
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
            <th>Nama Variabel</th>
            <th>Jenis Inputan</th>
            <th class="text-center" style="width:100px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = mysqli_query($koneksi, "SELECT * FROM variabel");
          $i = 1;
          while($result=mysqli_fetch_array($query)) {
            $id=$result['id_variabel'];
            $nama=$result['nama'];
            $jenis=$result['jenis'];
          ?>
            <tr>
              <td data-table-header="id"><?php echo $i; ?></td>
              <td data-table-header="nama"><?php echo $nama; ?></td>
              <td data-table-header="nama"><?php echo $jenis; ?></td>

              <td class="text-center">
                <a class="btn btn-info btn-icon" href="#" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $id; ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /><line x1="13.5" y1="6.5" x2="17.5" y2="10.5" /></svg>
                </a>
                <a class="btn btn-info btn-icon" href="<?php echo "?page=variabel&aksi=hapus&id=".$id; ?>">
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
                  <form method="post" action="?page=variabel&aksi=edit">
                  <div class="modal-body">
                    <input type="hidden" value="<?php echo $id; ?>" name="id_variabel" />
                    <label>Nama Variabel</label>
                    <input type="text" value="<?php echo $nama; ?>" class="form-control mb-3" placeholder="Nama" autocomplete="off" aria-label="Nama" name="nama">
                    <label>Jenis Inputan</label>
                    <select name="jenis" class="form-control mb-3">
                      <?php
                      if($jenis=="Pilihan"){
                      ?>
                      <option value="Angka">Angka</option>
                      <option value="Pilihan" selected>Pilihan</option>
                      <?php
                      } else {
                      ?>
                      <option value="Angka">Angka</option>
                      <option value="Pilihan">Pilihan</option>
                      <?php
                      }
                      ?>
                    </select>
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
      <form method="post" action="?page=variabel&aksi=tambah">
      <div class="modal-body">
        <label>Nama Variabel</label>
        <input type="text" class="form-control mb-3" placeholder="Nama" autocomplete="off" aria-label="Nama" name="nama">
        <label>Jenis Inputan</label>
        <select name="jenis" class="form-control mb-3">
          <option value="Angka">Angka</option>
          <option value="Pilihan">Pilihan</option>
        </select>
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
