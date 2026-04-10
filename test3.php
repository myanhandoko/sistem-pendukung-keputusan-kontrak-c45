<?php
$aturan = "absensi = 2 Hari AND pendidikan = SMA AND masa kerja = 1.5 Tahun THEN status = Tidak Layak ";
$aturan = str_replace("IF ", "", $aturan);
//$aturan = str_replace("AND", "", $aturan);
$index = strpos($aturan, " THEN");
$aturan = substr($aturan, 0, $index);
$aturan = explode(" AND ", $aturan);
echo $index."<br />";
echo json_encode($aturan)."<br />";
//$karyawan = "absensi = 2 Hari pendidikan = SMA kualitas kerja = >=80 disiplin = <80 masa kerja = 9 bulan prestasi = <80 komunikasi = >=80 tanggung jawab";
$karyawan = "absensi = 2 Hari AND masa kerja = 1.5 Tahun AND prestasi = >=80 AND disiplin = <80 AND pendidikan = SMA AND kualitas kerja = >=80 AND komunikasi = >=80 AND tanggung jawab = <80";
$karyawan = explode(" AND ", $karyawan);
echo json_encode($karyawan)."<br />";

$containsAllValues = array_intersect($aturan, $karyawan);
echo "Ketemu ? ".json_encode($containsAllValues);
?>
