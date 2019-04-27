<?php

	require_once('koneksi.php');

	$iddevice = "";
    if (isset($_POST['iddevice'])) $iddevice=$_POST['iddevice'];
    $cekakses = "select * from sales where iddevice='$iddevice'";
    $cr = mysqli_query($con, $cekakses);
    $result=array();
    if (mysqli_num_rows($cr)==0){

        mysqli_close($con);
        echo "Anda Tidak Punya Akses!!!";
        return;

    }else{

		if($_SERVER['REQUEST_METHOD']=='POST'){

			$idmaster_customer = $_POST['idmaster_customer'];
			$tipe = $_POST['tipe'];
			$selesai = $_POST['selesai'];
			
			$sql = "INSERT INTO transaksi_kunjungan (tanggal, keterangan, idjenis_kunjungan, idmaster_customer, timestamp, tipe, selesai, idvisitor) VALUES (date(now()), 'Request Kunjungan Dari Sales', '1','$idmaster_customer', now(), '$tipe', 0, '')";

			//Eksekusi Query database
			if(mysqli_query($con,$sql)){
				echo 'Request Kunjungan Berhasil Di Tambahkan';
			}else{
				echo $sql;
				echo 'Request Kunjungan Gagal Di Tambahkan';
			}
			mysqli_close($con);
		}
	}

?>
