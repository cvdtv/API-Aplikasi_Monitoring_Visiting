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

			// $tgl = "";
			$keysales = "";
			$idcustomer = "";
			$tujuan = "";
			$total = "";
			$barang = "";
			$pcs = "";
			$hs = "";
			$no_do="";
			$keterangan="";


			$id_do = $_POST['id_do'];
			$tgl = $_POST['tgl'];
			$keysales = $_POST['keysales'];
			$idcustomer = $_POST['idcustomer'];
			$tujuan = $_POST['tujuan'];
			$total = $_POST['total'];
			$keterangan = $_POST['keterangan'];
			$no_do = $_POST['no_do'];

			$barang1 = $_POST['barang1'];
			$pcs1 = $_POST['pcs1'];
			$hs1 = $_POST['harga_satuan1'];

			$barang2 = $_POST['barang2'];
			$pcs2 = $_POST['pcs2'];
			$hs2 = $_POST['harga_satuan2'];

			$barang3 = $_POST['barang3'];
			$pcs3 = $_POST['pcs3'];
			$hs3 = $_POST['harga_satuan3'];

			mysqli_query($conGE, "DELETE FROM a_det_do where id_do='$id_do'");
			$sql = "UPDATE a_do set idcustomer='$idcustomer', keterangan='$keterangan', tujuan='$tujuan', total='$total', tgl='".date('Y-m-d', strtotime($tgl))."' where id_do='$id_do';";
			
			if($pcs1!=0)
				$sql .= "INSERT INTO a_det_do(id_do, barang, pcs, harga_satuan) VALUES ($id_do, '$barang1', '$pcs1', '$hs1');";
			if($pcs2!=0)
				$sql .= "INSERT INTO a_det_do(id_do, barang, pcs, harga_satuan) VALUES ($id_do, '$barang2', '$pcs2', '$hs2');";
			if($pcs3!=0)
				$sql .= "INSERT INTO a_det_do(id_do, barang, pcs, harga_satuan) VALUES ($id_do, '$barang3', '$pcs3', '$hs3');";

			if(mysqli_multi_query($conGE, $sql)){
				echo 'Berhasil Update data Kunjungan ';
			}else{
				echo 'Gagal update data Kunjungan';
				
			}
			echo $sql;
			mysqli_close($conGE);
		}
	}

?>
