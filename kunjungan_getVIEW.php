	
<?php 

	$id = $_GET['idtransaksi_kunjungan'];
	
	//Importing database
	require_once('koneksi.php');
	
	//Membuat SQL Query dengan pegawai yang ditentukan secara spesifik sesuai ID
	//$sql = "SELECT * FROM transaksi_kunjungan WHERE idtransaksi_kunjungan=$id";
	
	$sql = "SELECT a.idtransaksi_kunjungan, a.tanggal, a.keterangan, a.barang, a.qtypcs, a.qtym, a.jam, b.nama as namakunjungan, c.nama as namacustomer, d.nama as namavisitor FROM transaksi_kunjungan a, jenis_kunjungan b, master_customer c, sales d WHERE a.idjenis_kunjungan=b.idjenis_kunjungan and a.idmaster_customer=c.idmaster_customer and a.idtransaksi_kunjungan=$id and d.idsales=a.idvisitor";

	//Mendapatkan Hasil 
	$r = mysqli_query($con,$sql);
	
	//Memasukkan Hasil Kedalam Array
	$result = array();
	$row = mysqli_fetch_array($r);
	array_push($result,array(
			"idtransaksi_kunjungan"=>$row['idtransaksi_kunjungan'],
			"tanggal"=>$row['tanggal'],
			"keterangan"=>$row['keterangan'],
			"barang"=>$row['barang'],
			"qtypcs"=>$row['qtypcs'],
			"qtym"=>$row['qtym'],
			"jam"=>$row['jam'],
			"namakunjungan"=>$row['namakunjungan'],
			"namacustomer"=>$row['namacustomer'],
			"namavisitor"=>$row['namavisitor']

));
 
	//Menampilkan dalam format JSON
	echo json_encode(array('result'=>$result));
	//echo $sql;
	mysqli_close($con);
?>