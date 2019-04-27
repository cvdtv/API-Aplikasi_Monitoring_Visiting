<?php 
 
	require_once ('koneksi.php');

//	 $iddevice = "4D928FF9-8EA9-45AD-90A0-0CEA284488C1";
      if (isset($_POST['iddevice'])) 
      	$iddevice=$_POST['iddevice'];
      else
      	$iddevice=$_GET['iddevice'];

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
//		$iddevice = "10459713-e19f-4233-ad0f-ab880a2b8fcc";
		$filterjabatan = "";

		$tokens = isset($_POST['tokens'])?$_POST['tokens']:'';

		if(isset($_GET['filterjabatan'])) $filterjabatan = " AND (jabatan='".$_GET['filterjabatan']."' or jabatan='spv')";
		if(isset($_POST['filter']))
		{
			$filter = $_POST['filter'];
			$iddevice = $_POST['iddevice'];
			if($filter=="cekiddevice")
			{
				$strfilter = " AND iddevice='".$iddevice."'";
			}

		}

		//select all about sales
		$query = "SELECT sales.*, GROUP_CONCAT(idmenu SEPARATOR',') as menu FROM sales, loginmenu where sales.idsales=loginmenu.idsales and sales.idsales<>''".$strfilter.$filterjabatan." GROUP BY sales.idsales Order by sales.nama;";
		
		$r = mysqli_query($con, $query);		
		$result = array();
		while($row = mysqli_fetch_array($r)){
			$result[] = $row;
		}
		
		//update 28022019 update token to 5.99
		$keysales = "";
		$query = "select keysales from sales where sales.idsales<>''".$strfilter;
		$r = mysqli_query($con, $query);
		while ($baris = mysqli_fetch_row($r)){
			$keysales = $baris[0];
		}
		
		if($filter=="cekiddevice"&& !empty($result))
		{
			mysqli_query($con, "UPDATE sales set token='$tokens' where iddevice='$iddevice'");
			mysqli_query($con599, "UPDATE sales set token='$tokens' where S_ID='$keysales'");
		}
		
		echo json_encode($result);
		mysqli_close($con);
	 }
?>
