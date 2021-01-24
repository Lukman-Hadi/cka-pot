<section class="content-header"></section>
<div class="col-12">
	<div class="card">
	  <div class="easyui-panel" style="position:relative;overflow:auto;">
	    <div class="card-body">
	      <div class="easyui-layout">
	          <table id="dgGrid" title="" 
	            toolbar="#toolbar" 
	            class="easyui-datagrid" 
	            rowNumbers="true" 
	            pagination="true" 
	            url="<?= base_url('admin/getPenjualan') ?>" 
	            pageSize="50" 
	            pageList="[10,20,50,75,100,125,150,200]" 
	            nowrap="true" 
	            singleSelect="true">
	              <thead>
	                  <tr>
	                      <th field="no_faktur" width="5%">No KWT</th>
	                      <th field="nama_pembeli" width="10%">Nama Konsumen</th>
	                      <th field="alamat"  width="20%">Alamat Kosumen</th>
	                      <th field="no_telp"  width="10%">Telp Kosumen</th>
	                      <th field="tgl_transaksi" width="10%">Tanggal Penjualan</th>
	                      <th field="nama_barang" width="15%">Nama Barang</th>
	                      <th field="nama" width="10%">Sales</th>
	                      <th field="status_penjualan" data-options="formatter:formatStatusBeli" width="5%" sortable="true">Pembelian</th>
	                      <th field="status_bayar" data-options="formatter:formatStatusBayar" width="5%" sortable="true">Status Pembayaran</th>
	                      <th field="tgl_tempo" width="5%" sortable="true">Jatuh Tempo</th>
	                      <th field="total" data-options="formatter:formatRupiah" width="10%">Jumlah</th>
	                      <th field="last_update" data-options="formatter:formatTerakhirBayar" width="10%">Terakhir Bayar</th>
	                      <th field="status_approve" data-options="formatter:formatApprove" width="10%">Approval</th>
	                  </tr>
	              </thead>
	          </table>

	          <div id="toolbar" style="padding: 10px">
	              <div class="row ml-1">
	                  <div class="col-sm-6">
	                  	<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="newForm()">Add</a>
	                  	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="false" onclick="destroy()">Delete</a>
	                  	<a href="javascript:void(0)" class="easyui-linkbutton" plain="false" onclick="edit(">Edit</a>
	                  	<a href="javascript:void(0)" class="easyui-linkbutton" plain="false" onclick="detail()">Detail</a>
	                  	<a href="javascript:void(0)" class="easyui-linkbutton" plain="false" onclick="catatan()">Tambah Catatan</a>
	                  </div>
	                  
	                  <div class="col-sm-6 pull-right">
	                      <input  id="search" placeholder="Please Enter Search a Goods" style="width:60%;" align="right">
	                      <a href="javascript:void(0);"  id="btn_serach" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Search</a>
	                  </div>
	              </div>
	          </div>
	        </div>
	    </div>
	  </div>
	  <!-- /.card-header -->
	  <!-- Dialog -->
	  	<div id="dialog-form" class="easyui-window" title="Add New Goods" data-options="modal:true,closed:true,iconCls:'icon-save',inline:false,onResize:function(){
	          $(this).window('hcenter');
	      }" style="width:100%;max-width:500px;padding:30px 60px;">
	      	<form id="ff" class="easyui-form" method="post" data-options="novalidate:false" enctype="multipart/form-data">
	      		<div style="margin-bottom:20px">
					<input class="easyui-textbox" name="kode_faktur" style="width:100%" data-options="label:'No Faktur:',required:true">
				</div>
	      		<div style="margin-bottom:20px">
					<input class="easyui-textbox" name="nama_pembeli" style="width:100%" data-options="label:'Nama:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<textarea class="easyui-textbox" name="alamat_pembeli" style="width:100%" data-options="label:'Alamat :',required:true,multiline:true,height:100"></textarea>
				</div>
				<div style="margin-bottom:20px">
					<input type="number" class="easyui-textbox" name="no_tlfn" style="width:100%" data-options="label:'No Tlfn:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input id="barang" class="easyui-textbox" name="id_barang" style="width:100%" data-options="label:'Produk :',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input id="metode" class="easyui-textbox" name="status_penjualan" style="width:100%" data-options="label:'Termin :',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input id="tempo" type="number" value="0" class="easyui-textbox" name="tgl_tempo" style="width:100%" data-options="label:'Jatuh Tempo:',readonly:false, initValue:0, setText:'0'">
				</div>
				<div style="margin-bottom:20px">
					<input type="date" class="easyui-textbox" name="tgl_jual" style="width:100%" data-options="label:'Tanggal Jual:', required: true">
				</div>
				</form>
				<div id="dialog-buttons">
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="submitForm()">Simpan</a>
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
				</div>
	   	</div>
	  	<div id="catatan-form" class="easyui-window" title="Tambah Catatan" data-options="modal:true,closed:true,iconCls:'icon-save',inline:false,onResize:function(){
	          $(this).window('hcenter');
	      }" style="width:100%;max-width:500px;padding:30px 60px;">
	      	<form id="catatan" class="easyui-form" method="post" data-options="novalidate:false" enctype="multipart/form-data">
				<div style="margin-bottom:20px">
					<textarea class="easyui-textbox" name="catatan" style="width:100%" data-options="label:'Catatan :',required:true,multiline:true,height:500"></textarea>
				</div>
				</form>
				<div id="dialog-buttons">
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="submitForm()">Simpan</a>
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
				</div>
	   	</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#dgGrid').datagrid({
        minHeight:720,
        maxHeight:800,
    });
    $('#search').keyup(function(event){
        if(event.keyCode == 13){
        $('#btn_serach').click();
        }
    });
	$('#barang').combobox({
  	    url:'isbarang',
  	    valueField:'_id',
  	    textField:'nama_barang',
        setText:'nama_barang',
	  });
	$('#metode').combobox({
	textField: 'metode',
	valueField: 'value',
	data: [
		{ 'metode': 'Tunai', "value": 0 },
		{ 'metode': 'Kredit 7 Bulan', "value": 7 },
		{ 'metode': 'Kredit 10 Bulan', "value": 10 },
	]
	});
})
function doSearch(){
	$('#dgGrid').datagrid('load',{
		search_data: $('#search').val()
	});
}
function submitForm(){
	var string = $("#ff").serialize();
	$('#ff').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			console.log('result', result)
			var result = eval('('+result+')');
			if (result.errorMsg){
				Toast.fire({
	              type: 'error',
	              title: ''+result.errorMsg+'.'
	              })
			} else {
				Toast.fire({
                  type: 'success',
                  title: ''+result.message+'.'
                })
				$('#dialog-form').dialog('close');		// close the dialog
				$('#dgGrid').datagrid('reload');	// reload the user data
			}
		}
	});
}
function newForm(){
	$('#dialog-form').dialog('open').dialog('setTitle','Add New Goods');
	$('#ff').form('clear');
	url = 'savePenjualan';
}
function catatan(){
	var row = $('#dgGrid').datagrid('getSelected');
		if (row){
			$('#catatan-form').dialog('open').dialog('setTitle','Edit Barang' + row.nama_barang);
			url = 'updatePenjualan?id='+row._id;
		}
}
function editForm(){
	var row = $('#dgGrid').datagrid('getSelected');
		if (row){
			$('#dialog-form').dialog('open').dialog('setTitle','Edit Barang' + row.nama_barang);
            $('#ff').form('load',row);
            $('#harga').textbox('setValue',row.harga_barang)
			url = 'updatePenjualan?id='+row._id;
		}
}
function detail(){
	var row = $('#dgGrid').datagrid('getSelected');
		if (row){
			window.location.replace("getdetailpenjualan/"+row._id);
		}
}
function destroy(){
    var row = $('#dgGrid').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm','Are you sure you want to destroy this Goods ? '+ row.nama_barang,function(r){
            if (r){
                $.post('destroyPenjualan',{id:row._id},function(result){
                    if (result.errorMsg){
                        Toast.fire({
			              type: 'error',
			              title: ''+result.errorMsg+'.'
			            })
                    } else {
                        Toast.fire({
		                  type: 'success',
		                  title: ''+result.message+'.'
		                })
                        $('#dgGrid').datagrid('reload');
                    }
                },'json');
            }
        });
    }
}
function formatRupiah(index, row){
	return accounting.formatMoney(row.total, "Rp ", 0, ".", ",");
}
function formatStatusBeli(i,r){
    if(r.status_penjualan==0){
        return 'Tunai';
    }else{
        return 'Kredit';
    }
}
function formatStatusBayar(i,r){
    if(r.status_bayar=="0"){
        return 'Tunai';
    }else if(r.status_bayar=="1"){
        return 'Belum Lunas';
    }else{
		return 'Sudah Lunas';
	}
}
function formatTerakhirBayar(i,r){
	let t = r.last_update.split(/[- :]/);
	console.log('r',t)
    // // Apply each element to the Date function
	// let d = new Date(r.last_update).toDateString();
	// return d;
	let bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];
    let tanggal = t[2];
    let bulan = t[1];
	let tahun = t[0];
	console.log('tanggal', tanggal)
 
    return tanggal + " " + bulanIndo[Math.abs(bulan)] + " " + tahun;
}
function formatApprove(i,r){
	if(r.status_approve){
		return 'Belum Approve'
	}else{
		return 'Sudah Approve'
	}
}
</script>