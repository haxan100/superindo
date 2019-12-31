<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo base_url() ?>">
	<title>Cetak Struk po</title>
	<link rel="stylesheet" type="text/css" href="assets/bootflat-admin/css/bootstrap.min.css">
</head>
<body >
	<table class="table">
	<div class="container col-md-12">
	<center>
		
		
		<h4> <img src="image/superindo.png" alt="placeholder+image" height="25" width="29"> Superindo Taman Palem</h4>
		<p>Jl. permata taman palem</p>
		<p>Telp. (0741)-612673</p><!-- 
		<img src="<?php echo base_url(); ?>images/superindo.png"> -->
		</center>
</table>

	<?php 
	$rs = $data->row();
	 ?>
	<div class="row">
		<div class="col-md-6">
			<table class="table">
				<p>Berikut ini kami sampaikan terkai Order pada tanggal <?php echo $rs->tgl_po; ?> untuk selanjutnya besok di kirim. </p>
				<tr>
					<?php 
//  $this->zend->load('Zend/Barcode');
// Zend_Barcode::render('code128', 'image', array('text'=>$kode_po), array());
  ?>
					<th>Kode po</th>
					<th>:</th>
					<td><?php echo $rs->kode_po; ?></td>
					
					<td><!-- 
				<img src="<?php echo site_url();?>/app/cetak_penjualan/<?php echo $kode_po;?>" > -->
			</td>
				</tr>
				<tr>
					<th>Tgl po</th>
					<th>:</th>
					<td><?php echo $rs->tgl_po; ?></td>
					
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
						<th>Supplier</th>
						<th>Qty</th>
						<th>Harga</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$sql = $this->db->query("SELECT * FROM detail_po as a,barang as b, supplier as s where a.kode_barang=b.kode_barang and b.kode_supplier=s.kode_supplier and a.kode_po='$rs->kode_po' ");
					$no = 1;
					foreach ($sql->result() as $row) {
					 ?>
					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $row->kode_barang; ?></td>
						<td><?php echo $row->nama_barang; ?></td>
						<td><?php echo $row->nama_supplier; ?></td>
						<td><?php echo $row->qty; ?></td>
						

						<td><?php echo $row->harga; ?></td>
						<td><?php 
						$totharga = $row->qty*$row->harga;
						echo number_format($totharga);
						 ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td colspan="6">Total</td>
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
				<p>Pt.Lion Superindo</p><!--  -->
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