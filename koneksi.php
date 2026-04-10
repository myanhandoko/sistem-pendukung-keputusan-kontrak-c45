<?php
$server = "localhost";
$username = "root";
$password = "The04101998";
$database = "daj";
//$database = "id3";
// koneksi dan memilih database di server
$koneksi = mysqli_connect($server, $username, $password, $database);

function tanggalIndo($date) {
	$BulanIndo = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");

	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl   = substr($date, 8, 2);

	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " " . $tahun;
	return($result);
}

function is_decimal($n) {
	// Note that floor returns a float
	return is_numeric($n) && floor($n) != $n;
}

function tanggalJamIndo($date) {
	$BulanIndo = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");

	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl   = substr($date, 8, 2);

	$jam   = substr($date, 11, 2);
	$menit   = substr($date, 14, 2);

	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " " . $tahun . " " . $jam . ":" . $menit;
	return($result);
}

function jamIndo($date) {
	$jam   = substr($date, 11, 2);
	$menit   = substr($date, 14, 2);

	$result = $jam . ":" . $menit;
	return($result);
}

function numberFormat($harga){
	return (number_format($harga, 0, ",", "."));
}
?>
