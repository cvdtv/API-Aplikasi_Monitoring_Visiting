<?php

    require_once ("koneksi.php");

    // $iddevice = "d4e89eb6-0a68-404f-939d-f26e8b2f9c45";
    // // if (isset($_POST['iddevice']))
    // //     $iddevice=$_POST['iddevice'];
    // // else
    // //     $iddevice=$_GET['iddevice'];

    // $cekakses = "select * from sales where iddevice='$iddevice'";
    // $cr = mysqli_query($con, $cekakses);
    // $result=array();
    // if (mysqli_num_rows($cr)==0){

    //     mysqli_close($con);
    //     echo "Anda Tidak Punya Akses!!!";
    //     return;

    // }else{

        $jabatan = "";
        $idsales = "";
        $latitude = "";
        $longitude = "";
        $idmaster_customer = "";
        
        if (isset($_GET['idsales'])) $idsales = $_GET['idsales'];
        if (isset($_GET['jabatan'])) $jabatan = $_GET['jabatan'];
        if (isset($_GET['idmaster_customer'])) $idmaster_customer = $_GET['idmaster_customer'];

        $query = mysqli_query($con, "SELECT idgroup_customer, nama from group_customer");
        $json = array();

        while($row = mysqli_fetch_assoc($query)){
            $json[] = $row;
        }

        echo json_encode($json);

        mysqli_close($con);
    // }
?>
