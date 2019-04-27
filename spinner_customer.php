<?php

    require_once ("koneksi.php");

    $iddevice = "4D928FF9-8EA9-45AD-90A0-0CEA284488C1";
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
        $idsales = "17";
        $latitude = "";
        $longitude = "";
        $idmaster_customer = "";
        
        if (isset($_GET['idsales'])) $idsales = $_GET['idsales'];
        if (isset($_GET['jabatan'])) $jabatan = $_GET['jabatan'];
        if (isset($_GET['latitude'])) $latitude = $_GET['latitude'];
        if (isset($_GET['longitude'])) $longitude = $_GET['longitude'];
        if (isset($_GET['idmaster_customer'])) $idmaster_customer = $_GET['idmaster_customer'];

        if($latitude==0&&$longitude==0)
                $strkoor = "";
        else
                $strkoor = " AND cast(latitude as decimal (10,3))='".number_format($latitude,3)."' and cast(longitude as decimal (10,3))='".number_format($longitude,3)."' ";
            
        if($idmaster_customer!="")
                $strkoor .= " AND idmaster_customer=".$idmaster_customer;

        if($jabatan=="spv")
            $query = mysqli_query($con, "SELECT mc.idmaster_customer, mc.nama, mc.alamat, gc.idgroup_customer, gc.nama as namagroupcustomer FROM master_customer mc, group_customer gc WHERE mc.idgroup_customer=gc.idgroup_customer AND mc.idmaster_customer<>''".$strkoor." ORDER BY mc.nama");
        else if($jabatan=="sales")
            $query = mysqli_query($con, "SELECT mc.idmaster_customer, mc.nama, mc.alamat, gc.idgroup_customer, gc.nama  as namagroupcustomer FROM master_customer mc, group_customer gc WHERE mc.idgroup_customer=gc.idgroup_customer AND mc.idsales='$idsales'".$strkoor." ORDER BY mc.nama");
        else if($jabatan=="ts")
            $query = mysqli_query($con, "SELECT mc.idmaster_customer, mc.nama, mc.alamat, gc.idgroup_customer, gc.nama as namagroupcustomer FROM master_customer mc, group_customer gc WHERE mc.idgroup_customer=gc.idgroup_customer AND mc.idts='$idsales'".$strkoor." ORDER BY mc.nama");

        $json = array();

        while($row = mysqli_fetch_assoc($query)){
            $json[] = $row;
        }

        echo json_encode($json);

        mysqli_close($con);
    }
?>
