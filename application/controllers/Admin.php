<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model','login_model');
        $this->load->model('Backend_model','backend_model');
        $this->load->model('Global_model','global_model');
    }

	function index(){
		$data['title']  = 'Cka Pot';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/js/menu.js';
        $data['content'] = 'test';
		$this->template->load('template','dashboard',$data);
    }
    
    function login(){
        $query = $this->login_model->getLogin()->row_array();
        $this->session->set_userdata($query);
        $this->load->view('auth/login');
    }

	function isLevel(){
		$this->output->set_content_type('application/json');
		$level = $this->backend_model->getIsLevel();
		echo json_encode($level);
	}
	//modul user
	//list pegawai//
	function users(){
		$data['title']  = 'Data Pegawai';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
		$data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
		$this->template->load('template','master/users',$data);
	}
	function saveUsers(){
		$nik       		= $this->input->post('nik', TRUE);
        $password       = $this->input->post('password',TRUE);
        $options        = array("cost"=>4);
        $hashPassword	= password_hash($password,PASSWORD_BCRYPT,$options);
        $nama           = $this->input->post('nama', TRUE);
        $jk      		= $this->input->post('jk', TRUE);
        $tempat         = $this->input->post('tempat_lahir', TRUE);
        $tgl_l      	= $this->input->post('tgl_lahir', TRUE);
        $tgl_g			= $this->input->post('tgl_masuk', TRUE);
        $posisi   		= $this->input->post('posisi', TRUE);
        $alamat       	= $this->input->post('alamat', TRUE);
		$data = array(
			'nik'			=> $nik,
			'password'		=> $hashPassword,
			'nama'			=> $nama,
			'jk'			=> $jk,
			'tempat_lahir'	=> $tempat,
			'posisi'		=> $posisi,
			'alamat'		=> $alamat,
			'tgl_lahir'		=> $tgl_l,
			'tgl_masuk'		=> $tgl_g,
		);
        $result = $this->global_model->insert('tbl_user',$data);
        if ($result){
            echo json_encode(array('message'=>'Save Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
	}
	function getUsers(){
		$this->output->set_content_type('application/json');
		$users = $this->backend_model->getUsers();
		echo json_encode($users);
	}
	function aktifUsers(){
        $id = $this->input->post('id');
		$rows = $this->db->get_where('tbl_user', array('_id'=>$id))->row_array();
        if ($rows['is_aktif'] == 0){
            $aktif = "1";
        }else{
            $aktif = "0";
        }
        $result = $this->global_model->update('tbl_user',array('is_aktif'=>$aktif), array('_id'=>$id));
        if ($result){
            echo json_encode(array('message'=> 'User '.$rows['nama'].' Aktif or Non Aktif Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
	}
	function updateUsers(){
        $nik       		= $this->input->post('nik', TRUE);
        $password       = $this->input->post('password',TRUE);
        $options        = array("cost"=>4);
        $hashPassword	= password_hash($password,PASSWORD_BCRYPT,$options);
        $nama           = $this->input->post('nama', TRUE);
        $jk      		= $this->input->post('jk', TRUE);
        $tempat         = $this->input->post('tempat_lahir', TRUE);
        $tgl_l      	= $this->input->post('tgl_lahir', TRUE);
        $tgl_g			= $this->input->post('tgl_masuk', TRUE);
        $posisi   		= $this->input->post('posisi', TRUE);
		$alamat       	= $this->input->post('alamat', TRUE);
		if($password == ''){
			$data = array(
				'nik'			=> $nik,
				'nama'			=> $nama,
				'jk'			=> $jk,
				'tempat_lahir'	=> $tempat,
				'posisi'		=> $posisi,
				'alamat'		=> $alamat,
				'tgl_lahir'		=> $tgl_l,
				'tgl_masuk'		=> $tgl_g,
			);
		}else{
			$data = array(
				'nik'			=> $nik,
				'password'		=> $hashPassword,
				'nama'			=> $nama,
				'jk'			=> $jk,
				'tempat_lahir'	=> $tempat,
				'posisi'		=> $posisi,
				'alamat'		=> $alamat,
				'tgl_lahir'		=> $tgl_l,
				'tgl_masuk'		=> $tgl_g,
			);
		}
        $where = array('_id'=>$this->input->get('id'));
        $result = $this->global_model->update('tbl_user',$data, $where);
        if ($result){
            echo json_encode(array('message'=>'Update Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
	}
	function destroyUsers(){
        $id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_user',array('_id'=>$id));
        if ($result){
            echo json_encode(array('message'=>'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
	}
	//end list pegawai//
	
	//list posisi//
	function posisi() {
        $data['title']  = 'Data Posisi Cka';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template','master/posisi',$data);
    }
    function getPosisi(){
        $this->output->set_content_type('application/json');
        $posisi = $this->backend_model->getPosisi();
        echo json_encode($posisi);
    }
    function savePosisi(){
        $posisi = $this->input->post('posisi', TRUE);
        $data=array();
        $data = array(
                'posisi'         => $posisi
            );
        $result = $this->global_model->insert('tbl_posisi',$data);
        if ($result){
            echo json_encode(array('message'=>'Save Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    function updatePosisi(){
        $posisi = $this->input->post('posisi', TRUE);
        $data=array();
        $data = array(
                'posisi'         => $posisi
            );
        $where = array('_id'=>$this->input->get('id'));
        $result = $this->global_model->update('tbl_posisi',$data, $where);
        if ($result){
            echo json_encode(array('message'=>'Update Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }    
    function destroyPosisi(){
        $id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_posisi',array('_id'=>$id));
        if ($result){
            echo json_encode(array('message'=>'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
	}
	//end posisi//
	//end modul user//

	//modul gudang//
	//barang//
	function barang(){
		$data['title']  = 'Data Barang Cka';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template','master/barang',$data);
	}
	function getBarang(){
		$this->output->set_content_type('application/json');
		$barang = $this->backend_model->getBarang();
		echo json_encode($barang);
	}
	function saveBarang(){
		$kode = $this->input->post('kode_barang', TRUE);
		$nama = $this->input->post('nama_barang', TRUE);
		$harga = $this->input->post('harga_barang', TRUE);
		$stok = $this->input->post('stok', TRUE);
        $data=array();
        $data = array(
                'kode_barang'         => $kode,
                'nama_barang'         => $nama,
                'harga_barang'         => $harga,
                'stok'         => $stok,
        );
        $result = $this->global_model->insert('tbl_barang',$data);
        if ($result){
            echo json_encode(array('message'=>'Save Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
	}
	function updateBarang(){
		$kode = $this->input->post('kode_barang', TRUE);
		$nama = $this->input->post('nama_barang', TRUE);
		$harga = $this->input->post('harga_barang', TRUE);
		$stok = $this->input->post('stok', TRUE);
        $data=array();
        $data = array(
                'kode_barang'         => $kode,
                'nama_barang'         => $nama,
                'harga_barang'         => $harga,
                'stok'         => $stok,
        );
        $where = array('_id'=>$this->input->get('id'));
        $result = $this->global_model->update('tbl_barang',$data, $where);
        if ($result){
            echo json_encode(array('message'=>'Update Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
	}
	function destroyBarang(){
		$id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_barang',array('_id'=>$id));
        if ($result){
            echo json_encode(array('message'=>'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
	}
	//end barang//
	//barang masuk//
	function barangMasuk(){
		$data['title']  = 'Data Barang Masuk Cka';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template','master/barangMasuk',$data);
    }
    function isBarang(){
        $barang = $this->backend_model->isBarang();
        $this->output->set_content_type('application/json');
        echo json_encode($barang->result());
    }
	function saveBarangMasuk(){
        $kode = $this->input->post('kode_faktur', TRUE);
		$id = $this->input->post('kode_barang', TRUE);
		$jumlah = $this->input->post('jumlah', TRUE);
		$tgl = $this->input->post('tgl', TRUE);
        $data=array();
        $data = array(
                'kode_faktur'         => $kode,
                'id_barang'         => $id,
                'jumlah'         => $jumlah,
                'tgl_masuk'         => $tgl,
        );
        $oldData = $this->backend_model->getBarangById($id)->row()->stok;
        $dataUpdate = array();
        $stokBaru = $oldData+$jumlah;
        $dataUpdate = array(
            'stok' => $stokBaru,
        );
        $result = $this->global_model->insert('tbl_barang_masuk',$data);
        if ($result){
            $where = array('_id'=>$id);
            $update = $this->global_model->update('tbl_barang',$dataUpdate, $where);
            if($update){
                echo json_encode(array('message'=>'Save Success'));
            }else{
                echo json_encode(array('errorMsg'=>'Gagal Update'));
            }
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
	}
	function getBarangMasuk(){
		$this->output->set_content_type('application/json');
		$barang = $this->backend_model->getBarangMasuk();
		echo json_encode($barang);
	}
	function editBarangMasuk(){
	}
	function destroyBarangMasuk(){
        $id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_barang_masuk',array('_id'=>$id));
        if ($result){
            echo json_encode(array('message'=>'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    //end barang masuk//
    //end Modul Gudang//

    //Modul Transaksi//
    // penjualan //
    function penjualan(){
        $data['title']  = 'Data Penjualan Cka';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template','master/penjualan',$data);
    }
    function getPenjualan(){
        $this->output->set_content_type('application/json');
		$barang = $this->backend_model->getPenjualan();
		echo json_encode($barang);
    }
    function getDetailPenjualan(){
        $data['title']  = 'Data Penjualan Cka';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template','master/detailpenjualan',$data);
    }
    function updatePenjualan(){

    }
    function editPenjualan(){

    }
    function savePenjualan(){
        $kode = $this->input->post('kode_faktur', TRUE);
		$nama = $this->input->post('nama_pembeli', TRUE);
		$alamat = $this->input->post('alamat_pembeli', TRUE);
		$tlfn = $this->input->post('no_tlfn', TRUE);
        $id_barang = $this->input->post('id_barang', TRUE);
        $status = $this->input->post('status_penjualan', TRUE);
        // $idSales = 1; <-- harus ganti dengan session
        $idSales = 11215176;
        $tgl = $this->input->post('tgl_jual',TRUE);
        $tempo = $this->input->post('tgl_tempo');
        $barang = $this->backend_model->getBarangById($id_barang)->row();
        $total = $barang->harga_barang;
        if($status == 0){
            $tempo = 0;
        }else{
            $totalTagih = $total/$status;
            $dataPenagihan = array(
                'kode_bayar'        => $kode . '-1',
                'kode_faktur'       => $kode,
                'total_bayar'       => $totalTagih,
                'tgl_bayar'         => $tgl,
                'id_penagih'        => $idSales,
            );
            $isTagih = $this->global_model->insert('tbl_penagihan',$dataPenagihan);
            if(!$isTagih){
                echo json_encode(array('errorMsg'=>'Error Penagihan.'));
            }
            $tempo = $this->input->post('tgl_tempo');
        }
        $stokLama = $barang->stok;
        $dataStok = array();
        $stokBaru = $stokLama-1;
        $dataStok = array(
            'stok' => $stokBaru,
        );
        $where = array('_id'=>$id_barang);
        $update = $this->global_model->update('tbl_barang',$dataStok, $where);
        if(!$update){
            echo json_encode(array('errorMsg'=>'Error Update Stok.'));
        }
        $data=array();
        $data = array(
            'no_faktur'         => $kode,
            'nama_pembeli'      => $nama,
            'alamat'            => $alamat,
            'no_telp'           => $tlfn,
            'tgl_transaksi'     => $tgl,
            'kode_barang'       => $id_barang,
            'nik'               => $idSales,
            'status_penjualan'  => $status,
            'tgl_tempo'         => $tempo,
            'total'             => $total
        );
        $result = $this->global_model->insert('tbl_penjualan',$data);
        if ($result){
            echo json_encode(array('message'=>'Save Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    function isKodePenjualan(){
        $this->output->set_content_type('application/json');
        $barang = $this->backend_model->getPenjualanKredit();
		echo json_encode($barang->result());
    }
    // end penjualan
    // penagihan
    function penagihan(){
        $data['title']  = 'Data Penagihan Cka';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template','master/penagihan',$data);
    }
    function getPenagihan(){
        $this->output->set_content_type('application/json');
		$barang = $this->backend_model->getPenagihan();
		echo json_encode($barang);
    }
    function getPenagihanById(){

    }
    function destroyPenagihan(){

    }
    function editPenagihan(){

    }
    function approvePenagihan(){

    }
    //end penagihan
    //end modul transaksi

    //Modul Laporan
}
