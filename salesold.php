<?php 
 
	include_once ('koneksi.php');

	$strfilter = "";
	$filter = "";
	$iddevice = "";
	if(isset($_POST['filter']))
	{
		$filter = $_POST['filter'];
		$iddevice = $_POST['iddevice'];
		if($filter=="cekiddevice")
		{
			$strfilter = " AND iddevice='".$iddevice."'";
		}
	}

	$query = "SELECT * FROM sales where idsales<>''".$strfilter;
	$r = mysqli_query($con,$query);
	
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		array_push($result,array(
			"idsales"=>$row['idsales'],
			"nama"=>$row['nama'],
			"iddevice"=>$row['iddevice'],
			"jabatan"=>$row['jabatan']
			));
	}
	
	echo json_encode(array('result'=>$result));
	//echo $query;
	mysqli_close($con);
?>