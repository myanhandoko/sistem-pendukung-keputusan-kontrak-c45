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
            <th style="font-size:12px;">Data Aktual</th>
            <th style="font-size:12px;">Keputusan Sistem</th>
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
            // if($status=="Tidak Layak " || $status=="Tidak Layak"){
            //   $status = "Tidak Layak";
            // } else {
            //   $status = "Layak";
            // }
            //$status = "";
          ?>
            <tr>
              <?php
              $query2 = mysqli_query($koneksi, "SELECT k.nilai_inputan AS nilai_inputan, kt.nama AS nama
                FROM detail_training k, variabel kt WHERE k.id_training='".$id."'
                AND kt.id_variabel=k.id_variabel ORDER BY k.id_variabel DESC LIMIT 1");
              while($result2 = mysqli_fetch_array($query2)) {
                //$val = strtolower($result2['nama'])." = ".$result2['nilai_inputan'];
                $keputusan = $result2['nilai_inputan'];
                // if($keputusan=="Tidak Layak " || $keputusan=="Tidak Layak"){
                //   $keputusan = "Tidak Layak";
                // } else {
                //   $keputusan = "Layak";
                // }
                //echo "<td style='font-size:12px;'>".$result2['nilai_inputan']."</td>";
              }

              $kep = "<td style='vertical-align:middle;font-size:12px;'>".$keputusan."</td>";
              if($keputusan != $status){
                $kep = "<td style='vertical-align:middle; background:#ffcd00;font-size:12px;'>".$keputusan."</td>";
              }
              ?>
              <td><?php echo $i ?></td>
              <td style="font-size:12px;"><?php echo "<strong>".$nama_alt."</strong>"; ?><br /></td>
              <?php echo $kep ?>
              <td style='font-size:12px;'><?php echo $status ?></td>
            </tr>
            <?php
            $i++;
          }
          ?>
        </tbody>
      </table>
      <?php
      $status = array();
      // $query = mysqli_query($koneksi, "SELECT status FROM training WHERE NOT status='' GROUP BY status ORDER BY status DESC");
      // while($result = mysqli_fetch_array($query)){
      //   $stat = "";
      //   if($result['status'] == "Layak"){
      //     $stat = "Positif";
      //   } else {
      //     $stat = "Negatif";
      //   }
      //
      //   array_push($status, $stat);
      // }

      array_push($status, "Positif");
      array_push($status, "Negatif");

      $conf = array();

      //echo json_encode($status);

      for($i=0; $i<count($status); $i++){
        //echo $status[$i]." - ";
        $val1 = $status[$i];
        for($j=0; $j<count($status); $j++){
          $val2 = $status[$j];

          if($val1 == "Positif"){
            $v1 = "Layak";
          } else {
            $v1 = "Tidak Layak";
          }

          if($val2 == "Positif"){
            $v2 = "Layak";
          } else {
            $v2 = "Tidak Layak";
          }

          //echo $val1." : ".$val2."<br />";

          $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM training t, detail_training d
          WHERE nilai_inputan='".$v1."' AND status='".$v2."' AND t.id_training=d.id_training");
          $result = mysqli_fetch_array($query);

          array_push($conf, $result['total']);

        }
      }
      ?>
      <table class="table table-bordered mt-3" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
          <tr>
            <th class="text-center align-middle" colspan="2" rowspan="2">Confusion Matrix</th>
            <th class="text-center" colspan="2">Nilai Aktual</th>
          </tr>
          <tr>
            <th class="text-center">Positif</th>
            <th class="text-center">Negatif</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan=2 class="text-center align-middle">Nilai Prediksi</td>
            <td>Positif</td>
            <td><?php echo $conf[0] ?></td>
            <td><?php echo $conf[1] ?></td>
          </tr>
          <tr>
            <td>Negatif</td>
            <td><?php echo $conf[2] ?></td>
            <td><?php echo $conf[3] ?></td>
          </tr>
          <tr>
            <td class='text-center' colspan=2>Jumlah</td>
            <td><?php echo ($conf[0]+$conf[2]) ?></td>
            <td><?php echo ($conf[1]+$conf[3]) ?></td>
          </tr>
        </tbody>
      </table>

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
          <tr>
            <th class="text-start">No</th>
            <th class="text-start">Pengukuran</th>
            <th class="text-start">Rumus</th>
            <th class="text-center">Hasil</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Akurasi</td>
            <td>
              <?php
              $akurasi = ($conf[0] + $conf[3]) / ($conf[0] + $conf[1] + $conf[2] + $conf[3]);
              $akurasi = round($akurasi, 2);
              $akurasi *= 100;
              echo $conf[0]." + ".$conf[3]." / (".$conf[0]." + ".$conf[1]." + ".$conf[2]." + ".$conf[3].")";
              ?>
            </td>
            <td class="text-center"><?php echo $akurasi ?> %</td>
          </tr>

          <tr>
            <td>2</td>
            <td>Presisi</td>
            <td>
              <?php
              $presisi = ($conf[0]) / ($conf[0] + $conf[1]);
              $presisi = round($presisi, 2);
              $presisi *= 100;
              echo $conf[0]." / (".$conf[0]." + ".$conf[1].")";
              ?>
            </td>
            <td class="text-center"><?php echo $presisi ?> %</td>
          </tr>

          <tr>
            <td>3</td>
            <td>Recall</td>
            <td>
              <?php
              $recall = ($conf[0]) / ($conf[0] + $conf[2]);
              $recall = round($recall, 2);
              $recall *= 100;
              echo $conf[0]." / (".$conf[0]." + ".$conf[2].")";
              ?>
            </td>
            <td class="text-center"><?php echo $recall ?> %</td>
          </tr>

          <tr>
            <td>4</td>
            <td>F1-Score</td>
            <td>
              <?php
              $f1 = (2 * ($recall/100) * ($presisi/100)) / (($recall/100) + ($presisi/100));
              $f1 = round($f1, 2);
              $f1 *= 100;
              echo "2 * ".($recall/100)." * ".($presisi/100)." / (".($recall/100)." + ".($presisi/100).")";
              ?>
            </td>
            <td class="text-center"><?php echo $f1 ?> %</td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>
</div>
