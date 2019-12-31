<?php 
$rs = $data->row();
 ?>
 <?php  
	// header("Content-type: application/vnd-ms-excel");
	// header("Content-Disposition: attachment; filename=PO.xls");
	// header("Pragma: no-cache");
	// header("Expires: 0");
	function xlsBOF() {
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
}
function xlsEOF() {
    echo pack("ss", 0x0A, 0x00);
}
function xlsWriteNumber($Row, $Col, $Value) {
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
}
function xlsWriteLabel($Row, $Col, $Value) {
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
} 
	header("Pragma: public");
         header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");;
        header("Content-Disposition: attachment;filename=detailpo.xls");
        header("Content-Transfer-Encoding: binary ");
?>

	<table border="1" width="100%">
			<tr>
	
          		 
<tr  colspan="5"><center>Laporan Detail PO</center></tr>
     		 <!-- $bar = $data->row(); -->

			</tr><?php  $nomo= $this->db->query("SELECT
 po.kode_po, po.tgl_po, po.total_harga ,
 barang.nama_barang , barang.harga,detail_po.kode_barang, barang.kode_barang,
 detail_po.qty
FROM po
  INNER JOIN detail_po
    ON po.kode_po = detail_po.kode_po
    
    INNER JOIN barang
    on detail_po.kode_barang=barang.kode_barang    
    
     where detail_po.kode_po = '$rs->kode_penjualan'");?>

				<?php foreach (  $nomo->result() as $rs);?>
				<tr>
				<th>Kode Transaksi</th>
				<td><?php echo $rs->kode_po; ?></td>
				<td colspan="2"></td>
				<th>Nama Pemesan</th>
				<td>HASAN for FRISKA</td>
				</tr>
			<tr></tr>
			<tr>	
				<th>Tgl Pembelian:</th>
				
				<th><?php echo $rs->tgl_po; ?></th>
				<td colspan="2"></td>
				<th>Total Harga:</th>
				<th>Rp. <?php echo number_format($rs->total_harga); ?></th>
			</tr>
			<tbody>
			<tr>
		</tr>
		
	</tbody>
		</table>
	</div>
	<div class="col-md-12">
		<table class="table table-bordered" style="margin-bottom: 10px" table border="1" width="100%" >
			<thead>
				<!-- // di bawah cuman contoh -->

				
				<!-- // diatas cuman contoh -->
				<tr>
					<th>No.</th>
<!-- 					<th>Kode Barang</th> -->
					<th>Nama Barang</th>
					<th>Qty</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
<?php  $lo= $this->db->query("SELECT
 po.kode_po, po.tgl_po, po.total_harga ,
 barang.nama_barang , barang.harga,detail_po.kode_barang, barang.kode_barang,
 detail_po.qty
FROM po
  INNER JOIN detail_po
    ON po.kode_po = detail_po.kode_po
    
    INNER JOIN barang
    on detail_po.kode_barang=barang.kode_barang    
    
     where detail_po.kode_po = '$rs->kode_po'");


     ?>   

			<?php $i=1; foreach($lo->result() as $r)
			 { ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $r->kode_barang; ?></td>
			<td><?php echo $r->nama_barang; ?></td>
			<td><?php echo $r->harga; ?></td>
			<td><?php echo $r->qty; ?></td>
			<td><?php 
						$totharga = $r->qty*$r->harga;
						echo $totharga;
						 ?></td>
		<?php $i++; } ?>
			<?php  ?>
</tr>

		<tr>
			
						<td colspan="5">Total</td>
						<td>Rp. <?php echo "<strong>" .number_format($rs->total_harga) . "</strong>"?></td>
					</tr>
		
	</tbody>

		</table>

	