<?php

    require_once ("koneksi.php");

    $iddevice = "682d4131-d2f7-4312-8e19-bdb42a9e1172";
    //  if (isset($_POST['iddevice']))
    //      $iddevice=$_POST['iddevice'];
    //  // else //untuk spinner tidak boleh ditutup
    //  //     $iddevice=$_GET['iddevice'];

    // $cekakses = "select * from sales where iddevice='$iddevice'";
    // $cr = mysqli_query($con, $cekakses);
    // $result=array();
    // if (mysqli_num_rows($cr)==0){

    //     mysqli_close($con);
    //     echo "Anda Tidak Punya Akses!!!";
    //     return;

    // }else{

        $strfilter = "";
        $filter = "";
        $filterjabatan = "";
        $jabatan = "";
        $idsales = "";
        $latitude = "";
        $longitude = "";
        $idmaster_customer = "";

        $tokens = isset($_POST['tokens'])?$_POST['tokens']:'';

        if (isset($_GET['idsales'])) $idsales = $_GET['idsales'];
        if (isset($_GET['jabatan'])) $jabatan = $_GET['jabatan'];
        if (isset($_GET['idmaster_customer'])) $idmaster_customer = $_GET['idmaster_customer'];
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

        //START SALES
        $querysales = "SELECT idsales, nama, jabatan FROM sales where jabatan='sales';";
        
        $r = mysqli_query($con, $querysales);        
        $JsonSales = array();
        while($row = mysqli_fetch_array($r)){
            $JsonSales[] = $row;
        }
        //END SALES

        //START TS
        $queryts = "SELECT idsales, nama, jabatan FROM sales where jabatan='ts'";
        
        $r = mysqli_query($con, $queryts);        
        $JsonTS = array();
        while($row = mysqli_fetch_array($r)){
            $JsonTS[] = $row;
        }
        //END TS

        //START GROUP CUSTOMER
        $querygc = mysqli_query($con, "SELECT * from group_customer");
        $JsonGroupCustomer = array();

        while($row = mysqli_fetch_assoc($querygc)){
            $JsonGroupCustomer[] = $row;
        }
        //END GROUP CUSTOMER

        //JENIS TOKO
        $queryjt = mysqli_query($con, "SELECT * FROM  jenis_toko ORDER BY idjenis_toko ASC");     
        $JsonJenisToko = array();

        while($row = mysqli_fetch_assoc($queryjt)){
            $JsonJenisToko[] = $row;
        }
        //END JENIS TOKO

        echo json_encode(array(array('spinnersales'=>$JsonSales, 'spinnerts'=>$JsonTS, 'spinnergroupcustomer'=>$JsonGroupCustomer, 'spinnerjenistoko'=>$JsonJenisToko)));
        mysqli_close($con);
    // }
?>
