<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    function getPenjualan(){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'pj._id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $search = isset($_POST['search_data']) ? strval($_POST['search_data']) : '';
        $start = isset($_POST['start']) ? strval($_POST['start']) : '';
        $end = isset($_POST['end']) ? strval($_POST['end']) : '';
        $offset = ($page-1)*$rows;
        $result = array();
        $this->db->select('pj.*, u.nama, b.nama_barang');
        $this->db->from('tbl_penjualan pj');
        $this->db->join('tbl_user u','u._id = pj.id_user');
        $this->db->join('tbl_barang b','b._id = pj.id_barang');
        $this->db->where('tgl_transaksi BETWEEN "'.$start.'" AND "'.$end.'"',null,false);
        $result['total'] = $this->db->get()->num_rows();
        $this->db->select('pj.*, u.nama, b.nama_barang');
        $this->db->from('tbl_penjualan pj');
        $this->db->join('tbl_user u','u._id = pj.id_user');
        $this->db->join('tbl_barang b','b._id = pj.id_barang');
        $this->db->where('tgl_transaksi BETWEEN "'.$start.'" AND "'.$end.'"',null,false);
        $this->db->order_by($sort,$order);
        $this->db->limit($rows,$offset);
        $query=$this->db->get();    
        $item = $query->result();    
        $result = array_merge($result, ['rows' => $item]);
        $this->db->select('SUM(total) as total');
        $this->db->from('tbl_penjualan');
        $this->db->where('tgl_transaksi BETWEEN "'.$start.'" AND "'.$end.'"',null,false);
        $footer = $this->db->get()->row();
        $result = array_merge($result,array('footer'=>array(0=>array('total'=>$footer->total,'nama'=>'jumlah'))));
        return $result;
    }
}