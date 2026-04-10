<?php
require('excelreader/php-excel-reader/excel_reader2.php');
require('excelreader/SpreadsheetReader.php');
$Reader = new SpreadsheetReader('all_data.xlsx');

include 'koneksi.php';
require_once 'vendor/autoload.php';
$faker = Faker\Factory::create('id_ID');

$kode = "1300000";
$x = 1;
foreach ($Reader as $Row) {
	//print_r($Row);

  if($x > 0){
    echo $Row[0]." - ";
  	$nama = $Row[0];
  	$status = $Row[9];
    $result = true;

  	$query = "INSERT INTO training(nama, status) VALUES('".$nama."', '".$status."')";
  	$result = mysqli_query($koneksi, $query);

  	if($result){
  		$id_training = mysqli_insert_id($koneksi);
  		for($i=1; $i<=9; $i++){
  			$kolom = $i;
  			$nilai_inputan = $Row[$kolom];
  			//$nilai_inputan = str_replace(".", "", $nilai_inputan);

  			// $query2 = mysqli_query($koneksi, "SELECT * FROM variabel WHERE id_variabel='".$i."'");
  	    // $result2 = mysqli_fetch_array($query2);

  			// if($result2['jenis']=="Angka"){
  			// 	// $query3 = mysqli_query($koneksi, "SELECT * FROM subvariabel WHERE id_variabel='".$i."' AND min <= '".$nilai_inputan."' AND max >= '".$nilai_inputan."'");
  		  //   // $result3 = mysqli_fetch_array($query3);
        //   //
  			// 	// $id_subvariabel = $result3['id_subvariabel'];
        //
  			// 	$query4 = "INSERT INTO detail_training(id_training, id_variabel, nilai_inputan)
        //   VALUES('".$id_training."', '".$i."', '".$nilai_inputan."')";
  			// 	$result4 = mysqli_query($koneksi, $query4);
  			// } else {
  			// 	$query3 = mysqli_query($koneksi, "SELECT * FROM subvariabel WHERE bobot='".$nilai_inputan."' AND id_variabel='".$i."'");
  		  //   $result3 = mysqli_fetch_array($query3);
        //
  			// 	$id_subvariabel = $result3['id_subvariabel'];
        //
  			// 	$query4 = "INSERT INTO detail_training(id_training, id_variabel, id_subvariabel, nilai_inputan)
  			// 						VALUES('".$id_training."', '".$i."', '".$id_subvariabel."', '".$nilai_inputan."')";
  			// 	$result4 = mysqli_query($koneksi, $query4);
  			// }

        $query4 = "INSERT INTO detail_training(id_training, id_variabel, nilai_inputan)
        VALUES('".$id_training."', '".$i."', '".$nilai_inputan."')";
        $result4 = mysqli_query($koneksi, $query4);

        echo $nilai_inputan." - ";
  		}
      //echo $status;
      echo "<br />";
  	}
  }

	// for($i=1; $i<=5; $i++){
	// 	$kolom = $i+1;
	// 	$nilai_inputan = $Row[$kolom];
	// 	$nilai_inputan = str_replace(".", "", $nilai_inputan);
	//
	// 	$query2 = mysqli_query($koneksi, "SELECT * FROM variabel WHERE id_variabel='".$i."'");
	// 	$result2 = mysqli_fetch_array($query2);
	//
	// 	if($result2['jenis']=="Angka Dengan Range"){
	// 		$query3 = mysqli_query($koneksi, "SELECT * FROM subvariabel WHERE id_variabel='".$i."' AND min <= '".$nilai_inputan."' AND max >= '".$nilai_inputan."'");
	// 		$result3 = mysqli_fetch_array($query3);
	//
	// 		$id_subvariabel = $result3['id_subvariabel'];
	// 		$subvariabel = $result3['nama'];
	//
	// 		echo $subvariabel." ";
	// 	} else {
	// 		$query3 = mysqli_query($koneksi, "SELECT * FROM subvariabel WHERE nama='".$nilai_inputan."'");
	// 		$result3 = mysqli_fetch_array($query3);
	//
	// 		$id_subvariabel = $result3['id_subvariabel'];
	// 		$subvariabel = $result3['nama'];
	//
	// 		echo $subvariabel." ";
	// 	}
	// }
	//
	// echo "<br />";
	$x++;
}
?>
