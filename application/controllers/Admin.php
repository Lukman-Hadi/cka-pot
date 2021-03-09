<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if(!is_login())redirect(site_url('login'));
        $this->load->model('Login_model','login_model');
        $this->load->model('Backend_model','backend_model');
        $this->load->model('Menu_model','menu_model');
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
    function logout(){
        $this->session->sess_destroy();
        $this->session->set_flashdata('status_login','Anda sudah berhasil keluar dari aplikasi');
        $this->load->view('auth/login', 'refresh');
    }

	function isLevel(){
		$this->output->set_content_type('application/json');
		$level = $this->backend_model->getIsLevel();
		echo json_encode($level);
	}
    function akses(){
        $data['css_files'][] ='';
        $data['js_files'][] ='';
        $data['level'] = $this->db->get_where('tbl_levels',array('id_posisi'=>  $this->uri->segment(3)))->row_array();
        $data['menu'] = $this->db->get_where('tbl_menus',array('is_main !='=> null))->result();
        $this->template->load('template','master/akses',$data);
    }

    function kasi_akses_ajax(){
        $id_menu        = $_GET['id_menu'];
        $id_user_level  = $_GET['level'];
        // chek data
        $params = array('id_menu'=>$id_menu,'id_posisi'=>$id_user_level);
        $akses = $this->db->get_where('tbl_levels',$params);
        if($akses->num_rows()<1){
            // insert data baru
            $this->db->insert('tbl_levels',$params);
        }else{
            $this->db->where('id_menu',$id_menu);
            $this->db->where('id_posisi',$id_user_level);
            $this->db->delete('tbl_levels');
        }
    }
    function menu(){
        $data['title']  = 'Data Menu';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
		$data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
		$this->template->load('template','master/menu',$data);
    }
    function getMenus(){
        $this->output->set_content_type('application/json');
		$users = $this->backend_model->getMenus();
		echo json_encode($users);
    }
    public function ismain()
    {
        $this->output->set_content_type('application/json');
        $ismain = $this->backend_model->getIsMain();
        echo json_encode($ismain);
    }
    function updateMenu(){
        $title = $this->input->post('title', TRUE);
        $uri = $this->input->post('uri', TRUE);
        $icon = $this->input->post('icon', TRUE);
        $is_main = $this->input->post('is_main', TRUE);
        $order = $this->input->post('order', TRUE);
        $data=array();
        $data = array(
                'title'         => $title,
                'uri'           => $uri,
                'icon'          => $icon,
                'is_main'       => $is_main,
                'ordinal'         => $order
            );
        $where = array('_id'=>$this->input->get('id'));
        $result = $this->global_model->update('tbl_menus',$data, $where);
        if ($result){
            echo json_encode(array('message'=>'Update Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    function saveMenu(){
        $title = $this->input->post('title', TRUE);
        $uri = $this->input->post('uri', TRUE);
        $icon = $this->input->post('icon', TRUE);
        $is_main = $this->input->post('is_main', TRUE);
        $order = $this->input->post('order', TRUE);
        $data=array();
        $data = array(
                'title'         => $title,
                'uri'           => $uri,
                'icon'          => $icon,
                'is_main'       => $is_main,
                'ordinal'       => $order
            );
        $result = $this->global_model->insert('tbl_menus',$data);
        if ($result){
            echo json_encode(array('message'=>'Save Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    function aktifMenu(){
        $id = $this->input->post('id');
        $rows = $this->db->get_where('tbl_menus', array('_id'=>$id))->row_array();
        if ($rows['is_aktif'] == 0){
            $aktif = 1;
        }else{
            $aktif = 0;
        }
        $result = $this->global_model->update('tbl_menus',array('is_aktif'=>$aktif), array('_id'=>$id));
        if ($result){
            echo json_encode(array('message'=> 'Menu '.$rows['title'].' Aktif or Non Aktif Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    function destroyMenu(){
        $id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_menus',array('_id'=>$id));
        if ($result){
            echo json_encode(array('message'=>'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
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
        $month = date('m');
        $this->output->set_content_type('application/json');
		$barang = $this->backend_model->getPenjualan($month);
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
        $detail = $this->backend_model->getDetailPenjualan($this->uri->segment(3))->row();
        $detailTagih = $this->backend_model->getDetailPenagihan($detail->no_faktur);
        $tunggakan=0;
        if($detail->status_penjualan != 0 ){
            $wajibBayar = $detail->total / $detail->status_penjualan;
            $awalBeli = new DateTime($detail->tgl_transaksi);
            $tgltempo = date('Y').'-'.date('m').'-'.$detail->tgl_tempo;
            $skrg = new DateTime($tgltempo);
            $interval = $awalBeli->diff($skrg)->m;
            if(substr($detail->tgl_transaksi,8,2) > $detail->tgl_tempo){
                $interval +=1;
            }
            if(date('d') < $detail->tgl_tempo ){
                $interval -=1;
            }
            $tunggakan = $wajibBayar * ($interval+1);
        }
        $data['tunggakan'] = $tunggakan;
        $data['detail'] = $detail;
        $data['detailtagih'] = $detailTagih->result();
        $this->template->load('template','master/detailpenjualan',$data);
    }
    function penjualanApprove(){
        $data['title']  = 'Data Penjualan Cka';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template','master/penjualanapprove',$data);
    }
    function getApprovePenjualan(){
        $this->output->set_content_type('application/json');
		$barang = $this->backend_model->getPenjualanApprove();
		echo json_encode($barang);
    }
    function approvePenjualan(){
        $id         = $this->input->post('id');
        $idPenagih  = $this->input->post('id_penagih');
        $rows = $this->db->get_where('tbl_penjualan', array('_id'=>$id))->row();
        $id_barang = $rows->id_barang;
        $status = $rows->status_penjualan;
        $tgl = $rows->tgl_transaksi;
        //
        $barang = $this->backend_model->getBarangById($id_barang)->row();
        $bayar = "0";
        $total = $barang->harga_barang;
        if($status == 0){
            $tempo = 0;
            $dataPenagihan = array(
                'kode_bayar'        => $rows->no_faktur . '-1',
                'no_faktur'         => $rows->no_faktur,
                'total_bayar'       => $total,
                'tgl_bayar'         => $tgl,
                'id_user'           => $rows->id_user,
                'status'            => '1',
            );
            $isTagih = $this->global_model->insert('tbl_penagihan',$dataPenagihan);
            if(!$isTagih){
                echo json_encode(array('errorMsg'=>'Error Penagihan.'));
            }
        }else{
            $totalTagih = $total/$status;
            $dataPenagihan = array(
                'kode_bayar'        => $rows->no_faktur . '-1',
                'no_faktur'       => $rows->no_faktur,
                'total_bayar'       => $totalTagih,
                'tgl_bayar'         => $tgl,
                'id_user'        => $rows->id_user,
                'status'            => '1',
            );
            $isTagih = $this->global_model->insert('tbl_penagihan',$dataPenagihan);
            if(!$isTagih){
                echo json_encode(array('errorMsg'=>'Error Penagihan.'));
            }
            $tempo = $rows->tgl_tempo;
            $bayar = "1";
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
        //
        if ($rows->status_approve == '0'){
            $approve = '1';
        }else{
            $approve = '0';
        }
        $data=array();
        $data = array(
            'status_penjualan'  => $status,
            'status_bayar'      => $bayar,
            'tgl_tempo'         => $tempo,
            'status_approve'    => $approve,
            'id_penagih'        => $idPenagih
        );
        $result = $this->global_model->update('tbl_penjualan',$data, array('_id'=>$id));
        if ($result){
            echo json_encode(array('message'=> 'Faktur '.$rows->no_faktur.' Approve Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    function updatePenjualan(){
        $id = $this->input->get('id');
        $data = array();
        $data = array(
            'nama_pembeli'      => $this->input->post('nama_pembeli'),
            'alamat'            => $this->input->post('alamat_pembeli'),
            'no_telp'           => $this->input->post('no_tlfn'),
            'tgl_transaksi'     => $this->input->post('tgl_jual'),
            'tgl_tempo'         => $this->input->post('tgl_tempo'),
        );
        $result = $this->global_model->update('tbl_penjualan',$data,array('_id'=>$id));
        if($result){
            echo json_encode(array('message'=> 'Update Success'));
        }else{
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    function savePenjualan(){
        $kode = $this->input->post('kode_faktur', TRUE);
		$nama = $this->input->post('nama_pembeli', TRUE);
		$alamat = $this->input->post('alamat_pembeli', TRUE);
		$tlfn = $this->input->post('no_tlfn', TRUE);
        $id_barang = $this->input->post('id_barang', TRUE);
        $status = $this->input->post('status_penjualan', TRUE);
        $idSales = $this->session->_id;
        $tgl = $this->input->post('tgl_jual',TRUE);
        $tempo = $this->input->post('tgl_tempo');
        $barang = $this->backend_model->getBarangById($id_barang)->row();
        $bayar = "0";
        $total = $barang->harga_barang;
        //dont touch
        // if($status == 0){
        //     $tempo = 0;
        //     $dataPenagihan = array(
        //         'kode_bayar'        => $kode . '-1',
        //         'no_faktur'       => $kode,
        //         'total_bayar'       => $total,
        //         'tgl_bayar'         => $tgl,
        //         'id_user'        => $idSales,
        //     );
        //     $isTagih = $this->global_model->insert('tbl_penagihan',$dataPenagihan);
        //     if(!$isTagih){
        //         echo json_encode(array('errorMsg'=>'Error Penagihan.'));
        //     }
        // }else{
        //     $totalTagih = $total/$status;
        //     $dataPenagihan = array(
        //         'kode_bayar'        => $kode . '-1',
        //         'no_faktur'       => $kode,
        //         'total_bayar'       => $totalTagih,
        //         'tgl_bayar'         => $tgl,
        //         'id_user'        => $idSales,
        //     );
        //     $isTagih = $this->global_model->insert('tbl_penagihan',$dataPenagihan);
        //     if(!$isTagih){
        //         echo json_encode(array('errorMsg'=>'Error Penagihan.'));
        //     }
        //     $tempo = $this->input->post('tgl_tempo');
        //     $bayar = "1";
        // }
        // $stokLama = $barang->stok;
        // $dataStok = array();
        // $stokBaru = $stokLama-1;
        // $dataStok = array(
        //     'stok' => $stokBaru,
        // );
        // $where = array('_id'=>$id_barang);
        // $update = $this->global_model->update('tbl_barang',$dataStok, $where);
        // if(!$update){
        //     echo json_encode(array('errorMsg'=>'Error Update Stok.'));
        // }
        //-----///
        $data=array();
        $data = array(
            'no_faktur'         => $kode,
            'nama_pembeli'      => $nama,
            'alamat'            => $alamat,
            'no_telp'           => $tlfn,
            'tgl_transaksi'     => $tgl,
            'id_barang'         => $id_barang,
            'id_user'           => $idSales,
            'status_penjualan'  => $status,
            'status_bayar'      => $bayar,
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
    function saveCatatanPenjualan(){
        $idPenjualan = $this->input->get('id');
        $catatan = $this->input->post('catatan');
        $data = array(
            'id_penjualan'  => $idPenjualan,
            'catatan'       => $catatan      
        );
        $result = $this->global_model->insert('tbl_catatan',$data);
        if ($result){
            echo json_encode(array('message'=>'Save Catatan Success'));
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
    function destroyPenagihan(){
        $id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_penagihan',array('_id'=>$id));
        if ($result){
            echo json_encode(array('message'=>'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    function editPenagihan(){

    }
    function savePenagihan(){
        $kode = $this->input->get('kode',TRUE);
        $total = $this->input->post('total_bayar',TRUE);
        $tgl_bayar = $this->input->post('tgl_bayar',TRUE);
        $kaliBayar = $this->backend_model->getTotalBayar($kode);
        $kodeBaru = $kode .'-'.(($kaliBayar->num_rows())+1);
        $id = 1;
        $data = array(
            'kode_bayar'    => $kodeBaru,
            'no_faktur'     => $kode,
            'total_bayar'   => $total,
            'tgl_bayar'     => $tgl_bayar,
            'id_user'       => $id,
        );
        $result = $this->global_model->insert('tbl_penagihan',$data);
        if ($result){
            echo json_encode(array('message'=>'Save Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    //end penagihan
    //end modul transaksi

    //Modul Laporan
    //end modul laporan

    //modul approval//
    //approve penjualan//
   
    function isPenagih(){
        $this->output->set_content_type('application/json');
        $data = $this->backend_model->getIsPenagih();
        echo json_encode($data);
    }
    function gantiPenagih(){
        $id         = $this->input->get('id');
        $idPenagih  = $this->input->post('id_kolektor');
        $result     = $this->global_model->update('tbl_penjualan',array('id_penagih'=>$idPenagih),array('_id'=>$id));
        if ($result){
            echo json_encode(array('message'=> 'Ganti Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    function inputTagihan(){
        $data['title']  = 'Data Penjualan Cka';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template','master/inputtagihan',$data);
    }
    function penagihanApprove(){
        $data['title']  = 'Data Penjualan Cka';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template','master/penagihanapprove',$data);
    }
    function getApprovePenagihan(){
        $this->output->set_content_type('application/json');
		$data = $this->backend_model->getApprovePenagihan();
		echo json_encode($data);
    }
    function approvePenagihan(){
        $id         = $this->input->post('id');
        $rows       = $this->db->get_where('tbl_penagihan', array('_id'=>$id))->row_array();
        if ($rows['status'] == '0'){
            $approve = '1';
        }else{
            $approve = '0';
        }
        $result = $this->global_model->update('tbl_penagihan',array('status'=>$approve,), array('_id'=>$id));
        if ($result){
            echo json_encode(array('message'=> 'Faktur '.$rows['no_faktur'].' Approve Success'));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }
    function getFakturTagihan(){
        $month = date('m');
        $id = $this->session->_id;
        $posisi = $this->session->posisi;
        if($posisi == 6){
    		$data = $this->backend_model->getFakturTagihanById($month,$id);
        }else{
    		$data = $this->backend_model->getFakturTagihan($month);
        }
        $this->output->set_content_type('application/json');
		echo json_encode($data);
    }
}
