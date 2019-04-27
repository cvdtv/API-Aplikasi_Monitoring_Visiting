<?php
 		
//Import File Koneksi database
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

			$tanggal = $_POST['tanggal'];
			$keterangan = $_POST['keterangan'];
			$barang = $_POST['barang'];
			$qtypcs = $_POST['qtypcs'];
			$qtym = $_POST['qtym'];
			$jam = $_POST['jam'];
			$idjenis_kunjungan = $_POST['jenis'];
			$idmaster_customer = $_POST['customer'];
			$tipe = $_POST['tipe'];
			$selesai = $_POST['selesai'];
			// $timestamp = $_POST['timestamp'];
			$idvisitor = $_POST['idvisitor'];
			

			$image1="";
			$image2="";
			$image3="";
			$image4="";
			$image5="";

			$actualpath = "";
			$actualpath1 = "";
			$actualpath2 = "";
			$actualpath3 = "";
			$actualpath4 = "";
			$actualpath5 = "";

			if (isset($_POST['actualpath'])) $actualpath = $_POST['actualpath'];
			
			if(isset($_POST['path1'])) {
				$timestamp = date('Y_m_d__H_i_s');
				$image1 = $_POST['path1'];
				$path1 = "foto/$idmaster_customer-$timestamp-1.jpg";
				$actualpath1 = $actualpath.$path1;
			}else{
				$image1 = "";
				$path1 = "";
			}
			if(isset($_POST['path2'])) {

				$timestamp = date('Y_m_d__H_i_s');
				$image2 = $_POST['path2'];
				$path2 = "foto/$idmaster_customer-$timestamp-2.jpg";
				$actualpath2 = $actualpath.$path2;
			}else{
				$image2 = "";
				$path2 = "";
			}
			if(isset($_POST['path3'])) {
				$timestamp = date('Y_m_d__H_i_s');
				$image3 = $_POST['path3'];
				$path3 = "foto/$idmaster_customer-$timestamp-3.jpg";
				$actualpath3 = $actualpath.$path3;
			}else{
				$image3 = "";
				$path3 = "";
			}
			if(isset($_POST['path4'])) {
				$timestamp = date('Y_m_d__H_i_s');
				$image4 = $_POST['path4'];
				$path4 = "foto/$idmaster_customer-$timestamp-4.jpg";
				$actualpath4 = $actualpath.$path4;
			}else{
				$image4 = "";
				$path4 = "";
			}
			if(isset($_POST['path5'])) {
				$timestamp = date('Y_m_d__H_i_s');
				$image5 = $_POST['path5'];
				$path5 = "foto/$idmaster_customer-$timestamp-5.jpg";
				$actualpath5 = $actualpath.$path5;
			}else{
				$image5 = "";
				$path5 = "";
			}

			$sql = "INSERT INTO transaksi_kunjungan (tanggal, keterangan, barang, qtypcs, qtym, jam, idjenis_kunjungan, idmaster_customer, timestamp, tipe, selesai, path1, path2, path3, path4, path5, idvisitor, end_at) VALUES (STR_TO_DATE('$tanggal', '%d-%m-%Y'),'$keterangan','$barang','$qtypcs','$qtym','$jam','$idjenis_kunjungan','$idmaster_customer',now(), '$tipe', $selesai, '$actualpath1', '$actualpath2', '$actualpath3', '$actualpath4', '$actualpath5', '$idvisitor', '2000-01-01 00:00:01')";
			
			if(mysqli_query($con, $sql)){
				
				if($tipe=="TUGAS"&&$selesai==0){
					require_once "notification.php";
					$notification = new Notification();
					$tokensales = mysqli_fetch_row(mysqli_query($con, "SELECT token from sales where idsales=$idvisitor"));
					$selectnama = mysqli_fetch_row(mysqli_query($con, "SELECT nama from master_customer where idmaster_customer=".$idmaster_customer));
					// echo $tokensales[0];
					$result = $notification->sendFCMSingle("", "", $tokensales[0], $notification->setNotification("TUGAS BARU", "Anda mendapatkan tugas kunjungan ke ".$selectnama[0]));

					//if ($actualpath1 != "" || $actualpath2 != "" || $actualpath3 != "" || $actualpath4 != "" || $actualpath5 != "" ) {
					//}

					echo 'Berhasil Menambahkan Tugas '.$selectnama;
				}
				else
				{
					if($path1!="") file_put_contents($path1,base64_decode($image1));
					if($path2!="") file_put_contents($path2,base64_decode($image2));
					if($path3!="") file_put_contents($path3,base64_decode($image3));
					if($path4!="") file_put_contents($path4,base64_decode($image4));
					if($path5!="") file_put_contents($path5,base64_decode($image5));						
					echo 'Berhasil Menambahkan Kunjungan';
				}
			}else{
				echo 'Gagal Menambahkan Kunjungan';
				echo $sql;
			}
			mysqli_error($con);
			mysqli_close($con);

		}
	}

?>
