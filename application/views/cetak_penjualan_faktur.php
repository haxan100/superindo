<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo base_url() ?>">
	<title>Cetak Struk Faktur</title>
	<link rel="stylesheet" type="text/css" href="assets/bootflat-admin/css/bootstrap.min.css">
</head>
<body >
	<table class="table">
	<div class="container col-md-12">
	<center>
		<h4> Kepada Yth, <br><strong>Superindo Taman Palem</strong></h4>
		<p>Jl. permata taman palem</p>
		<p>Telp.  021 54373392</p><!-- 
		<img src="<?php echo base_url(); ?>images/superindo.png"> -->
		</center>
</table>

	<?php 
	$rs = $data->row();
	 ?>
	<div class="row">
		<div class="col-md-6">
			<table class="table">
				<p>Berikut ini kami sampaikan terkait Order oleh PT.Lion Superindo kemarin  </p>
				<tr>
					<th>Kode faktur</th>
					<th>:</th>
					<td><?php echo $rs->kode_faktur; ?></td>
					<!-- <th>Nama Pelanggan</th>
					<th>:</th>
					<td><?php echo $rs->nama_pelanggan; ?></td> -->
				</tr>
				<tr>
					<th>Tgl transaksi</th>
					<th>:</th>
					<td><?php echo $rs->tgl_faktur; ?></td>
					
				</tr>
			</table>
		</div>
		<div class="col-md-8">
			<table class="table table-bordered" style="margin-bottom: 10px" >
				<thead>
					<tr>
						<th>No.</th>
						<th>Kode Barang</th>
						<th>Nama Barang</th>
						<th>Qty</th>
						<th>Harga</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$sql = $this->db->query("SELECT * FROM faktur
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
						<td><?php echo $row->kode_barang; ?></td>
						<td><?php echo $row->nama_barang; ?></td>
						
						<td><?php echo $row->qty; ?></td>
						
						<td><?php echo $row->harga; ?></td>
						<td><?php 
						$totharga = $row->qty*$row->harga;
						echo number_format($totharga);
						 ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td colspan="5">Total</td>
						<td>Rp. <?php echo number_format($rs->total_harga) ?></td>
					</tr>
					<!-- <tr>
						<td colspan="6"><b>Diskon Keseluruhan (10%)</b></td>
						<td>
							Rp.
						<?php 
						$diskon = 0;
						if ($rs->total_harga >= 100000) {
							$diskon = 0.1 * $rs->total_harga;
						} else {
							$diskon = 0;
						 
						}
						echo number_format($diskon)

						?>
						</td>
					</tr>
					<tr>
						<td colspan="6"><b>Total Bayar</b></td>
						<td>Rp. <?php echo number_format($rs->total_harga-$diskon) ?></td>
					</tr> -->
				</tbody>
			</table>

			<div style="text-align: right;">
				<p>Jakarta, <?php echo date('d/m/Y') ?></p>
				<br>
				<p>Hormat Kami,</p>
				<p><td><?php echo $this->session->userdata('nama'); ?></td></p>
			</div>
		</div>
	</div>
</div>


<script src='assets/jspdf.debug.js'></script>
	<script src='assets/html2pdf.js'></script>
	<script>
		var pdf = new jsPDF('l', 'pt', 'A4');
		var canvas = pdf.canvas;
		var width = 1200;
		var height = 800;
		//canvas.width=8.5*72;
		document.body.style.width=width + "px";

		html2canvas(document.body, {
		    canvas:canvas,
		    onrendered: function(canvas) {
		        var iframe = document.createElement('iframe');
		        iframe.setAttribute('style', 'position:absolute;top:0;right:0;height:100%; width:100%');
		        document.body.appendChild(iframe);
		        iframe.src = pdf.output('datauristring');

		       //var div = document.createElement('pre');
		       //div.innerText=pdf.output();
		       //document.body.appendChild(div);
		    }
		});
     </script>


</body>
</html>