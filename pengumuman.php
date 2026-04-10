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
          Pengumuman
        </h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card p-4">
      <table class="table align-middle" id="example">
        <thead>
          <tr>
            <th style="font-size:12px;">No.</th>
            <th style="font-size:12px;">Nama Karyawan</th>
            <th style="font-size:12px;">Hasil Keputusan (Data Aktual)</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = mysqli_query($koneksi, "SELECT * FROM training WHERE NOT status=''");
          $i = 1;
          while($result=mysqli_fetch_array($query)) {
            $id = $result['id_training'];
            $nama_alt = $result['nama'];
            $status = $result['status'];
            $status = str_replace("Layak ", "Layak", $status);
          ?>
            <tr>
              <?php
              $query2 = mysqli_query($koneksi, "SELECT k.nilai_inputan AS nilai_inputan, kt.nama AS nama
                FROM detail_training k, variabel kt WHERE k.id_training='".$id."'
                AND kt.id_variabel=k.id_variabel ORDER BY k.id_variabel DESC LIMIT 1");
              while($result2 = mysqli_fetch_array($query2)) {
                $keputusan = $result2['nilai_inputan'];
              }
              ?>
              <td><?php echo $i ?></td>
              <td style="font-size:12px;"><?php echo "<strong>".$nama_alt."</strong>"; ?><br /></td>
              <td style='font-size:12px;'><?php echo $keputusan ?></td>
            </tr>
            <?php
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
