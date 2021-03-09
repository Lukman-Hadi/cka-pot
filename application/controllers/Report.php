<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Report_model','report_model');
        $this->load->model('Menu_model','menu_model');
        $this->load->model('Global_model','global_model');
    }
    function penjualan(){
        $data['title']  = 'Laporan Penjualan';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material-blue/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['css_files'][] = base_url() . 'assets/admin/plugins/daterangepicker/daterangepicker-bs3.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-export.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/daterangepicker/daterangepicker.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/chartjs/Chart.bundle.js';
        $data['content'] = 'test';
		$this->template->load('template','report/penjualan',$data);
    }
    function penagihan(){
        $data['title']  = 'Laporan Penjualan';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material-blue/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['css_files'][] = base_url() . 'assets/admin/plugins/daterangepicker/daterangepicker-bs3.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-export.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/daterangepicker/daterangepicker.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/chartjs/Chart.bundle.js';
		$this->template->load('template','report/penagihan',$data);
    }
    function pendapatan(){

    }
    function getPenjualan(){
        $this->output->set_content_type('application/json');
        $data = $this->report_model->getPenjualan();
        echo json_encode($data);
    }
    function getPenagihan(){

    }
    function getPendapatan(){

    }
    function getChartPenjualan(){

    }
    function getChartPenagihan(){

    }
    function getChartPendapatan(){

    }
}