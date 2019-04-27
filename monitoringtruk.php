<?php
    require_once('koneksi.php');
 
        $jabatan = "";
        $sql = "";
        $jenisproduk = "";
        $filter = "";
        $keysales = "";

        // if (isset($_POST['idsales'])) $idsales = $_POST['idsales'];
        if (isset($_POST['jabatan'])) $jabatan = $_POST['jabatan'];
        if (isset($_POST['keysales'])) $keysales = $_POST['keysales'];
        if (isset($_POST['filter'])) $filter = $_POST['filter'];

        $strsales = "";
        $strgrupsales = "";

        if(strtoupper($keysales)=="M"){
        
        }else{
            $strsales = " AND suratjalan.OP_SALES='$keysales'";
        }

        $sql = "SELECT monitoringtruk.NOPOL, concat(monitoringtruk.SOPIR, ' - ', monitoringtruk.EKSPEDISI) as sopir, monitoringtruk.SJ_NO, IFNULL(suratjalan.CUS_NAMA, '') AS CUS_NAMA, IFNULL(suratjalan.OP_TJ, '') AS OP_TJ, monitoringtruk.JAMMASUK, monitoringtruk.JAMKELUAR, GROUP_CONCAT(DISTINCT det_suratjalan.PV_NAMA, ' - ', ROUND(KUBIK,2) SEPARATOR ', ') as barang FROM monitoringtruk LEFT JOIN suratjalan ON monitoringtruk.SJ_NO=suratjalan.SJ_NO LEFT JOIN det_suratjalan ON monitoringtruk.SJ_NO=det_suratjalan.SJ_NO WHERE DATE(monitoringtruk.JAMMASUK)>DATE_ADD(NOW(), INTERVAL -3 DAY)".$strsales." GROUP BY monitoringtruk.SJ_NO  ORDER BY monitoringtruk.JAMMASUK desc;";


        $r = mysqli_query($con599, $sql);
        $result = array();
        while($row = mysqli_fetch_array($r)){
            $textdisplay = "Nopol\t\t\t\t\t\t\t:  ".$row["NOPOL"]."\nSopir\t\t\t\t\t\t\t\t:  ".$row["sopir"]."\nCustomer\t\t\t:  ".$row["CUS_NAMA"]."\nNo.\tSJ\t\t\t\t\t\t:  ".$row["SJ_NO"]."\nBarang\t\t\t\t\t\t:  ".$row["barang"]."\nTujuan\t\t\t\t\t\t:  ".$row["OP_TJ"]."\nJam Masuk\t\t:  ".$row["JAMMASUK"]."\nJam Keluar\t\t:  ".$row["JAMKELUAR"];
            array_push($result, array(
                "text"=>$textdisplay
            ));
        }
        // echo $sql;
        echo json_encode(array('result'=>$result));
        mysqli_close($con599);

    // }
?>
