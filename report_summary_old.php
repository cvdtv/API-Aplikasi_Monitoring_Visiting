<?php 
    require_once('koneksi.php');
    //kunjungan(4), baru(1), followup(2), deal(3)
    $idsales = "";
    $jabatan = "";
    if(isset($_POST['idsales'])) $idsales = $_POST["idsales"];
    if(isset($_POST['jabatan'])) $jabatan = $_POST["jabatan"];
    if (isset($_POST['stanggal'])) $stanggal = $_POST['stanggal'];
    if (isset($_POST['etanggal'])) $etanggal = $_POST['etanggal'];

$sql = "";
    if($jabatan=="spv")
    {
      $sql = "select s.nama as SALES, sum(case when idjenis_kunjungan=1 and selesai=1 then 1 else 0 end) BARU,
           sum(case when idjenis_kunjungan=2 and selesai=1 then 1 else 0 end) FOLLOWUP,sum(case when idjenis_kunjungan=3 and selesai=1 then 1 else 0 end) DEAL,
           sum(case when idjenis_kunjungan=4 and selesai=1 then 1 else 0 end) KUNJUNGAN,
           sum(case when tipe='TUGAS' and selesai=1 then 1 else 0 end) TUGASSELESAI,
           sum(case when tipe='TUGAS' and selesai=0 then 1 else 0 end) TUGASBELUM
            from transaksi_kunjungan a, master_customer b, sales s where s.idsales=b.idsales and a.idmaster_customer=b.idmaster_customer and a.tanggal between '$stanggal' and '$etanggal' Group by b.idsales";
    }
    else if($jabatan=="sales")
    { 
      $sql = "select s.nama as SALES, sum(case when idjenis_kunjungan=1 and selesai=1 then 1 else 0 end) BARU,
           sum(case when idjenis_kunjungan=2 and selesai=1 then 1 else 0 end) FOLLOWUP,sum(case when idjenis_kunjungan=3 and selesai=1 then 1 else 0 end) DEAL,
           sum(case when idjenis_kunjungan=4 and selesai=1 then 1 else 0 end) KUNJUNGAN,
           sum(case when tipe='TUGAS' and selesai=1 then 1 else 0 end) TUGASSELESAI,
           sum(case when tipe='TUGAS' and selesai=0 then 1 else 0 end) TUGASBELUM
            from transaksi_kunjungan a, master_customer b, sales s where s.idsales=b.idsales and a.idmaster_customer=b.idmaster_customer and b.idsales='$idsales' and a.tanggal between '$stanggal' and '$etanggal' Group by b.idsales;";
    }
    else if($jabatan=="ts")
    { 
      $sql = "select s.nama as SALES, sum(case when idjenis_kunjungan=1 and selesai=1 then 1 else 0 end) BARU,
           sum(case when idjenis_kunjungan=2 and selesai=1 then 1 else 0 end) FOLLOWUP,sum(case when idjenis_kunjungan=3 and selesai=1 then 1 else 0 end) DEAL,
           sum(case when idjenis_kunjungan=4 and selesai=1 then 1 else 0 end) KUNJUNGAN,
           sum(case when tipe='TUGAS' and selesai=1 then 1 else 0 end) TUGASSELESAI,
           sum(case when tipe='TUGAS' and selesai=0 then 1 else 0 end) TUGASBELUM
            from transaksi_kunjungan a, master_customer b, sales s where s.idsales=b.idts and a.idmaster_customer=b.idmaster_customer and b.idts='$idsales' and a.tanggal between '$stanggal' and '$etanggal' Group by b.idts;";
    }
    $r = mysqli_query($con,$sql);
    $result = array();
    while($row = mysqli_fetch_array($r))
    {
        array_push($result,array(
            "SALES"=>$row['SALES'],
            "KUNJUNGAN"=>$row['KUNJUNGAN'],
            "BARU"=>$row['BARU'],
            "FOLLOWUP"=>$row['FOLLOWUP'],
            "DEAL"=>$row['DEAL']
        ));
    }
    
    echo json_encode(array('result'=>$result));
    //echo $sql;
    mysqli_close($con);
?>
