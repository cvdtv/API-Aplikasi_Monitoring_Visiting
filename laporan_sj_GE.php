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
	
		$keysales = "";
		if(isset($_POST['keysales'])) $keysales = $_POST['keysales'];
		if(isset($_POST['jabatan'])) $jabatan = $_POST['jabatan'];
		if (isset($_POST['stanggal'])) $stanggal = $_POST['stanggal'];
	    if (isset($_POST['etanggal'])) $etanggal = $_POST['etanggal'];

		if($jabatan=="spv"){
	        $query= "SELECT sj.SJ_NO, TGL_SJ, CUS_NAMA, OP_TJ, OP_ID FROM suratjalan sj, det_suratjalan detsj WHERE sj.SJ_NO=detsj.SJ_NO AND MONTH(sj.TGL_SJ)=MONTH(NOW()) AND YEAR(sj.TGL_SJ)=YEAR(NOW()) and TGL_SJ between '$stanggal' and '$etanggal' ORDER BY sj.TGL_SJ ASC";
		}
		else{
		$query= "SELECT sj.SJ_NO, TGL_SJ, CUS_NAMA, OP_TJ, OP_ID FROM suratjalan sj, det_suratjalan detsj WHERE sj.SJ_NO=detsj.SJ_NO AND MONTH(sj.TGL_SJ)=MONTH(NOW()) AND YEAR(sj.TGL_SJ)=YEAR(NOW()) and OP_SALES='$keysales' and TGL_SJ between '$stanggal' and '$etanggal' ORDER BY sj.TGL_SJ ASC";
		}
		
		$r = mysqli_query($conGE,$query);
		
		$result = array();
		
		while($row = mysqli_fetch_array($r)){
			
			array_push($result,array(
				"SJ_NO"=> $row['SJ_NO'],
				"TGL_SJ"=>$row['TGL_SJ'],
				"CUS_NAMA"=>$row['CUS_NAMA'],
				"OP_TJP"=>$row['OP_TJ'],
				"OP_ID"=>$row['OP_ID']
			));
		}
		
		echo json_encode(array('result'=>$result));
		
		mysqli_close($conGE);
	}
?>
