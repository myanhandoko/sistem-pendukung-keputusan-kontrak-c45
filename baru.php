<?php
if(isset($_GET['aksi'])){
  if($_GET['aksi']=="tambah"){
    $nama = $_POST['nama'];
    $variabel = $_POST['variabel'];
    $sub = $_POST['sub'];

    $query = "INSERT INTO baru(nama) VALUES('".$nama."')";
    $result = mysqli_query($koneksi, $query) or die(mysqli_error($query));
    $id_baru = mysqli_insert_id($koneksi);

    for($i=0; $i<count($variabel); $i++){
      $query3 = mysqli_query($koneksi, "SELECT * FROM variabel WHERE id_variabel='".$variabel[$i]."'");
      $result3 = mysqli_fetch_array($query3);
      $id_subvariabel = $sub[$i];

      $query2 = "INSERT INTO detail_baru(id_baru, id_variabel, nilai_inputan)
      VALUES('".$id_baru."', '".$variabel[$i]."', '".$sub[$i]."')";
      $result2 = mysqli_query($koneksi, $query2) or die(mysqli_error($query2));
    }
    if ($result2) {
			$_SESSION['success']= 1;
			$_SESSION['message']= "Data Karyawan Berhasil Ditambah";
			header('location:home.php?page=baru');
		} else {
			$_SESSION['success']= 0;
			$_SESSION['message']= "Data Karyawan Gagal Ditambah";
			header('location:home.php?page=baru');
		}
  } else if($_GET['aksi']=="edit"){
    $id_baru = $_POST['id_baru'];
    $variabel = $_POST['variabel'];
    $nama = $_POST['nama'];
    $sub = $_POST['sub'];

    $query = "UPDATE baru SET nama='".$nama."' WHERE id_baru='".$id_baru."'";
    $result = mysqli_query($koneksi, $query) or die(mysqli_error($query));

    $query2 = "DELETE FROM detail_baru WHERE id_baru='".$id_baru."'";
    $result2 = mysqli_query($koneksi, $query2) or die(mysqli_error($query2));

    for($i=0; $i<count($variabel); $i++){
      $query3 = mysqli_query($koneksi, "SELECT * FROM variabel WHERE id_variabel='".$variabel[$i]."'");
      $result3 = mysqli_fetch_array($query3);
      $id_subvariabel = $sub[$i];

      if($result3['jenis']=="Angka Dengan Range"){
        $query4 = mysqli_query($koneksi, "SELECT * FROM subvariabel WHERE id_variabel='".$variabel[$i]."'
        AND min <= '".$sub[$i]."' AND max >= '".$sub[$i]."'");
        if($result4 = mysqli_fetch_array($query4)){
          $id_subvariabel = $result4['id_subvariabel'];
        }
      }

      $query2 = "INSERT INTO detail_baru(id_baru, id_variabel, nilai_inputan)
      VALUES('".$id_baru."', '".$variabel[$i]."', '".$sub[$i]."')";
      $result2 = mysqli_query($koneksi, $query2) or die(mysqli_error($query2));
    }
    if ($result2) {
			$_SESSION['success']= 1;
			$_SESSION['message']= "Data Karyawan Berhasil Diedit";
			header('location:home.php?page=baru');
		} else {
			$_SESSION['success']= 0;
			$_SESSION['message']= "Data Karyawan Gagal Diedit";
			header('location:home.php?page=baru');
		}
  } else {
    $query = "DELETE FROM baru WHERE id_baru = '".$_GET['id']."'";
		$result = mysqli_query($koneksi, $query);
		if ($result) {
			$_SESSION['success']= 1;
			$_SESSION['message']= "Data Karyawan Berhasil Dihapus";
			header('location:home.php?page=baru');
		} else {
			$_SESSION['success']= 0;
			$_SESSION['message']= "Gagal Menghapus Data Karyawan";
			header('location:home.php?page=baru');
		}
  }
} else {
  $query = mysqli_query($koneksi, "SELECT * FROM baru");
  $rows = mysqli_num_rows($query);
  $row = 50;
  $page = ($rows/$row)+1;
  $offset = 0;
  if(isset($_GET['halaman'])){
    $halaman = $_GET['halaman'];
    if($halaman != 1){
      $offset = ($halaman-1) * 50;
    }
  }

  $aturans = array();
  $query = mysqli_query($koneksi, "SELECT * FROM aturan");
  while($result=mysqli_fetch_array($query)) {
    array_push($aturans, $result['aturan']);
  }

  $query2 = "UPDATE baru SET status=''";
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
          Karyawan Baru
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
      <div>
        <div class="d-flex align-middle ">
        <p class="mt-1 me-3">Halaman</p>
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <?php
            for($i=1; $i<=$page; $i++){
              if(!isset($_GET['halaman'])){
            ?>
              <li class="page-item <?php if($i==1){ echo "active"; } ?> "><a class="page-link" href="?page=baru&halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php
              } else {
            ?>
            <li class="page-item <?php if($i==$_GET['halaman']){ echo "active"; } ?> "><a class="page-link" href="?page=baru&halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php
              }
            }
            ?>
          </ul>
        </nav>
      </div>
        <table class="table align-middle" id="wrap">
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
              <th style="font-size:12px;">Prediksi</th>
              <th style="font-size:12px;" class="text-center" style="width:200px !important;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM baru");
            $i = $offset+1;
            while($result=mysqli_fetch_array($query)) {
              $id=$result['id_baru'];
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
                  FROM detail_baru k, variabel kt WHERE k.id_baru='".$id."'
                  AND kt.id_variabel=k.id_variabel ORDER BY k.id_variabel");
                while($result2 = mysqli_fetch_array($query2)) {
                  $val = strtolower($result2['nama'])." = ".$result2['nilai_inputan'];
                  echo "<td style='font-size:12px;'>".$result2['nilai_inputan']."</td>";

                  array_push($karyawan, $val);
                }

                $j = 1;
                $hasil = "Tidak Layak";
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

                  // echo "Aturan - ".json_encode($aturan)."<br />";
                  // echo "Karyawan - ".json_encode($karyawan)."<br />";

                  $containsAllValues = array_intersect($aturan, $karyawan);
                  //echo $i.". Ketemu ? ".json_encode($containsAllValues)."<br /><br />";

                  if(count($containsAllValues) == count($aturan)){
                    $hasil = $hsl;
                    $hasil = str_replace("THEN status = ", "", $hasil);
                    $hasil = substr($hasil, 1, (strlen($hasil)-1));

                    //echo $j.". Ketemu ? ".$hasil." = ".json_encode($containsAllValues)."<br /><br />";
                    break;
                  }
                  $j++;
                }

                $query2 = "UPDATE baru SET status='".$hasil."' WHERE id_baru='".$id."'";
                $result2 = mysqli_query($koneksi, $query2) or die(mysqli_error($query2));
                ?>
                <td style='font-size:12px;'><?php echo $hasil ?></td>
                <td class="text-center">
                  <a class="btn btn-info btn-icon" href="#" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $id; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /><line x1="13.5" y1="6.5" x2="17.5" y2="10.5" /></svg>
                  </a>
                  <a class="btn btn-info btn-icon" href="<?php echo "?page=baru&aksi=hapus&id=".$id; ?>">
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
                    <form method="post" action="?page=baru&aksi=edit">
                    <div class="modal-body">
                      <input type="hidden" value="<?php echo $id; ?>" name="id_baru" />
                      <label>Nama Karyawan</label>
                      <input type="text" value="<?php echo $nama_alt ?>" class="form-control mb-3" placeholder="Nama" autocomplete="off" aria-label="Nama" name="nama">
                      <div class="row">
                        <?php
                        $query8 = mysqli_query($koneksi, "SELECT * FROM variabel");
              					while ($result8 = mysqli_fetch_array($query8)){
                          $id_variabel = $result8['id_variabel'];
                          $nama = $result8['nama'];
                          $jenis = $result8['jenis'];
                          $satuan = $result8['satuan'];
              					?>
                        <div class="col-6">
                        <input type="hidden" name="variabel[]" value="<?php echo $id_variabel ?>" />
                        <?php
                        if($satuan==""){
                        ?>
                        <label><?php echo $nama ?></label>
                        <?php
                        } else {
                        ?>
                        <label><?php echo $nama." (".$satuan.")" ?></label>
                        <?php
                        }
                        $query7 = mysqli_query($koneksi, "SELECT * FROM detail_baru
                          WHERE id_variabel='".$id_variabel."' AND id_baru='".$id."'");
                        $result7 = mysqli_fetch_array($query7);
                        $nilai = $result7['nilai_inputan'];

                        if($jenis=="Pilihan"){
                        ?>
                        <select name="sub[]" class="form-control mb-3">
                          <?php
                          $query7 = mysqli_query($koneksi, "SELECT * FROM subvariabel WHERE id_variabel='".$id_variabel."'");
                          while($result7=mysqli_fetch_array($query7)) {
                          ?>
                          <option value="<?php echo $result7['nama'] ?>" <?php if($result7['nama']==$nilai){ echo "selected"; } ?>>
                            <?php echo $result7['nama'] ?>
                          </option>
                          <?php
                          }
                          ?>
                        </select>
                        <?php
                        } else {
                          $query7 = mysqli_query($koneksi, "SELECT MIN(min) AS min, MAX(max) as max FROM subvariabel WHERE id_variabel='".$id_variabel."'");
                          $result7=mysqli_fetch_array($query7);
                          $min = $result7['min'];
                          $max = $result7['max'];
                        ?>
                        <input type="number" step="0.1" value="<?php echo $nilai ?>" name="sub[]" class="form-control mb-3" placeholder="<?php echo $nama ?>" min="<?php echo $min ?>" max="<?php echo $max ?>" autocomplete="off" aria-label="<?php echo $nama ?>" required>
                        <?php
                        }
                        ?>
                        </div>
              					<?php
              					}
                        ?>
                      </div>
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
        <?php
        $status = array();
        // $query = mysqli_query($koneksi, "SELECT status FROM baru WHERE NOT status='' GROUP BY status ORDER BY status DESC");
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

            $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM baru t, detail_baru d
            WHERE nilai_inputan='".$v1."' AND status='".$v2."' AND t.id_baru=d.id_baru");
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
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="?page=baru&aksi=tambah">
      <div class="modal-body">
        <label>Nama Karyawan</label>
        <input type="text" class="form-control mb-3" placeholder="Nama" autocomplete="off" aria-label="Nama" name="nama">
        <div class="row">
          <?php
          $query8 = mysqli_query($koneksi, "SELECT * FROM variabel");
          while ($result8 = mysqli_fetch_array($query8)){
            $id_variabel = $result8['id_variabel'];
            $nama = $result8['nama'];
            $jenis = $result8['jenis'];
            $satuan = $result8['satuan'];
          ?>
          <div class="col-6">
          <input type="hidden" name="variabel[]" value="<?php echo $id_variabel ?>" />
          <?php
          if($satuan==""){
          ?>
          <label><?php echo $nama ?></label>
          <?php
          } else {
          ?>
          <label><?php echo $nama." (".$satuan.")" ?></label>
          <?php
          }
          ?>
          <?php
          if($jenis=="Pilihan"){
          ?>
          <select name="sub[]" class="form-control mb-3">
            <?php
            $query7 = mysqli_query($koneksi, "SELECT * FROM subvariabel WHERE id_variabel='".$id_variabel."'");
            while($result7=mysqli_fetch_array($query7)) {
            ?>
            <option value="<?php echo $result7['nama'] ?>"><?php echo $result7['nama'] ?></option>
            <?php
            }
            ?>
          </select>
          <?php
          } else {
          ?>
          <input type="number" step="0.1" name="sub[]" class="form-control mb-3" placeholder="<?php echo $nama ?>" autocomplete="off" aria-label="<?php echo $nama ?>" required>
          <?php
          }
          ?>
          </div>
          <?php
          }
          ?>
        </div>
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
