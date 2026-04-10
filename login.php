<?php
include 'koneksi.php';
ob_start();
session_start();
if($_GET['aksi'] == "out") {
	unset($_SESSION['id_pengguna']);
	$_SESSION['success'] = 0;
	$_SESSION['message'] = "Anda berhasil logout...";
	//session_destroy();
	//header('location:index.php');
	echo"<script> window.location.href = 'index.php'; </script>";
	exit();
} else {
	$username = $_POST['username'];
	$pass = $_POST['password'];
	// pastikan username dan password adalah berupa huruf atau angka.

	$login=mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='".$username."' AND password='".$pass."'");
	$ketemu=mysqli_num_rows($login);

	// Apabila username dan password ditemukan
	if ($ketemu > 0) {
		$r=mysqli_fetch_array($login);
		$_SESSION['success'] = 1;
		$_SESSION['message']="Anda berhasil login";
		$_SESSION['id_pengguna'] = $r['id_pengguna'];
		$_SESSION['level'] = $r['hak_akses'];
		if($r['hak_akses']=="Pimpinan"){
			header('location:home.php?page=beranda');
		} else {
			header('location:home.php');
		}
	} else{
		$_SESSION['success'] = 0;
		$_SESSION['message']="Username atau password anda tidak terdaftar !!";
		header('location:index.php');
	}
}
?>
