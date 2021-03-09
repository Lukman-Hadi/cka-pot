<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Backend_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getIsMain(){
        $this->db->where('is_aktif',1);
        $query=$this->db->get('tbl_menus')->result();
        return $query;
    }
    function getMenus()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tbl_menus._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();

        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('tbl_menus.title',$search,'both');
            $this->db->group_end();
        }
        $result['total'] = $this->db->get('tbl_menus')->num_rows();

        //
         if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('tbl_menus.title',$search,'both');
            $this->db->group_end();
        }
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get('tbl_menus');    

        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;
    }

    function getUsers()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tbl_user._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();
        $this->db->select('tbl_user.*,tbl_posisi.posisi');
        $this->db->from('tbl_user');
        $this->db->join('tbl_posisi','tbl_user.posisi=tbl_posisi._id');
        $result['total'] = $this->db->get()->num_rows();
        $this->db->select('tbl_user.*,tbl_posisi.posisi');
        $this->db->from('tbl_user');
        $this->db->join('tbl_posisi','tbl_user.posisi=tbl_posisi._id');
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get();
        $item = $query->result_array();  
        $result = array_merge($result, ['rows' => $item]);
        return $result;
    }

    function getIsLevel(){
        $query=$this->db->get('tbl_posisi')->result();
        return $query;
    }

    function getPosisi()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tbl_posisi._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();

        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('tbl_posisi.posisi',$search,'both');
            $this->db->group_end();
        }
        $result['total'] = $this->db->get('tbl_posisi')->num_rows();

        //
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('tbl_posisi.posisi',$search,'both');
            $this->db->group_end();
        }
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get('tbl_posisi');    

        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;
    }

    function getBarang(){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tbl_barang._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();

        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('tbl_barang.nama_barang',$search,'both');
            $this->db->group_end();
        }
        $result['total'] = $this->db->get('tbl_barang')->num_rows();

        //
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('tbl_barang.nama_barang',$search,'both');
            $this->db->group_end();
        }
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get('tbl_barang');    

        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;
    }

    function isBarang(){
        return $this->db->get('tbl_barang');
    }

    function getBarangById($id){
        $this->db->select('*');
        $this->db->from('tbl_barang');
        $this->db->where('_id',$id);
        return $this->db->get();
    }

    function getBarangMasuk(){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tbl_barang_masuk._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();

        $this->db->select('tbl_barang_masuk.*,tbl_barang.nama_barang');
        $this->db->from('tbl_barang_masuk');
        $this->db->join('tbl_barang','tbl_barang_masuk.id_barang=tbl_barang._id');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('tbl_barang.nama_barang',$search,'both');
            $this->db->group_end();
        }
        $result['total'] = $this->db->get()->num_rows();

        $this->db->select('tbl_barang_masuk.*,tbl_barang.nama_barang');
        $this->db->from('tbl_barang_masuk');
        $this->db->join('tbl_barang','tbl_barang_masuk.id_barang=tbl_barang._id');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('tbl_barang.nama_barang',$search,'both');
            $this->db->group_end();
        }
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get();    

        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;
    }
    function getPenjualanKredit(){
        $this->db->select('*');
        $this->db->from('tbl_penjualan');
        $this->db->where('status_approve','1');
        $this->db->where_not_in('status_penjualan', array(0,11));
        return $this->db->get();
    }
    function getPenjualan($month){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'p._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();

        $this->db->select('p.*,u.nama, us.nama as penagih, b.nama_barang,(SELECT MONTH(created_at) from tbl_penagihan WHERE no_faktur = p.no_faktur ORDER BY _id DESC LIMIT 1) as bayar');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u._id = p.id_user');
        $this->db->join('tbl_user us','us._id = p.id_penagih');
        $this->db->join('tbl_barang b','b._id = p.id_barang');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->or_like('p.alamat',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('p.tgl_tempo',$search,'both');
            $this->db->or_like('p.no_faktur',$search,'both');
            $this->db->group_end();
        }
        $result['total'] = $this->db->get('')->num_rows();
        $this->db->select('p.*,u.nama, us.nama as penagih, b.nama_barang,(SELECT MONTH(created_at) from tbl_penagihan WHERE no_faktur = p.no_faktur ORDER BY _id DESC LIMIT 1) as bayar');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u._id = p.id_user');
        $this->db->join('tbl_user us','us._id = p.id_penagih');
        $this->db->join('tbl_barang b','b._id = p.id_barang');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->or_like('p.alamat',$search,'both');
            $this->db->or_like('p.tgl_tempo',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('p.no_faktur',$search,'both');
            $this->db->group_end();
        }
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get();    

        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;

    }
    function getPenjualanApprove(){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'p._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();

        $this->db->select('p.*,u.nama, b.nama_barang');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u._id = p.id_user');
        $this->db->join('tbl_barang b','b._id = p.id_barang');
        $this->db->where('status_approve','0');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->or_like('p.alamat',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('p.tgl_tempo',$search,'both');
            $this->db->or_like('p.no_faktur',$search,'both');
            $this->db->group_end();
        }
        $result['total'] = $this->db->get('')->num_rows();
        $this->db->select('p.*,u.nama, b.nama_barang');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u._id = p.id_user');
        $this->db->join('tbl_barang b','b._id = p.id_barang');
        $this->db->where('status_approve','0');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->or_like('p.alamat',$search,'both');
            $this->db->or_like('p.tgl_tempo',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('p.no_faktur',$search,'both');
            $this->db->group_end();
        }
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get();    

        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;

    }
    function getPenjualanById($id){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'p._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();
        $this->db->select('p.*,u.nama, b.nama_barang');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u._id = p.id_user');
        $this->db->join('tbl_barang b','b._id = p.id_barang');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->group_end();
        }
        $this->db->where('p.id_user',$id);
        $result['total'] = $this->db->get('')->num_rows();
        $this->db->select('p.*,u.nama, b.nama_barang');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u._id = p.id_user');
        $this->db->join('tbl_barang b','b._id = p.id_barang');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->group_end();
        }
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $this->db->where('p._id',$id);
        $query=$this->db->get();    

        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;
    }

    function getDetailPenjualan($id){
        $this->db->select('j.*, b.nama_barang');
        $this->db->from('tbl_penjualan j');
        $this->db->join('tbl_barang b','b._id = j.id_barang');
        $this->db->where('j._id',$id);
        return $this->db->get();
    }

    function getDetailPenagihan($noFaktur){
        $this->db->select('*');
        $this->db->from('tbl_penagihan');
        $this->db->where('no_faktur',$noFaktur);
        return $this->db->get();
    }
    
    function getPenagihan(){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'p._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();

        $this->db->select('p.*,u.nama, j.no_faktur, j.alamat, j.nama_pembeli, j.tgl_tempo');
        $this->db->from('tbl_penagihan p');
        $this->db->join('tbl_penjualan j','j.no_faktur = p.no_faktur');
        $this->db->join('tbl_user u','u._id = p.id_user');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.no_faktur',$search,'both');
            $this->db->or_like('j.alamat',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('j.nama_pembeli',$search,'both');
            $this->db->group_end();
        }
        $result['total'] = $this->db->get('')->num_rows();
        $this->db->select('p.*,u.nama, j.no_faktur, j.alamat, j.nama_pembeli, j.tgl_tempo');
        $this->db->from('tbl_penagihan p');
        $this->db->join('tbl_penjualan j','j.no_faktur = p.no_faktur');
        $this->db->join('tbl_user u','u._id = p.id_user');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.no_faktur',$search,'both');
            $this->db->or_like('j.alamat',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('j.nama_pembeli',$search,'both');
            $this->db->group_end();
        }
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get();    
        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;
    }
    function getApprovePenagihan(){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'p._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();

        $this->db->select('p.*,u.nama, j.no_faktur, j.alamat, j.nama_pembeli, j.tgl_tempo');
        $this->db->from('tbl_penagihan p');
        $this->db->join('tbl_penjualan j','j.no_faktur = p.no_faktur');
        $this->db->join('tbl_user u','u._id = p.id_user');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.no_faktur',$search,'both');
            $this->db->or_like('j.alamat',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('j.nama_pembeli',$search,'both');
            $this->db->group_end();
        }
        $this->db->where('status','0');
        $result['total'] = $this->db->get('')->num_rows();
        $this->db->select('p.*,u.nama, j.no_faktur, j.alamat, j.nama_pembeli, j.tgl_tempo');
        $this->db->from('tbl_penagihan p');
        $this->db->join('tbl_penjualan j','j.no_faktur = p.no_faktur');
        $this->db->join('tbl_user u','u._id = p.id_user');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.no_faktur',$search,'both');
            $this->db->or_like('j.alamat',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('j.nama_pembeli',$search,'both');
            $this->db->group_end();
        }
        $this->db->where('status','0');
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get();    
        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;
    }
    function getTotalBayar($kode){
        $this->db->select('*');
        $this->db->from('tbl_penagihan');
        $this->db->where('no_faktur',$kode);
        return $this->db->get();
    }
    function getPenagihanById($id){

    }
    function getIsPenagih(){
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('posisi',6);
        $this->db->where('is_aktif',"1");
        return $this->db->get()->result();
    }
    function getFakturTagihan($month){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'p._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();

        $this->db->select('p.*,u.nama, us.nama as penagih,(SELECT MONTH(created_at) from tbl_penagihan WHERE no_faktur = p.no_faktur ORDER BY _id DESC LIMIT 1) as bayar');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u._id = p.id_user');
        $this->db->join('tbl_user us','us._id = p.id_penagih');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->or_like('p.alamat',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('p.tgl_tempo',$search,'both');
            $this->db->or_like('p.no_faktur',$search,'both');
            $this->db->group_end();
        }
        $this->db->where('p.status_bayar','1');
        $result['total'] = $this->db->get('')->num_rows();
        $this->db->select('p.*,u.nama, us.nama as penagih,(SELECT MONTH(created_at) from tbl_penagihan WHERE no_faktur = p.no_faktur ORDER BY _id DESC LIMIT 1) as bayar');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u._id = p.id_user');
        $this->db->join('tbl_user us','us._id = p.id_penagih');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->or_like('p.alamat',$search,'both');
            $this->db->or_like('p.tgl_tempo',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('p.no_faktur',$search,'both');
            $this->db->group_end();
        }
        $this->db->where('p.status_bayar','1');
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get();    

        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;

    }
    function getFakturTagihanById($month,$id){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'p._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();

        $this->db->select('p.*,u.nama, us.nama as penagih,(SELECT MONTH(created_at) from tbl_penagihan WHERE no_faktur = p.no_faktur ORDER BY _id DESC LIMIT 1) as bayar');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u._id = p.id_user');
        $this->db->join('tbl_user us','us._id = p.id_penagih');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->or_like('p.alamat',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('p.tgl_tempo',$search,'both');
            $this->db->or_like('p.no_faktur',$search,'both');
            $this->db->group_end();
        }
        $this->db->where('p.status_bayar','1');
        $this->db->where('p.id_penagih',$id);
        $result['total'] = $this->db->get('')->num_rows();
        $this->db->select('p.*,u.nama, us.nama as penagih,(SELECT MONTH(created_at) from tbl_penagihan WHERE no_faktur = p.no_faktur ORDER BY _id DESC LIMIT 1) as bayar');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u._id = p.id_user');
        $this->db->join('tbl_user us','us._id = p.id_penagih');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->or_like('p.alamat',$search,'both');
            $this->db->or_like('p.tgl_tempo',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('p.no_faktur',$search,'both');
            $this->db->group_end();
        }
        $this->db->where('p.status_bayar','1');
        $this->db->where('p.id_penagih',$id);
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get();    

        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;

    }
}