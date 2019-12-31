<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier_model extends CI_Model
{

    public $table = 'supplier';
    public $id = 'id_supplier';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    public function supplier2($where = ""){
        $supplier = $this->db->query("select * from supplier ".$where);
        return $supplier;
    }




     public function get_all2()
    {
       
         $this->db->select('*');
        $this->db->from('supplier');
          $query = $this->db->get();
           return $query->result();
    
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_supplier', $q);
	$this->db->or_like('kode_supplier', $q);
    $this->db->or_like('nama_supplier', $q);
    $this->db->or_like('alamat', $q);
    $this->db->or_like('no_telp', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_supplier', $q);
	$this->db->or_like('kode_supplier', $q);
	$this->db->or_like('nama_supplier', $q);

    $this->db->or_like('alamat', $q);
    $this->db->or_like('no_telp', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }


    function get_transaksi2()

    {
     // $query = $this->db->get('transaksi');  
     // return $this->db->get('transaksi')->result();
   $this->db->select('*');
   $this->db->from('po');
   $this->db->join('detail_po', 'detail_po.kode_po = po.kode_po');
          $query = $this->db->get();
           return $query->result();
    }
    function get_transaksi3()

    {
     // $query = $this->db->get('transaksi');  
     // return $this->db->get('transaksi')->result();
   $this->db->select('*');
   $this->db->from('faktur');
   $this->db->join('detail_faktur', 'detail_faktur.kode_faktur = faktur.kode_faktur');
          $query = $this->db->get();
           return $query->result();
    }
public function can($kode_faktur=""){
                
        $faktur = $this->db->query("SELECT faktur.id_faktur,faktur.kode_faktur, faktur.tgl_faktur, faktur.total_harga,
detail_faktur.kode_faktur, detail_faktur.kode_barang, detail_faktur.qty,
barang.kode_barang, barang.nama_barang, barang.harga
 FROM faktur
  INNER JOIN detail_faktur
    ON faktur.kode_faktur = detail_faktur.kode_faktur
    
    INNER JOIN barang
    on detail_faktur.kode_barang=barang.kode_barang
     where detail_faktur.kode_faktur ".$kode_faktur);
        return $faktur;
        
    }
    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
    function buat_kode_penjualan()   {    
      $this->db->select('RIGHT(faktur.id_faktur,5) as kode', FALSE);
      $this->db->order_by('id_faktur','DESC');    
      $this->db->limit(1);     
      $query = $this->db->get('faktur');      //cek dulu apakah ada sudah ada kode di tabel.    
      if($query->num_rows() <> 0){       
       //jika kode ternyata sudah ada.      
       $data = $query->row();      
       $kode = intval($data->kode) + 1;     
      }
      else{       
       //jika kode belum ada      
       $kode = 1;     
      }
      $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT);    
      $kodejadi = "FR".$kodemax;     
      return $kodejadi;  
     }
     function buat_kode_santri()   {    
      $this->db->select('RIGHT(santri.id_santri,5) as kode', FALSE);
      $this->db->order_by('id_santri','DESC');    
      $this->db->limit(1);     
      $query = $this->db->get('santri');      //cek dulu apakah ada sudah ada kode di tabel.    
      if($query->num_rows() <> 0){       
       //jika kode ternyata sudah ada.      
       $data = $query->row();      
       $kode = intval($data->kode) + 1;     
      }
      else{       
       //jika kode belum ada      
       $kode = 1;     
      }
      $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT);    
      $kodejadi = "SN".$kodemax;     
      return $kodejadi;  
     }
     function buat_kode_barang()   {    
      $this->db->select('RIGHT(barang.id_barang,4) as kode', FALSE);
      $this->db->order_by('id_barang','DESC');    
      $this->db->limit(1);     
      $query = $this->db->get('barang');      //cek dulu apakah ada sudah ada kode di tabel.    
      if($query->num_rows() <> 0){       
       //jika kode ternyata sudah ada.      
       $data = $query->row();      
       $kode = intval($data->kode) + 1;     
      }
      else{       
       //jika kode belum ada      
       $kode = 1;     
      }
      $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);    
      $kodejadi = "BRG".$kodemax;     
      return $kodejadi;  
     }

}

/* End of file Supplier_model.php */
/* Location: ./application/models/Supplier_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-05-05 16:20:26 */
/* http://harviacode.com */