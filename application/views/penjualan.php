<div class="row">
	<div class="col-md-4">
		<a href="app/tambah_penjualan" class="btn btn-primary">Tambah Order</a>
		<!-- <a href="app/export_penjualan" target="_blank" class="btn btn-primary">Export</a> -->
	</div>
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
					<th>Kode po</th>
					<th>Tanggal po</th>
					<th>Total Bayar</th>
					<th>Pilihan</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$sql = $this->db->query("SELECT * FROM po order by id_po DESC");
				$no = 1;
				foreach ($sql->result() as $row) {
				 ?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $row->kode_po; ?></td>
					
					<td><?php echo $row->tgl_po; ?></td>
					<td><?php echo number_format($row->total_harga); ?></td>
					<td>
						<a href="app/detail_penjualan/<?php echo $row->kode_po ?>" class="btn btn-info btn-sm">detail</a>
						<a href="app/hapus_penjualan/<?php echo $row->kode_po ?>" class="btn btn-danger btn-sm" onclick="javasciprt: return confirm('Are You Sure ?')">hapus</a>
						<a href="app/cetak_penjualan/<?php echo $row->kode_po ?>" target="_blank" class="btn btn-success btn-sm">cetak</a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>