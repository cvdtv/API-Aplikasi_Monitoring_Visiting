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

		$query = "SELECT * FROM sales where jabatan='ts' and idsales<>''".$strfilter;
		$r = mysqli_query($con,$query);
		
		$result = array();

		while($row = mysqli_fetch_assoc($r)){
			$result[] = $row;
		}
		
		echo json_encode($result);
		mysqli_close($con);
	}
?>