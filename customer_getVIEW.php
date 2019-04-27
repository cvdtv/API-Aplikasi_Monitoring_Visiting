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

		$id = $_GET['idmaster_customer'];
		$sql = "SELECT a.*, b.idjenis_toko, b.nama as jenis_toko,  IFNULL((select tk.idtransaksi_kunjungan from transaksi_kunjungan tk where tk.idmaster_customer=a.idmaster_customer and tk.selesai=0 and tk.idvisitor=''),0) as rk FROM master_customer a, jenis_toko b WHERE a.idjenis_toko=b.idjenis_toko and a.idmaster_customer=$id";
		
		//Mendapatkan Hasil 
		$r = mysqli_query($con,$sql);
		
		//Memasukkan Hasil Kedalam Array
		$result = array();
		$row = mysqli_fetch_array($r);
		array_push($result,array(
				"idmaster_customer"=>$row['idmaster_customer'],
				"nama"=>$row['nama'],
				"alamat"=>$row['alamat'],
				"telp"=>$row['telp'],
				"contact_person"=>$row['contact_person'],
				"hp"=>$row['hp'],
				"idjenis_toko"=>$row['idjenis_toko'],
				"jenis_toko"=>$row['jenis_toko'],
				"idsales"=>$row['idsales'],
				// "sales"=>$row['sales'],
				"idts"=>$row['idts'],
				"lat"=>$row['lat'],
				"lang"=>$row['lang'],
				"rk"=>$row['rk']
		));
	 
		echo json_encode(array('result'=>$result));
		mysqli_close($con);
	}
?>