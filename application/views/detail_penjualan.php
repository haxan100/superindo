<?php 
$rs = $data->row();
 ?>
<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tr>
				
				
          		  <!-- End Print Manual -->

          		  <!-- Print Excel -->
          		  
          		  <!-- End Print Excel -->

          		  <!-- Print Pdf -->
          		  <?php 
				$sql = $this->db->query("SELECT * FROM po order by id_po DESC");
				$no = 1;
				
				 ?>

          		  <a href="app/cetak_penjualan/<?php echo $rs->kode_po ?>" target="_blank" 
          		  	<button style="float: right;" class="btn btn-success btn-sm fa fa-file-pdf-o" title="Print"></button></a>

<!-- 
          		  	<i style="float: right;">&nbsp;</i>
          		  <a href="<?php echo base_url(). "index.php/app/export_excel"; ?>">
            	  <button style="float: right;" class="btn btn-sm btn-success fa fa-file-excel-o" title="EXCEL"></button>
          		  </a>
					<i style="float: right;">&nbsp;</i>	 -->
				<i style="float: right;">&nbsp;</i>	
				 <a href="app/export_excel/<?php echo $rs->kode_po ?>" target="_blank" 
          		  	<button style="float: right;" class="btn btn-outline-warning btn-sm fa fa-file-excel-o" title="excel"></button></a>
          		 <!--  <i style="float: right;">&nbsp;</i>
          		  <a href="<?php echo base_url(). "index.php/app/export_pdf"; ?>" target = "_blank">
          		  <button style="float: right;" class="btn btn-sm btn-danger fa fa-file-pdf-o" title="PDF"></button>
          		  </a> -->
			</tr>
			<tr>
				<th>Kode Transaksi</th>
				<th>:</th>
				<td><?php echo $rs->kode_po; ?></td>
				<th>Nama Pemesan</th>
				<th>:</th>
				<td>HASAN for FRISKA</td>
			</tr>
			<tr>
				<th>Tgl Pembelian</th>
				<th>:</th>
				<td><?php echo $rs->tgl_po; ?></td>
				<th>Total Harga</th>
				<th>:</th>
				<td>Rp. <?php echo number_format($rs->total_harga); ?></td>
			</tr>
			
		</table>
	</div>
	<div class="col-md-12">
		<table class="table table-bordered" style="margin-bottom: 10px" >
			<thead>
				<tr>
					<th>No.</th>
					<th>Kode Barang</th>
					<th>Nama Barang</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$sql = $this->db->query("SELECT * FROM detail_po as a,barang as b where a.kode_barang=b.kode_barang and a.kode_po='$rs->kode_po' ");
				$no = 1;
				foreach ($sql->result() as $row) {
				 ?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $row->kode_barang; ?></td>
					<td><?php echo $row->nama_barang; ?></td>
					
					<td><?php echo $row->harga; ?></td>
					<td><?php echo $row->qty; ?></td>

					<td><?php echo $totjum=$row->harga*$row->qty;?></td>
				</tr>
				<?php } ?>

			</tbody>

		</table>

	</div>

	<div class="row">
	<div class="col-md-6">
	<table  class="table">
		<br>


		<tr>
			
				<th>Hormat Kami</th>
				<th>:</th>
				<td>Superindo Taman Palem</td>
					
			</tr>
	</table>
</div>
</div>
</div>