<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Supplier_model');
        $this->load->library('form_validation');
        $this->load->library('Pdf');
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

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'supplier/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'supplier/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'supplier/index.html';
            $config['first_url'] = base_url() . 'supplier/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Supplier_model->total_rows($q);
        $supplier = $this->Supplier_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'supplier_data' => $supplier,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'konten' => 'supplier/supplier_list',
            'judul' => 'Data Supplier',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Supplier_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_supplier' => $row->id_supplier,
		'kode_supplier' => $row->kode_supplier,
		'nama_supplier' => $row->nama_supplier,
	    );
            $this->load->view('supplier/supplier_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('supplier'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('supplier/create_action'),
	    'id_supplier' => set_value('id_supplier'),
	    'kode_supplier' => set_value('kode_supplier'),
        'nama_supplier' => set_value('nama_supplier'),
        'alamat' => set_value('alamat'),
        'no_telp' => set_value('no_telp'),
        'username' => set_value('username'),
	    'password' => set_value('password'),
        'konten' => 'supplier/supplier_form',
            'judul' => 'Data Supplier',
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode_supplier' => $this->input->post('kode_supplier',TRUE),
        'nama_supplier' => $this->input->post('nama_supplier',TRUE),
        'alamat' => $this->input->post('alamat',TRUE),
        'no_telp' => $this->input->post('no_telp',TRUE),
        'username' => $this->input->post('username',TRUE),
		'password' => $this->input->post('password',TRUE),
	    );

            $this->Supplier_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('supplier'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Supplier_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('supplier/update_action'),
		'id_supplier' => set_value('id_supplier', $row->id_supplier),
		'kode_supplier' => set_value('kode_supplier', $row->kode_supplier),
        'nama_supplier' => set_value('nama_supplier', $row->nama_supplier),
        'username' => set_value('username', $row->username),
		'password' => set_value('password', $row->password),
        'konten' => 'supplier/supplier_form',
            'judul' => 'Data Supplier',
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('supplier'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_supplier', TRUE));
        } else {
            $data = array(
		'kode_supplier' => $this->input->post('kode_supplier',TRUE),
        'nama_supplier' => $this->input->post('nama_supplier',TRUE),
        'username' => $this->input->post('username',TRUE),
        'no_telp' => $this->input->post('no_telp',TRUE),
        'alamat' => $this->input->post('alamat',TRUE),
		'password' => $this->input->post('password',TRUE),
	    );

            $this->Supplier_model->update($this->input->post('id_supplier', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('supplier'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Supplier_model->get_by_id($id);

        if ($row) {
            $this->Supplier_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('supplier'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('supplier'));
        }
    }
    public function export_excel_faktur($kode_faktur)
    {
         $data = array(
            'data' => $this->db->query(" SELECT faktur.id_faktur,faktur.kode_faktur, faktur.tgl_faktur, faktur.total_harga,
detail_faktur.kode_faktur, detail_faktur.kode_barang, detail_faktur.qty,
barang.kode_barang, barang.nama_barang, barang.harga FROM faktur
  INNER JOIN detail_faktur
    ON faktur.kode_faktur = detail_faktur.kode_faktur
    
    INNER JOIN barang
    on detail_faktur.kode_barang=barang.kode_barang
     where detail_faktur.kode_faktur ='$kode_faktur'"),

             
            'faktur'=> $this->Supplier_model->can(),
            $this->db->where('kode_faktur', $kode_faktur),
        ); 
      

        $this->load->view('supplier/export_faktur_faktur', $data);
    }
    
   public function supplier_excel(){
        // $date = date("Y-m-d");
        // $data = array('title' => 'Laporan-Barang-'.$date, 'barang' => $this->Barang_model->get_all2());
        // $this->load->view('barang/export_excel', $data); 
        $data['supplier'] = $this->Supplier_model->supplier2();

        $this->load->view('supplier/supplier_excel', $data);
    }
       

    public function pdf()
    {
        $data['supplier'] = $this->Supplier_model->get_all2();

        $this->load->view('supplier/supplier_pdf', $data);
    }

public function export_pdf_faktur()
{
     $data['transaksi'] = $this->Supplier_model->get_transaksi3();

        $this->load->view('supplier/export_pdf_faktur', $data);
}


    public function export_pdf(){
        
        $data['transaksi'] = $this->Supplier_model->get_transaksi2();

        $this->load->view('supplier/export_pdf', $data);
    }
    public function tambah_faktur()
    {
        $this->load->model('Supplier_model');

        $data = array(
            'konten' => 'form_faktur',
            'judul' => 'Tambah Transaksi',
            'kodeurut' => $this->Supplier_model->buat_kode_penjualan(),
        );
        $this->load->view('supplier',$data);
    }
    public function tambah_penjualan()
    {
        $this->load->model('Supplier_model');

        $data = array(
            'konten' => 'form_faktur',
            'judul' => 'Tambah Transaksi',
            'kodeurut' => $this->Supplier_model->buat_kode_penjualan(),
        );
        $this->load->view('supplier',$data);
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
        redirect('supplier/tambah_penjualan');
    }

    public function hapus_cart($id)
    {
        
        $data = array(
            'rowid'    => $id,
            'qty'   => 0,
        );
        $this->cart->update($data);
        redirect('supplier/tambah_penjualan');
    }
public function simpan_penjualan()
    {
        $kode_faktur = $this->input->post('kode_faktur');
        $total_harga = $this->input->post('total_harga');
        $tgl_penjualan = $this->input->post('tgl_penjualan');
        // $pelanggan = $this->input->post('pelanggan');

        foreach ($this->cart->contents() as $items) {
            $kode_barang = $items['id'];
            $qty = $items['qty'];
            $d = array(
                'kode_faktur' => $kode_faktur,
                'kode_barang' => $kode_barang,
                'qty' => $qty,
            );
            $this->db->insert('detail_faktur', $d);
            //$this->db->query("UPDATE menu SET satuan=satuan-'$qty' WHERE kode_menu='$kode_barang'");
        
         }

        $data = array(
            //'nama_pelanggan' => $pelanggan,
            'kode_faktur'=> $kode_faktur,
            'total_harga'=> $total_harga,
            'tgl_faktur'=> $tgl_penjualan,
        );
        $this->db->insert('faktur', $data);
        $this->cart->destroy();
        redirect('supplier/penjualan');
    }
    public function penjualan()
    {
        $data = array(
            'konten' => 'detail_penjualan_supplier',
            'judul' => 'Riwayat Kirim Barang ',
        );
        $this->load->view('supplier',$data);
    }

    public function detail_penjualan_faktur($kode_faktur)
    {
        
        $data = array(
            'konten' => 'detail_penjualan_faktur',
            'judul' => 'Faktur',
            'data' => $this->db->query("SELECT * FROM faktur where kode_faktur='$kode_faktur'"),
        );
        $this->load->view('supplier',$data);
    }
    public function hapus_penjualan_faktur($kode_faktur)
    {
        
        $this->db->where('kode_faktur', $kode_faktur);
        $this->db->delete('faktur');
        $this->db->where('kode_faktur', $kode_faktur);
        $this->db->delete('detail_faktur');
        ?>
        <script type="text/javascript">
            alert('Berhapus Hapus Data Faktur');
            window.location='<?php echo base_url('supplier/tambah_faktur') ?>';
        </script>
        <?php
    }
    public function cetak_penjualan_faktur($kode_faktur)
    {
        
        $data = array(
            'data' => $this->db->query("SELECT * FROM faktur where kode_faktur='$kode_faktur'"),
        );
        $this->load->view('cetak_penjualan_faktur',$data);
    }


    public function _rules() 
    {
	$this->form_validation->set_rules('kode_supplier', 'kode supplier', 'trim|required');
    $this->form_validation->set_rules('nama_supplier', 'nama supplier', 'trim|required');
    $this->form_validation->set_rules(' alamat', 'alamat supplier', 'trim|required');
    $this->form_validation->set_rules('no_telp', 'no_telp supplier', 'trim|required');
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
	$this->form_validation->set_rules('password', 'Password', 'trim|required');

	$this->form_validation->set_rules('id_supplier', 'id_supplier', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
