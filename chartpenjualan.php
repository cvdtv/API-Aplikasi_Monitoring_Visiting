<?php 
 
    require_once ('koneksi.php');

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

    	$periode="2018";
    	$jenisproduk = "001";
    	$keysales = "S001";
    	$option = "qty" //pilih qty / nominal;

		// $query = "SELECT CONCAT(MONTH(INV_TGL),'-',YEAR(INV_TGL)) AS PERIODE, OP_SALES AS SALES, produk.JENIS, jenis_produk.NAMA, SUM(det_op.KUBIK) AS QTY, SUM(OP_NETTO+OP_PPN) AS NOMINAL FROM op, det_op, produk, jenis_produk WHERE op.OP_ID=det_op.OP_ID AND det_op.PV_ID=produk.PV_ID AND produk.JENIS=jenis_produk.ID AND YEAR(INV_TGL)='$periode' and produk.JENIS='$jenisproduk' and OP_SALES='$keysales' GROUP BY CONCAT(MONTH(INV_TGL),'-',YEAR(INV_TGL)), OP_SALES, produk.JENIS;";
		if ($option=="qty")
			$query = "SELECT CONCAT(MONTH(INV_TGL),'-',YEAR(INV_TGL)) AS PERIODE, OP_SALES AS SALES, produk.JENIS, jenis_produk.NAMA, SUM(det_op.KUBIK) AS NILAI FROM op, det_op, produk, jenis_produk WHERE op.OP_ID=det_op.OP_ID AND det_op.PV_ID=produk.PV_ID AND produk.JENIS=jenis_produk.ID AND YEAR(INV_TGL)='$periode' and produk.JENIS='$jenisproduk' and OP_SALES='$keysales' GROUP BY CONCAT(MONTH(INV_TGL),'-',YEAR(INV_TGL)), OP_SALES, produk.JENIS;";
		else if($option=="nominal")
			$query = "SELECT CONCAT(MONTH(INV_TGL),'-',YEAR(INV_TGL)) AS PERIODE, OP_SALES AS SALES, produk.JENIS, jenis_produk.NAMA, SUM(OP_NETTO+OP_PPN) AS NILAI FROM op, det_op, produk, jenis_produk WHERE op.OP_ID=det_op.OP_ID AND det_op.PV_ID=produk.PV_ID AND produk.JENIS=jenis_produk.ID AND YEAR(INV_TGL)='$periode' and produk.JENIS='$jenisproduk' and OP_SALES='$keysales' GROUP BY CONCAT(MONTH(INV_TGL),'-',YEAR(INV_TGL)), OP_SALES, produk.JENIS;";

		$r = mysqli_query($conGE,$query);
		$result = array();

		while($row = mysqli_fetch_array($r)){

			array_push($result,array(
				"PERIODE"=>$row['PERIODE'],
				"SALES"=>$row['SALES'],
				"JENIS"=>$row['JENIS'],
				"NAMA"=>$row['NAMA'],
				"NILAI"=>$row['NILAI']
				// "QTY"=>$row['QTY'],
				// "NOMINAL"=>$row['NOMINAL']
			));
		}

		echo json_encode(array('result'=>$result));
		mysqli_close($conGE);
	}
?>