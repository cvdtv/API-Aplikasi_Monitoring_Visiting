<?php 
	require_once('koneksi.php');

    $TANGGAL="DATE(NOW())";
    
	$sql = "SELECT * from sales;";

	$r = mysqli_query($con599, $sql);
	
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		array_push($result,array(
			"idsales"=>$row['idsales'],
			"nama"=>$row['nama']
		));
	}
	
	echo json_encode(array('result'=>$result));
	//echo $etanggal;
	mysqli_close($con);
?>
