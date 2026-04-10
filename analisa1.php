<?php
$limit = $_POST['max'];
$offset = ($_POST['min']-1);
$jenis = $_POST['jenis'];
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
          Analisa COCOSO
        </h2>
      </div>
      <!-- Page title actions -->

    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card p-4">
      <h3>Pembobotan Data Karyawan</h3>
      <table class="table" id="example">
				<thead class="table-dark">
					<tr class="text-white">
						<th class='text-center'>ID</th>
						<th>Nama</th>
						<?php
            $max = array();
            $min = array();
						$query = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY id_kriteria");
						while($result=mysqli_fetch_array($query)) {
							echo "<th>".$result['nama']."</th>";

              $query2 = mysqli_query($koneksi, "SELECT MIN(s.bobot) AS min, MAX(s.bobot) AS max FROM kriteria_karyawan k, subkriteria s
              WHERE k.id_kriteria='".$result['id_kriteria']."' AND k.id_subkriteria=s.id_subkriteria");
  						$result2 = mysqli_fetch_array($query2);


              array_push($max, $result2['max']);
              array_push($min, $result2['min']);
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
          $no = 1;
          $query = mysqli_query($koneksi, "SELECT * FROM karyawan LIMIT ".$limit." OFFSET ".$offset."");
					while($result = mysqli_fetch_array($query)) {
            $id = $result['id_karyawan'];
      			$nama = $result['nama'];

      			echo "<tr>";
            echo "<td>$no</td>";
      			echo "<td>$result[nama]</td>";

            $i = 0;
            $query2 = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY id_kriteria");
            while($result2=mysqli_fetch_array($query2)) {
              $satuan = $result2['satuan'];
              $query3 = mysqli_query($koneksi, "SELECT * FROM subkriteria s, kriteria_karyawan k WHERE k.id_kriteria='".$result2['id_kriteria']."' AND k.id_karyawan='".$id."'
              AND k.id_subkriteria=s.id_subkriteria");

              $result3 = mysqli_fetch_array($query3);

              echo "<td style='font-size:12px;'><center>$result3[bobot]</center></td>";

              // if($result3['bobot'] > $max[$i]){
              //   $max[$i] = $result3['bobot'];
              // }
              //
              // if($result3['bobot'] < $min[$i]){
              //   $min[$i] = $result3['bobot'];
              // }

              $i++;
            }

      			echo "</tr>";
            $no++;
					}
          echo "<tr>";
            echo "<td>MAX</td>";
            echo "<td></td>";
            for($i=0; $i<count($max); $i++){
              echo "<td class='text-center'>".$max[$i]."</td>";
            }
          echo "</tr>";
          echo "<tr>";
            echo "<td>MIN</td>";
            echo "<td></td>";
            for($i=0; $i<count($min); $i++){
              echo "<td class='text-center'>".$min[$i]."</td>";
            }
          echo "</tr>";
					?>
				</tbody>
			</table>
      <hr />
      <h3>Matriks Ternormalisasi</h3>
      <table class="table" id="example1">
				<thead class="table-dark">
					<tr class="text-white">
						<th class='text-center'>ID</th>
						<th>Nama</th>
						<?php
						$query = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY id_kriteria");
						while($result=mysqli_fetch_array($query)) {
							echo "<th>".$result['nama']."</th>";
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
          $no = 1;
          $query = mysqli_query($koneksi, "SELECT * FROM karyawan LIMIT ".$limit." OFFSET ".$offset."");
					while($result = mysqli_fetch_array($query)) {
            $id = $result['id_karyawan'];
      			$nama = $result['nama'];

      			echo "<tr>";
            echo "<td>$no</td>";
      			echo "<td>$result[nama]</td>";

            $i = 0;
            $query2 = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY id_kriteria");
            while($result2=mysqli_fetch_array($query2)) {
              $satuan = $result2['satuan'];
              $query3 = mysqli_query($koneksi, "SELECT * FROM subkriteria s, kriteria_karyawan k WHERE k.id_kriteria='".$result2['id_kriteria']."' AND k.id_karyawan='".$id."'
              AND k.id_subkriteria=s.id_subkriteria");

              $result3 = mysqli_fetch_array($query3);

              $val = ($result3['bobot']-$min[$i]) / ($max[$i]-$min[$i]);
              $val = round($val, 2);

              echo "<td style='font-size:12px;'><center>".$val."</center></td>";
              $i++;
            }

      			echo "</tr>";
            $no++;
					}
					?>
				</tbody>
			</table>
      <hr />
      <h3>Menghitung Nilai Si dan Pi</h3>
      <table class="table" id="example1">
				<thead class="table-dark">
					<tr class="text-white">
						<th class='text-center'>ID</th>
						<th>Nama</th>
						<th>Si</th>
            <th>Pi</th>
					</tr>
				</thead>
				<tbody>
					<?php
          $total_si = 0.0;
          $total_pi = 0.0;
          $max_si = 0;
          $min_si = 1000;
          $max_pi = 0;
          $min_pi = 1000;
          $no = 1;
          $query = mysqli_query($koneksi, "SELECT * FROM karyawan LIMIT ".$limit." OFFSET ".$offset."");
					while($result = mysqli_fetch_array($query)) {
            $id = $result['id_karyawan'];
      			$nama = $result['nama'];
            $si = 0.0;
            $pi = 0.0;

      			echo "<tr>";
            echo "<td>$no</td>";
      			echo "<td>$result[nama]</td>";

            $i = 0;
            $query2 = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY id_kriteria");
            while($result2=mysqli_fetch_array($query2)) {
              $satuan = $result2['satuan'];
              $bobot = $result2['bobot'];

              $query3 = mysqli_query($koneksi, "SELECT * FROM subkriteria s, kriteria_karyawan k WHERE k.id_kriteria='".$result2['id_kriteria']."' AND k.id_karyawan='".$id."'
              AND k.id_subkriteria=s.id_subkriteria");

              $result3 = mysqli_fetch_array($query3);

              $val = ($result3['bobot']-$min[$i]) / ($max[$i]-$min[$i]);
              $val = round($val, 2);

              $si += $val*($bobot/100);
              $pi += pow($val, ($bobot/100));

              //echo "<td style='font-size:12px;'><center>".$val."</center></td>";
              $i++;
            }
            $si = round($si, 3);
            $pi = round($pi, 3);

            $total_si += $si;
            $total_pi += $pi;

            if($si > $max_si){
              $max_si = $si;
            }

            if($si < $min_si){
              $min_si = $si;
            }

            if($pi > $max_pi){
              $max_pi = $pi;
            }

            if($pi < $min_pi){
              $min_pi = $pi;
            }

            echo "<td>".$si."</td>";
            echo "<td>".$pi."</td>";
      			echo "</tr>";
            $no++;
					}
          echo "<tr>";
            echo "<td></td>";
            echo "<td>SUM</td>";
            echo "<td>".$total_si."</td>";
            echo "<td>".$total_pi."</td>";
          echo "</tr>";
          echo "<tr>";
            echo "<td></td>";
            echo "<td>MAX</td>";
            echo "<td>".$max_si."</td>";
            echo "<td>".$max_pi."</td>";
          echo "</tr>";
          echo "<tr>";
            echo "<td></td>";
            echo "<td>MIN</td>";
            echo "<td>".$min_si."</td>";
            echo "<td>".$min_pi."</td>";
          echo "</tr>";
					?>
				</tbody>
			</table>
      <hr />
      <?php
      $query4 = "DELETE FROM hasil WHERE jenis ='".$jenis."'";
      $result4 = mysqli_query($koneksi, $query4);
      ?>
      <h3>Menghitung Nilai Kia, Kib, Kic dan Total Ki</h3>
      <table class="table" id="example1">
				<thead class="table-dark">
					<tr class="text-white">
						<th class='text-center'>ID</th>
						<th>Nama</th>
						<th>Kia</th>
            <th>Kib</th>
            <th>Kic</th>
            <th>Ki</th>
					</tr>
				</thead>
				<tbody>
					<?php
          $no = 1;
          $query = mysqli_query($koneksi, "SELECT * FROM karyawan LIMIT ".$limit." OFFSET ".$offset."");
					while($result = mysqli_fetch_array($query)) {
            $id = $result['id_karyawan'];
      			$nama = $result['nama'];
            $si = 0.0;
            $pi = 0.0;

      			echo "<tr>";
            echo "<td>$no</td>";
      			echo "<td>$result[nama]</td>";

            $i = 0;
            $query2 = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY id_kriteria");
            while($result2=mysqli_fetch_array($query2)) {
              $satuan = $result2['satuan'];
              $bobot = $result2['bobot'];

              $query3 = mysqli_query($koneksi, "SELECT * FROM subkriteria s, kriteria_karyawan k WHERE k.id_kriteria='".$result2['id_kriteria']."' AND k.id_karyawan='".$id."'
              AND k.id_subkriteria=s.id_subkriteria");

              $result3 = mysqli_fetch_array($query3);

              $val = ($result3['bobot']-$min[$i]) / ($max[$i]-$min[$i]);
              $val = round($val, 2);

              $si += $val*($bobot/100);
              $pi += pow($val, ($bobot/100));

              //echo "<td style='font-size:12px;'><center>".$val."</center></td>";
              $i++;
            }
            $si = round($si, 3);
            $pi = round($pi, 3);

            $kia = ($pi+$si) / ($total_pi+$total_si);
            $kia = round($kia, 5);

            $kic = ((0.5 * $si) + ((1 - 0.5) * $pi)) / ((0.5 * $max_si) + ((1 - 0.5) * $max_pi));
            $kic = round($kic, 5);

            $pengali = $min_pi / $min_si;
            $pengali = round($pengali, 3);
            $si *= $pengali;
            $kib = ($si + $pi) / $min_pi;
            $kib = round($kib, 5);

            $ki = pow(($kia * $kib * $kic), (1/3)) + ((1/3) * ($kia + $kib + $kic));
            $ki = round($ki, 3);

            if($no < 201){
              $keterangan = "Layak";
            } else {
              $keterangan = "Tidak Layak";
            }

            $query4 = "INSERT INTO hasil(id_karyawan, nilai, jenis)
            VALUES('".$id."', '".$ki."', '".$jenis."')";
            $result4 = mysqli_query($koneksi, $query4);

            echo "<td>".$kia."</td>";
            echo "<td>".$kib."</td>";
            echo "<td>".$kic."</td>";
            echo "<td>".$ki."</td>";
      			echo "</tr>";
            $no++;
					}
					?>
				</tbody>
			</table>

      <hr />
      <h3>Perangkingan</h3>
      <table class="table" id="example1">
				<thead class="table-dark">
					<tr class="text-white">
						<th class='text-center'>ID</th>
						<th>Nama</th>
						<th>Nilai</th>
            <th>Rangking</th>
            <th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php
          $no = 1;
          $query = mysqli_query($koneksi, "SELECT * FROM karyawan k, hasil h WHERE jenis='".$jenis."' AND k.id_karyawan=h.id_karyawan ORDER BY nilai DESC");
					while($result = mysqli_fetch_array($query)) {
            $id = $result['id_karyawan'];
      			$nama = $result['nama'];
            $nilai = $result['nilai'];
            $keterangan = "Layak";

            if($no > 200){
              $keterangan = "Tidak Layak";

              $query4 = "UPDATE hasil SET keterangan='".$keterangan."' WHERE id_karyawan='".$jenis."'";
              $result4 = mysqli_query($koneksi, $query4);
            }

      			echo "<tr>";
            echo "<td>$no</td>";
      			echo "<td>".$nama."</td>";
            echo "<td>".$nilai."</td>";
            echo "<td>".$no."</td>";
            echo "<td>".$keterangan."</td>";
      			echo "</tr>";
            $no++;
					}
					?>
				</tbody>
			</table>
    </div>
  </div>
</div>
