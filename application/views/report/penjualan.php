<section class="content-header"></section>
<div class="col-12">
	<div class="card">
	  <div class="easyui-panel" style="position:relative;overflow:auto;">
	    <div class="card-body">
	      <div class="easyui-layout">
	          <table id="dgGrid" title="<?= $title;?>" 
	            toolbar="#toolbar" 
	            class="easyui-datagrid" 
	            rowNumbers="true" 
	            pagination="true" 
	            url="<?= base_url('report/getpenjualan') ?>" 
	            pageSize="20" 
	            pageList="[10,20,50,75,100,125,150,200]" 
	            nowrap="true" 
	            showFooter="true"
	            singleSelect="true">
	              <thead>
	                  <tr>
	                      <th field="no_faktur" width="15%">No Faktur</th>
	                      <th field="nama_pembeli" width="15%">Nama Pembeli</th>
	                      <th field="nama_barang" width="10%" align="center">Nama Barang</th>
		                  <th field="tgl_transaksi" width="20%" data-options="formatter:formatTgl" sortable="true">Tanggal Transaksi</th>
		                  <th field="status_penjualan" width="25%" data-options="formatter:formatStatusBeli">Status Penjualan</th>
		                  <th field="nama" width="15%" align="center" sortable="true">Nama Sales</th>
		            	  <th field="total" width="15%" data-options="formatter:formatRupiah" align="center" sortable="true">Jumlah</th>
	                      <!-- <th field="date" width="15%">Tgl Antrian</th>
	                      <th field="photo" width="10%" data-options="formatter:avatars" align="center">Photo</th>
		                  <th field="name" width="20%" data-options="formatter:nama" sortable="true">Nama</th>
		                  <th field="nm_counter" width="25%">Loket Tujuan</th>
		                  <th field="antrian" width="15%" align="center" sortable="true">No. Antrian</th>
		            	  <th field="status" width="15%" data-options="formatter:statusantrian" align="center" sortable="true">Status</th> -->
	                  </tr>
	              </thead>
	          </table>

	          <div id="toolbar" style="padding: 10px">
	              <div class="row ml-1">
	                  <div class="col-sm-6">
                      	<div class="float-sm-right" style="vertical-align: middle;">
                      	<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="print()">Print</a>
                          	<div id="filter_tgl" class="input-group" style="display: inline;">
									<button class="btn btn-default" id="daterange-btn" style="line-height:16px;border:1px solid #ccc">
										<i class="fa fa-calendar"></i> <span id="reportrange"><span> Select Date</span></span>
										<i class="fa fa-caret-down"></i>
									</button>
								</div>
							</div>
                      </div>
	                  <div class="col-sm-6 pull-right">
	                      <input  id="searchkas" placeholder="" style="width:60%;" align="right">
	                      <a href="javascript:void(0);"  id="btn_serach" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Search</a>
                          <button class="easyui-linkbutton" onclick="exportExcel()">Export To Excel</button>
	                  </div>
	                </div>
	                    
	              </div>
	          </div>
	        </div>
	    </div>
	  </div>
	  <!-- /.card-header -->
	  <div id="dialog-form" class="easyui-window" title="Add New Category" data-options="modal:true,closed:true,iconCls:'icon-add',inline:true,onResize:function(){
	          $(this).window('vcenter');
	      }" style="width:100%;max-width:700px;padding:5px 5px;">
	      <div class="card bg-light" id="detail">
            
          </div>
	   </div>
	</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
  	fm_filter_tgl();
  	$('#dgGrid').datagrid({
  		minHeight:450,
    	maxHeight:520,
	});
    $('#search').keyup(function(event){
      if(event.keyCode == 13){
        $('#btn_serach').click();
      }
    });
  })
  function fm_filter_tgl() {
	$('#daterange-btn').daterangepicker({
		ranges: {
			'Hari ini': [moment(), moment()],
			'Kemarin': [moment().subtract('days', 1), moment().subtract('days', 1)],
			'7 Hari yang lalu': [moment().subtract('days', 6), moment()],
			'30 Hari yang lalu': [moment().subtract('days', 29), moment()],
			'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
			'Bulan kemarin': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
			'Tahun ini': [moment().startOf('year').startOf('month'), moment().endOf('year').endOf('month')],
			'Tahun kemarin': [moment().subtract('year', 1).startOf('year').startOf('month'), moment().subtract('year', 1).endOf('year').endOf('month')]
		},
		showDropdowns: true,
		format: 'YYYY-MM-DD',
		startDate: moment().startOf('year').startOf('month'),
		endDate: moment().endOf('year').endOf('month')
	},

	function(start, end) {
		$('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
		doSearch();
	});
}

function doSearch(){
	$('#dgGrid').datagrid('load',{
		start: 	$('input[name=daterangepicker_start]').val(),
		end: $('input[name=daterangepicker_end]').val(),
		search_data: $('#search').val()
	});
}
function formatRupiah(index, row) {
	return accounting.formatMoney(row.total, "Rp ", 0, ".", ",");
}

function formatStatusBeli(i, r) {
    if(r.status_penjualan){
        if (r.status_penjualan == 0) {
            return 'Tunai';
        } else {
            return 'Kredit';
        }
    }
}

function formatTgl(i,r){
    if(r.tgl_transaksi){
        return new Date(r.tgl_transaksi).toLocaleDateString('id-ID',{year:'numeric',month:'long',day:'numeric'})
    }
}

function formatStatusBayar(i, r) {
    if (r.status_bayar == "0") {
        return 'Tunai';
    } else if (r.status_bayar == "1") {
        return 'Belum Lunas';
    } else {
        return 'Sudah Lunas';
    }
}

function print(){
    $('#dgGrid').datagrid('print','DataGrid');
}
function exportExcel(){
    let data = $('#dgGrid').datagrid('getRows');
    let jumlah = 0;
    $.each(data,function(i,r){
        jumlah += parseInt(r.total);
    })
    $('#dgGrid').datagrid('toExcel',{
        filename: 'Laporan Penjualan.xls',
        footer: [{
            nama: 'Total',
            total: jumlah
        }]
    });
}

</script>