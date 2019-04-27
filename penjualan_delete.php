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
			
			$id_do="";
			$id_do = $_POST['id_do'];

			$sql = "DELETE FROM a_det_do where id_do='$id_do';";
			mysqli_query($conGE, $sql);
			$sql1 = "DELETE FROM a_do where id_do='$id_do';";

			if(mysqli_query($conGE, $sql1)){
				
				echo 'Berhasil Hapus data Kunjungan';
			}else{
				echo 'Gagal Hapus data Kunjungan';
				echo $sql;
			}
			
			mysqli_close($conGE);
		}
	}

?>