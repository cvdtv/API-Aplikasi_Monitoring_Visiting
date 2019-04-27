<?php 
 
    require_once ('koneksi.php');

     $iddevice = "10459713-e19f-4233-ad0f-ab880a2b8fcc";
    if (isset($_POST['iddevice'])) $iddevice=$_POST['iddevice'];
    $cekakses = "select * from sales where iddevice='$iddevice'";
    $cr = mysqli_query($con, $cekakses);
    $result=array();
    if (mysqli_num_rows($cr)==0){

        mysqli_close($con);
        echo "Anda Tidak Punya Akses!!!";
        return;

    }else{

	    $jabatan = "spv";
	    $idsales = "";
	    $tipe = "";
	    $idmaster_customer = "";
	    $idgroup_customer = "";
	    $stanggal = "";
	    $etanggal = "";
	    $valuefilter = "";
	    if (isset($_POST['idsales'])) $idsales = $_POST['idsales'];
	    if (isset($_POST['jabatan'])) $jabatan = $_POST['jabatan'];
	    if (isset($_POST['tipe'])) $tipe = $_POST['tipe'];
	    if (isset($_POST['idmaster_customer'])) $idmaster_customer = $_POST['idmaster_customer'];
	    if (isset($_POST['idgroup_customer'])) $idgroup_customer = $_POST['idgroup_customer'];
	    if (isset($_POST['stanggal'])) $stanggal = $_POST['stanggal'];
	    if (isset($_POST['etanggal'])) $etanggal = $_POST['etanggal'];
	    if (isset($_POST['valuefilter'])) $valuefilter = $_POST['valuefilter'];

		$strfilter = "";
//		$filter = "laporankunjungan";
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
                        else if($filter=="laporankunjungangroup")
                        {
                                if($idgroup_customer=="")
                                        $strfilter = " AND a.TANGGAL between '$stanggal' and '$etanggal'";
                                else
                                        $strfilter = " AND d.idgroup_customer='$idgroup_customer' AND a.TANGGAL between '$stanggal' and '$etanggal'";
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
            }
            else if($jabatan=="sales")
            {
                if($idsales=="")
                    $strsales = "";
                else
					$strsales = " AND idvisitor='$idsales'";
            }
            else if($jabatan=="ts")
	            {
                    if($idsales=="")
                        $strsales = "";
                    else
						$strsales = " AND idvisitor='$idsales'";
            }
            else{
                    $strsales = "";
                }
		}else{
			if($jabatan=="spv")
				$strsales = "";
			else
				$strsales = " AND idvisitor='$idsales'";
		}

		if($tipe=="KUNJUNGAN")
			$strtipe = "";
		else if($tipe=="TUGAS")
				$strtipe = " AND a.tipe='TUGAS' and a.selesai=0";
		else
			$strtipe = "";

		// $query = "SELECT query1.*, sales.nama as visitor from (SELECT a.idtransaksi_kunjungan, a.tanggal, a.barang, a.jam, a.keterangan, b.idjenis_kunjungan, b.nama as jenis, c.idmaster_customer, c.nama as namacus, qtypcs, qtym, a.tipe, a.selesai, a.path1, a.path2, a.path3, a.path4, a.path5, a.path1B, a.path2B, a.path3B, a.path4B, a.path5B, a.idvisitor, a.idvisitor as request, a.timestamp, a.end_at, if(a.end_at='2000-01-01 00:00:01',0,TIMESTAMPDIFF(MINUTE, a.timestamp, a.end_at)) as lama_kunjungan FROM
		// 		transaksi_kunjungan a, jenis_kunjungan b, master_customer c, group_customer d
		// 		WHERE 	 a.idjenis_kunjungan=b.idjenis_kunjungan and a.idmaster_customer=c.idmaster_customer and c.idgroup_customer=d.idgroup_customer".$strsales.$strfilter.$strtipe." Order 	by a.timestamp desc)query1
		// 		left join sales on query1.idvisitor=sales.idsales";

		$query = "SELECT query1.*, sales.nama as visitor from (SELECT if(end_at='2000-01-01 00:00:01', 'BLM', 'SDH') as flgsls,a.idtransaksi_kunjungan, a.tanggal, a.barang, a.jam, a.keterangan, b.idjenis_kunjungan, b.nama as jenis, c.idmaster_customer, c.nama as namacus, qtypcs, qtym, a.tipe, a.selesai, a.path1, a.path2, a.path3, a.path4, a.path5, a.path1B, a.path2B, a.path3B, a.path4B, a.path5B, a.idvisitor, a.idvisitor as request, a.timestamp, a.end_at, if(a.end_at='2000-01-01 00:00:01',0,TIMESTAMPDIFF(MINUTE, a.timestamp, a.end_at)) as lama_kunjungan FROM
				transaksi_kunjungan a, jenis_kunjungan b, master_customer c, group_customer d
				WHERE 	 a.idjenis_kunjungan=b.idjenis_kunjungan and a.idmaster_customer=c.idmaster_customer and c.idgroup_customer=d.idgroup_customer ".$strsales.$strfilter.$strtipe.")query1
				left join sales on query1.idvisitor=sales.idsales order by flgsls, timestamp desc;";

		$r = mysqli_query($con,$query);
		$result = array();

		if(mysqli_num_rows($r)==0){
	    array_push($result,array(
            "idtransaksi_kunjungan"=>"",
            "idmaster_customer"=>"",
            "namacus"=>"",
            "tanggal"=>"",
            "idjenis_kunjungan"=>"",
            "jenis"=>"",
            "keterangan"=>"",
            "barang"=>"",
            "jam"=>"",
            "qtypcs"=>"",
            "qtym"=>"",
            "tipe"=>"",
            "selesai"=>"",
            "path1"=>"",
            "path2"=>"",
            "path3"=>"",
            "path4"=>"",
            "path5"=>"",
            "path1B"=>"",
            "path2B"=>"",
            "path3B"=>"",
            "path4B"=>"",
            "path5B"=>"",
            "idvisitor"=>"",
            "visitor"=> "",
            "request"=>"",
            "timestamp"=>"",
            "end_at"=>"",
            "lama_kunjungan"=>""
        ));

		}else{	
			while($row = mysqli_fetch_array($r)){
				
				$lengkap = 0;
				$lengkap1 = 0;
				$lengkap2 = 0;
				$lengkap3 = 0;
				$lengkap4 = 0;
				$lengkap5 = 0;
				if($row['path1']!="")
				{
					if(basename($row['path1'])==basename($row['path1B'])) {
						$lengkap1=1;
					}
					else{
						$lengkap1=0;
					}
				}
				else
					$lengkap1=1;

				if($row['path2']!="")
				{
					if(basename($row['path2'])==basename($row['path2B'])) {
						$lengkap2=1;
					}
					else{
						$lengkap2=0;
					}
				}
				else
					$lengkap2=1;

				if($row['path3']!="")
				{
					if(basename($row['path3'])==basename($row['path3B'])) {
						$lengkap3=1;
					}
					else{
						$lengkap3=0;
					}
				}		
				else{
					$lengkap3=1;
				}

				if($row['path4']!="")
				{
					if(basename($row['path4'])==basename($row['path4B'])) {
						$lengkap4=1;
					}
					else{
						$lengkap4=0;
					}
				}
				else{
					$lengkap4=1;
				}

				if($row['path5']!="")
				{
					if(basename($row['path5'])==basename($row['path5B'])) {
						$lengkap5=1;
					}else{
						$lengkap5=0;
					}
				}else{
					$lengkap5=1;
				}

				if($lengkap1==1&&$lengkap2==1&&$lengkap3==1&&$lengkap4==1&&$lengkap5==1){
					$lengkap=1;
				}
				else{
					$lengkap=0;
				}
										
	                array_push($result,array(
                        "lengkap"=>$lengkap,
                        "idtransaksi_kunjungan"=>$row['idtransaksi_kunjungan'],
                        "idmaster_customer"=>$row['idmaster_customer'],
                        "namacus"=>$row['namacus'],
                        "tanggal"=>$row['tanggal'],
                        "idjenis_kunjungan"=>$row['idjenis_kunjungan'],
                        "jenis"=>$row['jenis'],
                        "keterangan"=>$row['keterangan'],
                        "barang"=>$row['barang'],
                        "jam"=>$row['jam'],
                        "qtypcs"=>$row['qtypcs'],
                        "qtym"=>$row['qtym'],
                        "tipe"=>$row['tipe'],
                        "selesai"=>$row['selesai'],
                        "path1"=>$row['path1'],
                        "path2"=>$row['path2'],
                        "path3"=>$row['path3'],
                        "path4"=>$row['path4'],
                        "path5"=>$row['path5'],
                        "path1B"=>$row['path1B'],
                        "path2B"=>$row['path2B'],
                        "path3B"=>$row['path3B'],
                        "path4B"=>$row['path4B'],
                        "path5B"=>$row['path5B'],
                        "idvisitor"=>$row['idvisitor'],
                        "visitor"=>$row['visitor'],
                        "request"=>$row['request'],
                        "timestamp"=>$row['timestamp'],
                        "end_at"=>$row['end_at'],
                        "lama_kunjungan"=>$row['lama_kunjungan']
                    ));
			}
		}

//		echo $query;

		echo json_encode(array('result'=>$result));
		mysqli_close($con);
	}
?>
