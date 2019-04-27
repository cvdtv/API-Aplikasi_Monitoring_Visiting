<?php

    require_once ("koneksi.php");

    $iddevice = "10459713-e19f-4233-ad0f-ab880a2b8fcc";
     if (isset($_POST['iddevice']))
         $iddevice=$_POST['iddevice'];
      else //untuk spinner tidak boleh ditutup
          $iddevice=$_GET['iddevice'];

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
        $latitude = "";
        $longitude = "";
        $idmaster_customer = "";
        $strfilter = "";
        $filter = "";
        $filterjabatan = "";
        
        if (isset($_GET['idsales'])) $idsales = $_GET['idsales'];
        if (isset($_GET['jabatan'])) $jabatan = $_GET['jabatan'];
        if (isset($_GET['latitude'])) $latitude = $_GET['latitude'];
        if (isset($_GET['longitude'])) $longitude = $_GET['longitude'];
        if (isset($_GET['idmaster_customer'])) $idmaster_customer = $_GET['idmaster_customer'];
        if(isset($_GET['filterjabatan'])) $filterjabatan = " AND (jabatan='".$_GET['filterjabatan']."' or jabatan='spv')";

        //START SITE CUSTOMER

        if($latitude==0&&$longitude==0)
                $strkoor = "";
        else
                $strkoor = " AND cast(latitude as decimal (10,1))='".number_format($latitude,1)."' and cast(longitude as decimal (10,1))='".number_format($longitude,1)."' ";
            
	$idmaster_customer="";
        if($idmaster_customer!="")
                $strkoor .= " AND idmaster_customer=".$idmaster_customer;

        if($jabatan=="spv")
            $scustomer = "SELECT mc.idmaster_customer, mc.nama, mc.alamat, gc.idgroup_customer, gc.nama as namagroupcustomer FROM master_customer mc, group_customer gc WHERE mc.idgroup_customer=gc.idgroup_customer AND mc.idmaster_customer<>''".$strkoor." ORDER BY mc.nama";
        else if($jabatan=="sales")
            $scustomer = "SELECT mc.idmaster_customer, mc.nama, mc.alamat, gc.idgroup_customer, gc.nama  as namagroupcustomer FROM master_customer mc, group_customer gc WHERE mc.idgroup_customer=gc.idgroup_customer AND mc.idsales='$idsales'".$strkoor." ORDER BY mc.nama";
        else if($jabatan=="ts")
            $scustomer = "SELECT mc.idmaster_customer, mc.nama, mc.alamat, gc.idgroup_customer, gc.nama as namagroupcustomer FROM master_customer mc, group_customer gc WHERE mc.idgroup_customer=gc.idgroup_customer AND mc.idts='$idsales'".$strkoor." ORDER BY mc.nama";

        $jsonsCustomer = array();
        $runSCustomer = mysqli_query($con, $scustomer);

        while($row = mysqli_fetch_assoc($runSCustomer)){
            $jsonsCustomer[] = $row;
        }

        //END SITE CUSTOMER

        //START VISITOR
        $tokens = isset($_POST['tokens'])?$_POST['tokens']:'';

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
        $Visitor = "SELECT sales.*, GROUP_CONCAT(idmenu SEPARATOR',') as menu FROM sales, loginmenu where sales.idsales=loginmenu.idsales and sales.idsales<>''".$strfilter.$filterjabatan." GROUP BY sales.idsales Order by sales.nama;";
        
        $runVisitor = mysqli_query($con, $Visitor);        
        $jsonVisitor = array();

        while($row = mysqli_fetch_assoc($runVisitor)){
            $jsonVisitor[] = $row;
        }

        if($filter=="cekiddevice"&& !empty($jsonVisitor))
        {
            mysqli_query($con, "UPDATE sales set token='$tokens' where iddevice='$iddevice'");
        }
        
        //END VISITOR

        //JENIS KUNJUNGAN
        $JenisKunjungan = "SELECT * FROM  jenis_kunjungan ORDER BY idjenis_kunjungan ASC";
         
        $jsonJenisKunjungan = array();
        $runJenisKunjungan = mysqli_query($con, $JenisKunjungan);
         
        while($row = mysqli_fetch_assoc($runJenisKunjungan)){
            $jsonJenisKunjungan[] = $row;
        }

        //END JENIS KUNJUNGAN
        echo json_encode(array(array('sitecustomer'=>$jsonsCustomer, 'visitor'=>$jsonVisitor, 'jeniskunjungan'=>$jsonJenisKunjungan)));
        mysqli_close($con);
    }
?>
