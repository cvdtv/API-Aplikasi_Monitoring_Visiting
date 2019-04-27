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

		$idsales ="";
		$idts="";
	 	if($_SERVER['REQUEST_METHOD']=='POST'){
			//MEndapatkan Nilai Dari Variable 
			$id = $_POST['idmaster_customer'];
			$nama = $_POST['nama'];
			$alamat = $_POST['alamat'];
			$telp = $_POST['telp'];
			$contact_person = $_POST['contact_person'];
			$hp = $_POST['hp'];
			$idjenis_toko = $_POST['idjenis_toko'];
			$idsales = $_POST ['idsales'];
			$idts = $_POST ['idts'];
			$lat = $_POST['latitude'];
			$lang = $_POST['longitude'];
			$idgroup_customer = $_POST['idgroup_customer'];
		
			//Membuat SQL Query
			$sql = "UPDATE master_customer SET nama = '$nama', alamat = '$alamat', telp = '$telp', contact_person = '$contact_person', hp = '$hp', idjenis_toko = '$idjenis_toko', idsales = '$idsales', idts='$idts', edited=now(), latitude='$lat', longitude='$lang', idgroup_customer='$idgroup_customer' WHERE idmaster_customer = $id";
			
			//Meng-update Database 
			if(mysqli_query($con,$sql)){
				echo 'Berhasil Update Data Customer';
				// echo $sql;
			}else{
				echo 'Gagal Update Data Customer';
				echo $sql;
			}
		
			mysqli_close($con);
		}
	}
?>
