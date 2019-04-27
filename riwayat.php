
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
    	$jabatan = "";
	    $idsales = "";
	    $tipe = "";
	    $idmaster_customer = "";
	    $stanggal = "";
	    $etanggal = "";
	    $valuefilter = "";

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
			else if($filter=="editkunjungan")
			{
				$strfilter = " AND a.idtransaksi_kunjungan=".$valuefilter;
			}
			else if($filter=="tanggal")
			{
				$strfilter = " AND a.TANGGAL='$valuefilter'";
			}
			else if($filter=="laporankunjungan")
			{
				if($idmaster_customer=="")
					$strfilter = " AND a.TANGGAL between '$stanggal' and '$etanggal'";
				else
					$strfilter = " AND a.idmaster_customer='$idmaster_customer' AND a.TANGGAL between '$stanggal' and '$etanggal'";
			}
		}

		$strsales = "";

		if($filter=="laporankunjungan")
		{
            if($jabatan=="spv")
            {
                if($idsales=="")
                    $strsales = "";
                else
					$strsales = " AND idvisitor='$idsales'";
            }else if($jabatan=="sales"){
                if($idsales=="")
                        $strsales = "";
                else
					$strsales = " AND idvisitor='$idsales'";
            }else if($jabatan=="ts"){
                if($idsales=="")
                    $strsales = "";
                else
					$strsales = " AND idvisitor='$idsales'";
            }else{
               $strsales = "";
            }
		}else{
			if($jabatan=="spv")
				$strsales = "";
			else
				$strsales = " AND idvisitor='$idsales'";
		}

		$strtipe = "";
		if($tipe=="KUNJUNGAN")
			$strtipe = "";
		else if($tipe=="TUGAS")
			$strtipe = " AND a.tipe='TUGAS' and a.selesai=0";
		else
			$strtipe = "";

		$query = "SELECT *, sales.nama as visitor from (SELECT a.idtransaksi_kunjungan, a.tanggal, a.barang, a.jam, a.keterangan, b.nama as jenis, c.nama as customer, qtypcs, qtym, a.tipe, a.selesai, a.path1, a.path2, a.path3, a.path4, a.path5, a.idvisitor FROM
				transaksi_kunjungan a, jenis_kunjungan b, master_customer c
				WHERE a.idjenis_kunjungan=b.idjenis_kunjungan and a.idmaster_customer=c.idmaster_customer and a.idmaster_customer='$idmaster_customer'".$strsales.$strfilter.$strtipe." Order by a.timestamp desc limit 0,100)query1
				left join sales on query1.idvisitor=sales.idsales";


		$r = mysqli_query($con,$query);
		$result = array();
		if(mysqli_num_rows($r)==0)
		{
            array_push($result,array(
				"status"=>"kosong",
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
                "visitor"=> ""
            ));

		}else{
			while($row = mysqli_fetch_array($r)){
				
				array_push($result,array(
					"status"=>"isi",
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
		mysqli_close($con);
	}
?>
