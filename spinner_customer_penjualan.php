<?php 
  
    require_once ("koneksi.php");

    $iddevice = "";
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
 
		$query = mysqli_query($conGE, "SELECT CUS_ID, CUS_NAMA FROM customer ORDER BY CUS_NAMA"); 
	    $json = array();    
	     
	    while($row = mysqli_fetch_assoc($query)){
	        $json[] = $row;
	    }
	     
	    echo json_encode($json);
	    mysqli_close($conGE);
	}
?>
