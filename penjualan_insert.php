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

			$tgl = "";
			$keysales = "";
			$idcustomer = "";
			$tujuan = "";
			$total = "";
			$barang = "";
			$pcs = "";
			$hs = "";
			$keterangan="";


			$tgl = $_POST['tgl'];
			$keysales = $_POST['keysales'];
			$idcustomer = $_POST['idcustomer'];
			$tujuan = $_POST['tujuan'];
			$total = $_POST['total'];
			$keterangan = $_POST['keterangan'];

			$barang1 = $_POST['barang1'];
			$pcs1 = $_POST['pcs1'];
			$hs1 = $_POST['harga_satuan1'];

			$barang2 = $_POST['barang2'];
			$pcs2 = $_POST['pcs2'];
			$hs2 = $_POST['harga_satuan2'];

			$barang3 = $_POST['barang3'];
			$pcs3 = $_POST['pcs3'];
			$hs3 = $_POST['harga_satuan3'];

			$bln = date('m');
			$thn = date('Y');
			$blnthn = $bln.$thn;
			$cekno="SELECT MAX(no_do) FROM a_do WHERE no_do like '$keysales-%$blnthn%' ORDER BY no_do;";
	        $baris = mysqli_fetch_row(mysqli_query($conGE, $cekno));

			 if($baris[0] == "")
	            $count = 0;
	        else
	            $count = substr($baris[0], 12, 4);

	        $prefix = $keysales."-".$blnthn."-".sprintf("%04d", $count+1);

			$sql = "INSERT INTO a_do (tgl, no_do, keysales, idcustomer, tujuan, keterangan, total) VALUES (STR_TO_DATE('$tgl', '%d-%m-%Y'), '$prefix', '$keysales', '$idcustomer', '$tujuan', '$keterangan', '$total');";
			if($pcs1!=0)
				$sql .= "INSERT INTO a_det_do(id_do, barang, pcs, harga_satuan) VALUES ((select id_do from a_do where no_do='$prefix'), '$barang1', '$pcs1', '$hs1');";
			if($pcs2!=0)
				$sql .= "INSERT INTO a_det_do(id_do, barang, pcs, harga_satuan) VALUES ((select id_do from a_do where no_do='$prefix'), '$barang2', '$pcs2', '$hs2');";
			if($pcs3!=0)
				$sql .= "INSERT INTO a_det_do(id_do, barang, pcs, harga_satuan) VALUES ((select id_do from a_do where no_do='$prefix'), '$barang3', '$pcs3', '$hs3');";

			if(mysqli_multi_query($conGE, $sql)){
				echo 'Berhasil Menambahkan Kunjungan';
				echo $sql;
			}else{
				echo 'Gagal Menambahkan Kunjungan';
				echo $sql;
			}
			
			mysqli_close($conGE);
		}
	}

?>