<?php 
 
	include_once ('koneksi.php');

    $jabatan = "";
    $idsales = "";
    $tipe = "";
    $idmaster_customer = "";
    $stanggal = "";
    $etanggal = "";
    $valuefilter = "45";
    if (isset($_POST['idsales'])) $idsales = $_POST['idsales'];
    if (isset($_POST['jabatan'])) $jabatan = $_POST['jabatan'];
    if (isset($_POST['tipe'])) $tipe = $_POST['tipe'];
    if (isset($_POST['idmaster_customer'])) $idmaster_customer = $_POST['idmaster_customer'];
    if (isset($_POST['stanggal'])) $stanggal = $_POST['stanggal'];
    if (isset($_POST['etanggal'])) $etanggal = $_POST['etanggal'];
    if (isset($_POST['valuefilter'])) $valuefilter = $_POST['valuefilter'];

	$strfilter = "";
	$filter = "";
	if(isset($_POST['filter']))
	{
		$filter = $_POST['filter'];

		if($filter=="customer")
		{
			$strfilter = " AND a.idmaster_customer=".$valuefilter;
		}
		else if($filter=="laporankunjungan")
		{
			if($idmaster_customer=="")
				$strfilter = "";
			else
				$strfilter = " AND a.idmaster_customer='$idmaster_customer'";
		}
	}

	
	$strtipe = "";
	if($tipe=="KUNJUNGAN")
		$strtipe = "";
	else if($tipe=="TUGAS")
		$strtipe = " AND a.tipe='TUGAS' and a.selesai=0";
	else
		$strtipe = "";

	$query = "SELECT a.idtransaksi_kunjungan, a.tanggal, a.barang, a.jam, a.keterangan, b.nama as jenis, c.nama as customer, qtypcs, qtym, a.tipe, a.selesai, d.nama as visitor FROM
			transaksi_kunjungan a, jenis_kunjungan b, master_customer c, sales d
			WHERE a.idjenis_kunjungan=b.idjenis_kunjungan and a.idmaster_customer=c.idmaster_customer and d.idsales=a.idvisitor".$strfilter." Order by a.timestamp";


	$r = mysqli_query($con,$query);
	$result = array();
			if(mysqli_num_rows($r)==0)
			{
                array_push($result,array(
                        "idtransaksi_kunjungan"=>"",
                        "customer"=>"",
                        "tanggal"=>"",
                        "jenis"=>"",
                        "keterangan"=>"",
                        "barang"=>"",
                        "jam"=>"",
                        "qtypcs"=>"",
                        "qtym"=>"",
                        "tipe"=>"",
                        "selesai"=>"",
                        "visitor"=>""
                        ));

	}
	else
	{	
	while($row = mysqli_fetch_array($r)){
		
		array_push($result,array(
			"idtransaksi_kunjungan"=>$row['idtransaksi_kunjungan'],
			"customer"=>$row['customer'],
			"tanggal"=>$row['tanggal'],
			"jenis"=>$row['jenis'],
			"keterangan"=>$row['keterangan'],
			"barang"=>$row['barang'],
			"jam"=>$row['jam'],
			"qtypcs"=>$row['qtypcs'],
			"qtym"=>$row['qtym'],
			"tipe"=>$row['tipe'],
			"selesai"=>$row['selesai'],
			"visitor"=>$row['visitor']
			));
	}
}
	echo json_encode(array('result'=>$result));
	//echo $query;
	mysqli_close($con);
?>
