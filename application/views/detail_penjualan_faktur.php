<?php 
$rs = $data->row();
 ?>
<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tr>
				 <?php 
				$sql = $this->db->query("SELECT * FROM faktur order by id_faktur DESC");
				$no = 1;
				
				 ?>
				
          		  <a href="supplier/cetak_penjualan_faktur/<?php echo $rs->kode_faktur ?>" target="_blank" 
          		  	<button style="float: right;" class="btn btn-success btn-sm fa fa-file-pdf-o" title="Print"></button></a>


          		  	<i style="float: right;">&nbsp;</i>
          		  <a href="<?php echo base_url(). "index.php/supplier/export_excel_faktur/$rs->kode_faktur"; ?>">
            	  <button style="float: right;" class="btn btn-sm btn-success fa fa-file-excel-o" title="haha"></button>
          		  </a>
					<i style="float: right;">&nbsp;</i>	
				<i style="float: right;">&nbsp;</i>	
				 <a href="supplier/export_excel_faktur/<?php echo $rs->kode_faktur ?>" target="_blank" 
          		  	<button style="float: right;" class="btn btn-outline-warning btn-sm fa fa-file-excel-o" title="excel"></button></a>
          		  			</tr>
			<tr>
				<th>Kode Faktur</th>
				<th>:</th>
				<td><?php echo $rs->kode_faktur; ?></td>
				<td>Kepada Yth, <br> <strong>PT.Lion Superindo (taman palm)</strong> </td> 
				
				
			<tr><th>Nama Supllier</th>
				<th>:</th>
				<td><?php echo $this->session->userdata('nama'); ?></td>
				<td>Permata Taman Surya Blok C-01</td>

</tr>

			</tr>
			<tr>
				<th>Tgl Pembelian</th>
				<th>:</th>
				<td><?php echo $rs->tgl_faktur; ?></td>
				<td>Jakarta Barat Telp. 021 54373392</td>
				<!-- <th>Total Harga</th>
				<th>:</th>
				<td>Rp. <?php echo number_format($rs->total_harga); ?></td> -->
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
					<th>jumlah harga</th>
					<th>Total Harga</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$sql = $this->db->query(" SELECT faktur.id_faktur,faktur.kode_faktur, faktur.tgl_faktur, faktur.total_harga,
detail_faktur.kode_faktur, detail_faktur.kode_barang, detail_faktur.qty,
barang.kode_barang, barang.nama_barang, barang.harga FROM faktur
  INNER JOIN detail_faktur
    ON faktur.kode_faktur = detail_faktur.kode_faktur
    
    INNER JOIN barang
    on detail_faktur.kode_barang=barang.kode_barang
     where faktur.kode_faktur ='$rs->kode_faktur'");
				$no = 1;
				foreach ($sql->result() as $row) {
				 ?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $rs->kode_barang; ?></td>
					<td><?php echo $row->nama_barang; ?></td>
					
					<td><?php echo $row->harga; ?></td>
					<td><?php echo $row->qty; ?></td>
					<td><?php echo $r=$row->qty*$row->harga; ?></td>
					<td>+</td>
				</tr>
				<?php } ?>
				<td colspan="6"><strong>TOTAL</strong></td>
				
				<td><strong>
<b>Rp. <?php echo number_format($rs->total_harga); ?></b></strong></td>
			</tbody>

		</table>

	</div>

	<div class="row">
	<div class="col-md-6">
	<table  class="table">
		<br>

<br>
		<tr>
			
				<th>Hormat Kami</th>
				
				<br>
				
				<td><?php echo $this->session->userdata('nama'); ?>
					</td><td></td><tr></tr>

			</tr>
	</table>
</div>
</div>
</div>