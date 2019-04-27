<?php
	 //Mendefinisikan Konstanta
	 define('HOST','127.0.0.1');
	 define('USER','root');
	 define('PASS','hanyaadminyangtau');
	 define('DB','visiting');

	 $con = mysqli_connect(HOST,USER,PASS,DB) or die ('gagal konek ke database');
	 
	 define('HOSTGE','192.168.4.77');
	 define('USERGE','root');
	 define('PASSGE','hanyaadminyangtau');
	 define('DBGE','c_erp_sigk');

	 $conGE = mysqli_connect(HOSTGE,USERGE,PASSGE,DBGE) or die ('gagal konek ke database');

	  define('HOST599','192.168.5.99');
	  define('USER599','root');
	  define('PASS599','hanyaadminyangtau');
	  define('DB599','c_erp_plant_sigk');
	 
	  $con599 = mysqli_connect(HOST599,USER599,PASS599,DB599) or die ('gagal konek ke database');

    mysqli_query($con599, "delete from produk_opname_temp where TANGGAL>='".date("Y-m-01")."'");
    for($i=1;$i<=date("d");$i++)
    {
        if (strlen($i)==1) $i="0".$i;
        $sql = "insert into produk_opname_temp select '".date("Y-m-").$i."', PV_ID, L_ID, STOK from produk_opname where STOK<>0 and MONTH(TANGGAL)=MONTH(DATE_ADD(NOW(), INTERVAL -1 MONTH)) AND YEAR(TANGGAL)=YEAR(DATE_ADD(NOW(), INTERVAL -1 MONTH))";
        mysqli_query($con599, $sql);
    }
?>
