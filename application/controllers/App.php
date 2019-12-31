<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
public function __construct() { 
parent::__construct(); 
$this->load->library('Zend');
$this->load->library('form_validation');
$this->load->model('Supplier_model');
$this->load->library('Pdf');
$this->load->library('dom2pdf');
$this->load->model('Barang_model');
$this->load->model('supplier_model');
$this->load->model('user_model');
$this->load->model('users_model');
$this->load->model('no_urut');
$this->load->model('merk_barang_model');
$this->load->model('barang_masuk_model');
// parent::__construct(); $this->load->library('zend');


 //tambahkan dalam contruct pemanggil libarary mail
function __construct()
	{
		parent::__construct();
		if($this->session->userdata('users') == 'oficer'){
			redirect();
		}
	}
}
	



	function sendMail() 
{
$ci = get_instance();
$config['protocol'] = "smtp";
$config['smtp_host'] = "smtp.gmail.com";
$config['smtp_port'] = "465";
$config['smtp_user'] = "agostand@gmail.com";
$config['smtp_pass'] = "sasuke22010";
$config['charset'] = "utf-8";
$config['mailtype'] = "html";
$config['newline'] = "\r\n";
$ci->email->initialize($config);
$ci->email->from('agostandq@gmail.com', 'hasan');
$list = array('xxx@xxxx.com');
$ci->email->to($list);
$ci->email->subject('judul email');
$ci->email->message('isi email');
if ($this->email->send()) {
echo 'Email sent.';
} else {
show_error($this->email->print_debugger());
}}
	public function index()
	{
		if ($this->session->userdata('level') == "") {
            redirect('app/login');
        } 
		$data = array(
			'konten' => 'home',
            'judul' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
	}

	public function history()
	{
		if ($this->session->userdata('id_user') == "") {
            redirect('app/login');
        } 
		$data = array(
			'konten' => 'history',
            'judul' => 'History Diagnosa',
		);
		$this->load->view('v_index', $data);
	}

	public function registrasi()
	{

		$this->load->view('reg_user');
	}

	public function login()
	{

		if ($this->input->post() == NULL) {
			$this->load->view('login');
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$cek_user = $this->db->query("SELECT * FROM users WHERE username='$username' and password='$password' ");
			$cek_supplier = $this->db->query("SELECT * FROM supplier WHERE username='$username' and password='$password'");
			if ($cek_user->num_rows() == 1) {
				foreach ($cek_user->result() as $row) {
					$sess_data['id_user'] = $row->id_user;
					$sess_data['nama'] = $row->nama_user;
					$sess_data['username'] = $row->username;
					$sess_data['level'] = $row->level;
					$this->session->set_userdata($sess_data);
				}
				redirect('app');
			}elseif ($cek_supplier->num_rows() == 1) {
				foreach ($cek_supplier->result() as $row) {
					$sess_data['id_user'] = $row->kode_supplier;
					$sess_data['nama'] = $row->nama_supplier;
					$sess_data['username'] = $row->username;
					$sess_data['level'] = 'supplier';
					$this->session->set_userdata($sess_data);
				}
				redirect('app');
			} else {
				?>
				<script type="text/javascript">
					alert('Username dan password kamu salah !');
					window.location="<?php echo base_url('app/login'); ?>";
				</script>
				<?php
			}

		}
	}

	function logout()
	{
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('level');
		session_destroy();
		redirect('app/login');
	}

	public function simpan_reg()
	{
		$nama = $this->input->post('nama');
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$data = array(
			'nama' => $nama,
			'username' => $username,
			'password' => $password,
			'level' => 'user',
		);

		$this->db->insert('user', $data);
		?>
		<script type="text/javascript">
			alert('Pendaftaran Berhasil, Silahkan Login');
			window.location = '<?php echo base_url('app/login'); ?>'
		</script>
		<?php
	}

	public function cek_barang()
	{
        $kode_barang = $this->input->post('kode_barang');
        $cek = $this->db->query("SELECT * FROM barang WHERE kode_barang='$kode_barang'")->row();
		$data = array(
			'stok' => $cek->stok,
			'harga' => $cek->harga,
			'kode_barang' => $cek->kode_barang,
			'nama_barang' => $cek->nama_barang,
		);
		echo json_encode($data);
	}

	public function tambah_penjualan()
	{
		$this->load->model('No_urut');
		$kode_barang = $this->input->post('kode_barang');
		$cek = $this->db->query("SELECT * FROM barang WHERE kode_barang='$kode_barang'")->row();
		
		
		$this->form_validation->set_rules('kode_barang','kode_barang', 'trim|required');
		$data = array(
			'konten' => 'form_penjualan',
			'judul' => 'Tambah PO',
			'kodeurut' => $this->No_urut->buat_kode_penjualan(),'kode_barang' => $cek->kode_barang,
		);
		

		if ($this->form_validation->run()==false) {
			$this->load->view('v_index',$data);
		}
		else {
			$data = array(
			'konten' => 'penjualan',
			'judul' => 'Purchase Order',
		);
		$this->load->view('v_index',$data);
	}
		}
		
	public function export_excel($kode_penjualan){
        // $date = date("Y-m-d");
        // $data = array('title' => 'Laporan-Barang-'.$date, 'barang' => $this->Barang_model->get_all2());
        // $this->load->view('barang/export_excel', $data);
         $data = array(
			// $rs = $data->row();
// 			SELECT
//  po.kode_po, po.tgl_po, po.total_harga ,
//  barang.nama_barang , barang.harga,
//  detail_po.qty
// FROM po
//   INNER JOIN detail_po
//     ON po.kode_po = detail_po.kode_po
    
//     INNER JOIN barang
//     on detail_po.kode_barang=barang.kode_barang    
    
//     where detail_po.kode_po='PO00028'
			
			'data' => $this->db->query("SELECT
 po.kode_po, po.tgl_po, po.total_harga ,
 barang.nama_barang ,barang.kode_barang, barang.harga,
 detail_po.qty
FROM po
  INNER JOIN detail_po
    ON po.kode_po = detail_po.kode_po
    
    INNER JOIN barang
    on detail_po.kode_barang=barang.kode_barang    
    
     where detail_po.kode_po = '$kode_penjualan'"),
			 
			'barang'=> $this->Barang_model->can(),
			$this->db->where('kode_po', $kode_penjualan),
		); 
      

        $this->load->view('app/export_excel', $data);
    }

  //      $data = array(
		// 	// $rs = $data->row();
		// 	'data' => $this->db->query("SELECT * FROM po where kode_po='$kode_penjualan'"),
		// ); 
  //       $data['barang'] = $this->Barang_model->con();

  //       $this->load->view('app/export_excel', $data);
    // }

	

	public function hapus_penjualan($kode_penjualan)
	{
		
        $this->db->where('kode_po', $kode_penjualan);
		$this->db->delete('po');
		$this->db->where('kode_po', $kode_penjualan);
		$this->db->delete('detail_po');
		?>
		<script type="text/javascript">
			alert('Berhapus Hapus Data');
			window.location='<?php echo base_url('app/penjualan') ?>';
		</script>
		<?php
	}

// public function cetak()
// {
// 	$this->load->view('barcode_view');
// }
// function bikin_barcode($kode)
// {
// //kita load library nya ini membaca file Zend.php yang berisi loader
// //untuk file yang ada pada folder Zend
// $this->load->library('zend');
 
// //load yang ada di folder Zend
// $this->zend->load('Zend/Barcode');
 
// //generate barcodenya
// //$kode = 12345abc;
// Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
// }




	public function cetak_penjualan($kode_penjualan)
	{
		
 
$this->load->library('zend');
 
//load yang ada di folder Zend
// $this->zend->load('Zend/Barcode');
// Zend_Barcode::render('code128', 'svg', array('text'=>$kode_penjualan), array());
        $data = array(
			'data' => $this->db->query("SELECT * FROM po where kode_po='$kode_penjualan'"),
		);
		$this->load->view('cetak_penjualan',$data);
		
		
	}

	public function detail_penjualan($kode_penjualan)
	{
		
		$data = array(
			'konten' => 'detail_penjualan',
			'judul' => 'Detail po',
			'data' => $this->db->query("SELECT * FROM po where kode_po='$kode_penjualan'"),
		);
		$this->load->view('v_index',$data);
	}


	public function simpan_penjualan()
	{
        $kode_penjualan = $this->input->post('kode_penjualan');
        $total_harga = $this->input->post('total_harga');
        $tgl_penjualan = $this->input->post('tgl_penjualan');
        // $pelanggan = $this->input->post('pelanggan');

        foreach ($this->cart->contents() as $items) {
        	$kode_barang = $items['id'];
        	$qty = $items['qty'];
        	$d = array(
        		'kode_po' => $kode_penjualan,
        		'kode_barang' => $kode_barang,
        		'qty' => $qty,
        	);
        	$this->db->insert('detail_po', $d);
        	//$this->db->query("UPDATE menu SET satuan=satuan-'$qty' WHERE kode_menu='$kode_barang'");
        }

        $data = array(
        	//'nama_pelanggan' => $pelanggan,
            'kode_po'=> $kode_penjualan,
            'total_harga'=> $total_harga,
            'tgl_po'=> $tgl_penjualan,
        );
        $this->db->insert('po', $data);
        $this->cart->destroy();
        redirect('app/penjualan');
	}
  public function export_pdf(){
        
        $data['transaksi'] = $this->Supplier_model->get_transaksi2();

        $this->load->view('app/export_pdf', $data);
    }

	public function simpan_cart()
	{
		
        $data = array(
            'id'    => $this->input->post('kode_barang'),
            'qty'   => $this->input->post('jumlah'),
            'price' => $this->input->post('harga'),
            'name'  => $this->input->post('nabar'),
        );
        $this->cart->insert($data);
        redirect('app/tambah_penjualan');
	}

	public function hapus_cart($id)
	{
		
        $data = array(
            'rowid'    => $id,
            'qty'   => 0,
        );
        $this->cart->update($data);
        redirect('app/tambah_penjualan');
	}
	

	public function penjualan()
	{
		$data = array(
			'konten' => 'penjualan',
			'judul' => 'Purchase Order',
		);
		$this->load->view('v_index',$data);
	}

	public function pemesanan_supplier()
	{
		$data = array(
			'konten' => 'pesanan_supplier',
			'judul' => 'Data Pemesanan Barang ke Supplier',
		);
		$this->load->view('v_index',$data);
	}


}
