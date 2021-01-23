<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Backend_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
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

    function getMenus(){

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
    function getPenjualan(){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'p._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $offset = ($page-1)*$rows;
        $result = array();

        $this->db->select('p.*,u.nama, b.nama_barang');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u.nik = p.nik');
        $this->db->join('tbl_barang b','b._id = p.kode_barang');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->or_like('p.alamat',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->group_end();
        }
        $result['total'] = $this->db->get('')->num_rows();
        $this->db->select('p.*,u.nama, b.nama_barang');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u.nik = p.nik');
        $this->db->join('tbl_barang b','b._id = p.kode_barang');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->or_like('p.alamat',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
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
        $this->db->join('tbl_user u','u.nik = p.nik');
        $this->db->join('tbl_barang b','b._id = p.kode_barang');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->group_end();
        }
        $this->db->where('p.nik',$id);
        $result['total'] = $this->db->get('')->num_rows();
        $this->db->select('p.*,u.nama, b.nama_barang');
        $this->db->from('tbl_penjualan p');
        $this->db->join('tbl_user u','u.nik = p.nik');
        $this->db->join('tbl_barang b','b._id = p.kode_barang');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.nama_pembeli',$search,'both');
            $this->db->group_end();
        }
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $this->db->where('p.nik',$id);
        $query=$this->db->get();    

        $item = $query->result_array();    
        $result = array_merge($result, ['rows' => $item]);
        return $result;
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
        $this->db->join('tbl_penjualan j','j.no_faktur = p.kode_faktur');
        $this->db->join('tbl_user u','u.nik = p.id_penagih');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.kode_faktur',$search,'both');
            $this->db->or_like('j.alamat',$search,'both');
            $this->db->or_like('u.nama',$search,'both');
            $this->db->or_like('j.nama_pembeli',$search,'both');
            $this->db->group_end();
        }
        $result['total'] = $this->db->get('')->num_rows();
        $this->db->select('p.*,u.nama, j.no_faktur, j.alamat, j.nama_pembeli, j.tgl_tempo');
        $this->db->from('tbl_penagihan p');
        $this->db->join('tbl_penjualan j','j.no_faktur = p.kode_faktur');
        $this->db->join('tbl_user u','u.nik = p.id_penagih');
        if(isset($_POST['search_data'])) {
            $this->db->group_start();
            $this->db->like('p.kode_faktur',$search,'both');
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
    function getPenagihanById($id){

    }
    function getDetailPenjualan(){

    }
}