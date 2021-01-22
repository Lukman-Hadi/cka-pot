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
	                      <th field="status_bayar" data-options="formatter:formatStatusBayar" width="5%">Status Pembayaran</th>
	                      <th field="status_penjualan" data-options="formatter:formatStatusBeli" width="5%">Metode Bayar</th>
	                      <th field="total" data-options="formatter:formatRupiah" width="10%">Jumlah</th>
	                      <th field="last_update" data-options="formatter:formatTerakhirBayar" width="10%">Terakhir Bayar</th>
	                  </tr>
	              </thead>
	          </table>

	          <div id="toolbar" style="padding: 10px">
	              <div class="row ml-1">
	                  <div class="col-sm-6">
	                  	<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="newForm()">Add</a>
	                  	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="false" onclick="destroy()">Delete</a>
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
					<input class="easyui-textbox" name="kode_faktur" style="width:100%" data-options="label:'Kode Faktur:',required:true">
				</div>
	      		<div style="margin-bottom:20px">
					<input id="iskodebarang" class="easyui-textbox" name="kode_barang" style="width:100%" data-options="label:'Kode Barang:',required:true, editable:false">
				</div>
				<div style="margin-bottom:20px">
					<input type="number" class="easyui-textbox" name="jumlah" style="width:100%" data-options="label:'Jumlah:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input type="date" class="easyui-textbox" name="tgl" style="width:100%" data-options="label:'Tanggal:',required:true">
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
	$('#iskodebarang').combobox({
  	    url:'isbarang',
  	    valueField:'_id',
  	    textField:'nama_barang',
        setText:'nama_barang',
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
	url = 'saveBarangMasuk';
}
function editForm(){
	var row = $('#dgGrid').datagrid('getSelected');
		if (row){
			$('#dialog-form').dialog('open').dialog('setTitle','Edit Barang' + row.nama_barang);
            $('#ff').form('load',row);
            $('#harga').textbox('setValue',row.harga_barang)
			url = 'updateBarang?id='+row._id;
		}
}
function destroy(){
    var row = $('#dgGrid').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm','Are you sure you want to destroy this Goods ? '+ row.nama_barang,function(r){
            if (r){
                $.post('destroyBarangMasuk',{id:row._id},function(result){
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
function formatStatusBayar(i,r){
    if(r.status_bayar==0){
        return 'Belum Bayar';
    }else if(r.status_bayar==1){
        return 'Sudah Bayar';
    }else{
        return 'lunas';
    }
}
function formatStatusBeli(i,r){
    if(r.status_bayar==0){
        return 'Kredit';
    }else{
        return 'Tunai';
    }
}
function formatTerakhirBayar(i,r){
    let t = r.last_update.split(/[- :]/);
    // Apply each element to the Date function
    let d = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3]));
    console.log('d :>> ', d);
    return d;
}
</script>