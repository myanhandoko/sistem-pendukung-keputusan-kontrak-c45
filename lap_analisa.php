<?php
include 'koneksi.php';
$bulans = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

?>
<!DOCTYPE HTML>
<html>
<head>
  <title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="Modern Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
  Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
  <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
  <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
  <link rel="stylesheet" href="dist/css/tabler.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
</head>
<body>
  <div id="wrapper">
    <div id="page-wrapper">
      <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">Print</button>
      <div class="graphs" style="padding:50px;font-size:15px;">
        <img src="static/logo.png" style="width:100px;" />
        <hr />
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
      </div>
    </div>
  </div>
</body>
</html>
