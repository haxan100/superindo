<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class baru extends CI_Controller {

	public function index()
	{
		echo "hello";
	}
	public function apa($value='')
	{
		$this->load->view('apa');
	}

}

/* End of file baru.php */
/* Location: ./application/controllers/baru.php */