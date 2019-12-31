<?php  
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=laporan.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
?>

<table border="1" width="100%">
	<thead>


		<tr>
		</tr>
		<tr>Laporan  Data Barang</tr>
		
		<tr>
			<th>NO</th>
			<th>KODE BARANG</th>
			<th>NAMA BARANG </th>
			<th>HARGA</th>
			<th>STOK </th>
		</tr>
	</thead>
	
	<tbody>
		<?php $i=1; foreach($barang->result() as $row){ ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->kode_barang; ?></td>
			<td><?php echo $row->nama_barang; ?></td>
			<td><?php echo $row->harga; ?></td>
			<td><?php echo $row->stok; ?></td>
		</tr>
		<?php $i++; } ?>
	</tbody>
</table>