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

		 $id = $_POST['idtransaksi_kunjungan'];
		 		 
		 $sql = "DELETE FROM transaksi_kunjungan WHERE idtransaksi_kunjungan=$id";
		 $query = mysqli_query($con, "select path1, path2, path3, path4, path5, path1B, path2B, path3B, path4B, path5B from transaksi_kunjungan where idtransaksi_kunjungan=$id");

		 while($baris=mysqli_fetch_row($query))
		 {
			if($baris[0]!="")
			unlink(substr($baris[0],strpos($baris[0], 'foto'), strlen($baris[0])-strpos($baris[0], 'foto')+1));
			if($baris[1]!="")
			unlink(substr($baris[1],strpos($baris[1], 'foto'), strlen($baris[1])-strpos($baris[1], 'foto')+1));
			if($baris[2]!="")
			unlink(substr($baris[2],strpos($baris[2], 'foto'), strlen($baris[2])-strpos($baris[2], 'foto')+1));
			if($baris[3]!="")
			unlink(substr($baris[3],strpos($baris[3], 'foto'), strlen($baris[3])-strpos($baris[3], 'foto')+1));
			if($baris[4]!="")
			unlink(substr($baris[4],strpos($baris[4], 'foto'), strlen($baris[4])-strpos($baris[4], 'foto')+1));
			if($baris[5]!="")
			unlink(substr($baris[5],strpos($baris[5], 'asli'), strlen($baris[5])-strpos($baris[5], 'asli')+1));
			if($baris[6]!="")
			unlink(substr($baris[6],strpos($baris[6], 'asli'), strlen($baris[6])-strpos($baris[6], 'asli')+1));
			if($baris[7]!="")
			unlink(substr($baris[7],strpos($baris[7], 'asli'), strlen($baris[7])-strpos($baris[7], 'asli')+1));
			if($baris[8]!="")
			unlink(substr($baris[8],strpos($baris[8], 'asli'), strlen($baris[8])-strpos($baris[8], 'asli')+1));
			if($baris[9]!="")
			unlink(substr($baris[9],strpos($baris[9], 'asli'), strlen($baris[9])-strpos($baris[9], 'asli')+1));
		 }
		 
		 if(mysqli_query($con,$sql)){
		 	echo 'Berhasil Menghapus Kunjungan';
		 }else{
			 echo $sql;
		 	echo 'Gagal Menghapus Kunjungan';
		 }
		 
		 mysqli_close($con);
	}
 ?>