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
 
		 $id = $_POST['idmaster_customer'];
		 
		 $sql = "DELETE FROM master_customer WHERE idmaster_customer=$id";
		 
		 if(mysqli_query($con,$sql)){
		 	echo 'Berhasil Menghapus Customer';
		 }else{
		 	echo 'Data Customer Sudah Dipakai';
		 	echo $sql;
		 }
		 
		 mysqli_close($con);
	}
 ?>