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
        $result['total'] = $this->db->get('')->num_rows();

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

}