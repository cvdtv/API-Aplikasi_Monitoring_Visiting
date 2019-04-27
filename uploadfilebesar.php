<?php 
 
 	if($_SERVER['REQUEST_METHOD']=='POST'){
		//MEndapatkan Nilai Dari Variable 
		$id = $_POST['idtransaksi_kunjungan'];

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

		if (isset($_POST['namafile1'])) $namafile1 = $_POST['namafile1'];
		if (isset($_POST['namafile2'])) $namafile2 = $_POST['namafile2'];
		if (isset($_POST['namafile3'])) $namafile3 = $_POST['namafile3'];
		if (isset($_POST['namafile4'])) $namafile4 = $_POST['namafile4'];
		if (isset($_POST['namafile5'])) $namafile5 = $_POST['namafile5'];
		
		if(isset($_POST['path1'])) {
			//ini lokasi file besar mula2 di gadget
			$image1 = $_POST['path1'];
			
			//ini lokasi file image besar diambil dari nama file di java
			$path1 = "asli/$namafile1";
			//update database
			$actualpath1 = ", path1B='$actualpath$path1'";
		}else{
			$image1 = "";
			$path1 = "";
		}
		if(isset($_POST['path2'])) {
			//ini lokasi file besar mula2 di gadget
			$image2 = $_POST['path2'];
			
			//ini lokasi file image besar diambil dari nama file di java
			$path2 = "asli/$namafile2";
			//update database
			$actualpath2 = ", path2B='$actualpath$path2'";
		}else{
			$image2 = "";
			$path2 = "";
		}
		if(isset($_POST['path3'])) {
			//ini lokasi file besar mula2 di gadget
			$image3 = $_POST['path3'];
			
			//ini lokasi file image besar diambil dari nama file di java
			$path3 = "asli/$namafile3";
			//update database
			$actualpath3 = ", path3B='$actualpath$path4'";
		}else{
			$image3 = "";
			$path3 = "";
		}
		if(isset($_POST['path4'])) {
			//ini lokasi file besar mula2 di gadget
			$image4 = $_POST['path4'];
			
			//ini lokasi file image besar diambil dari nama file di java
			$path4 = "asli/$namafile4";
			//update database
			$actualpath4 = ", path4B='$actualpath$path4'";
		}else{
			$image4 = "";
			$path4 = "";
		}
		if(isset($_POST['path5'])) {
			//ini lokasi file besar mula2 di gadget
			$image5 = $_POST['path5'];
			
			//ini lokasi file image besar diambil dari nama file di java
			$path5 = "asli/$namafile5";
			//update database
			$actualpath5 = ", path5B='$actualpath$path5'";
		}else{
			$image5 = "";
			$path5 = "";
		}

		//import file koneksi database 
		require_once('koneksi.php');
		
		$sql = "UPDATE transaksi_kunjungan set edited=now() $actualpath1 $actualpath2 $actualpath3 $actualpath4 $actualpath5 WHERE idtransaksi_kunjungan = $id";
		
		//Meng-update Database 
		if(mysqli_query($con,$sql)){
			if($path1!="")
				file_put_contents($path1,base64_decode($image1));
			if($path2!="")
				file_put_contents($path2,base64_decode($image2));
			if($path3!="")
				file_put_contents($path3,base64_decode($image3));
			if($path4!="")
				file_put_contents($path4,base64_decode($image4));
			if($path5!="")
				file_put_contents($path5,base64_decode($image5));
			echo 'Berhasil Update Data Kunjungan';
		}else{
			echo $sql;
			echo 'Gagal Update Data Kunjungan';
		}
		echo $sql;
		mysqli_close($con);
	}
?>
