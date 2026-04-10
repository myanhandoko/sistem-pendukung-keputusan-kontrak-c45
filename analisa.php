<?php
$limit = $_POST['max'];
$offset = ($_POST['min']-1);
$jenis = $_POST['jenis'];

$aturans = array();
$query = mysqli_query($koneksi, "SELECT * FROM aturan");
while($result=mysqli_fetch_array($query)) {
  array_push($aturans, $result['aturan']);
}

$query2 = "UPDATE training SET status=''";
$result2 = mysqli_query($koneksi, $query2) or die(mysqli_error($query2));
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
          Analisa ID3
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
            <?php
            $i=1;
            $query = mysqli_query($koneksi, "SELECT * FROM variabel ORDER BY id_variabel");
            while($result=mysqli_fetch_array($query)) {
              echo "<th style='font-size:12px;'>".$result['nama']."</th>";
              $i++;
            }
            ?>
            <th style="font-size:12px;">Keputusan Sistem</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = mysqli_query($koneksi, "SELECT * FROM training LIMIT ".$limit." OFFSET ".$offset);
          $i = 1;
          while($result=mysqli_fetch_array($query)) {
            $id=$result['id_training'];
            $nama_alt=$result['nama'];
          ?>
            <tr>
              <td><?php echo $i ?></td>
              <td style="font-size:12px;">
                <?php echo "<strong>".$nama_alt."</strong>"; ?><br />
              </td>

              <?php
              $karyawan = array();
              $query2 = mysqli_query($koneksi, "SELECT k.nilai_inputan AS nilai_inputan, kt.nama AS nama
                FROM detail_training k, variabel kt WHERE k.id_training='".$id."'
                AND kt.id_variabel=k.id_variabel ORDER BY k.id_variabel");
              while($result2 = mysqli_fetch_array($query2)) {
                $val = strtolower($result2['nama'])." = ".$result2['nilai_inputan'];
                echo "<td style='font-size:12px;'>".$result2['nilai_inputan']."</td>";

                array_push($karyawan, $val);
              }

              $j = 1;
              $hasil = "Tidak Diketahui";
              foreach($aturans AS $aturan){
                //$aturan = "absensi = 2 Hari AND pendidikan = SMA AND masa kerja = 1.5 Tahun THEN status = Tidak Layak ";
                $aturan = str_replace("IF ", "", $aturan);
                //$aturan = str_replace("AND", "", $aturan);
                $index = strpos($aturan, " THEN");
                $hsl = substr($aturan, $index, strlen($aturan));
                $aturan = substr($aturan, 0, $index);
                $aturan = explode(" AND ", $aturan);
                //echo $index."<br />";
                // echo "Aturan".json_encode($aturan)."<br />";
                // echo $i.". Karyawan".json_encode($karyawan)."<br />";

                $containsAllValues = array_intersect($aturan, $karyawan);
                //echo $i.". Ketemu ? ".json_encode($containsAllValues)."<br /><br />";

                if(count($containsAllValues) == count($aturan)){
                  $hasil = $hsl;
                  $hasil = str_replace("THEN status = ", "", $hasil);
                  $hasil = substr($hasil, 1, (strlen($hasil)-1));

                  $query2 = "UPDATE training SET status='".$hasil."' WHERE id_training='".$id."'";
                  $result2 = mysqli_query($koneksi, $query2) or die(mysqli_error($query2));

                  //echo $j.". Ketemu ? ".$hasil." = ".json_encode($containsAllValues)."<br /><br />";
                  break;
                }
                $j++;
              }
              ?>
              <td style='font-size:12px;'>
                <?php echo $hasil ?>
              </td>
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
