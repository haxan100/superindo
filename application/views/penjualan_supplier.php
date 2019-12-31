<div class="row">
		<?php
$level = $this->session->userdata('ap_level');

		if($this->session->userdata('users') == 'oficer'){
			redirect(); }
?>
	<div class="col-md-4"></div>
	<div class="col-md-4"></div><br><br><br>
	<div class="col-md-12">
		<table class="table table-bordered" style="margin-bottom: 10px" id="example">
			<thead>
				<tr>
					<th>No.</th>
					<th>Kode Faktur</th>
					<th>Tanggal Transaksi</th>
					<th>Total Bayar</th>
					<th>Pilihan</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$sql = $this->db->query("SELECT * FROM faktur order by id_faktur DESC");
				$no = 1;
				foreach ($sql->result() as $row) {
				 ?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $row->kode_faktur; ?></td>
					
					<td><?php echo $row->tgl_faktur; ?></td>
					<td><?php echo number_format($row->total_harga); ?></td>
					<td>
						<a href="supplier/detail_penjualan/<?php echo $row->kode_faktur ?>" class="btn btn-info btn-sm">detail</a>
						<a href="supplier/hapus_penjualan/<?php echo $row->kode_faktur ?>" class="btn btn-danger btn-sm" onclick="javasciprt: return confirm('Are You Sure ?')">hapus</a>
						<a href="supplier/cetak_penjualan/<?php echo $row->kode_faktur ?>" target="_blank" class="btn btn-success btn-sm">cetak</a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>