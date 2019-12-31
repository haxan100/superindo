<div class="alert alert-success">
  <strong>Selamat Datang</strong>,  <?php echo $this->session->userdata('nama'); ?>.
</div>

<div class="alert alert-info">
 <?php 
                if ($this->session->userdata('username') == 'admin') {
                 ?>



  <p>
  ini adalah menu admin
  </p>

 <?php 
                } elseif ($this->session->userdata('username') == 'manajer') {
                 ?>
  <p>
  ini adalah menu manajer
  </p>




  <?php 
                } elseif ($this->session->userdata('username') == 'oficer') {
                 ?>
  <p style="color: white">
  ini adalah menu <?php echo $this->session->userdata('username'); ?>
  </p>

  <?php } ?>
</div>
<div>
	<div class="alert alert-danger">
  <p style="color: white" font-size:12>
  gunakan menu ini dengan sebaik baiknya
  </p> </div>

            <?php $this->load->view('config/footer.php'); ?>
        </div>

