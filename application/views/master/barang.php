<section class="content-header"></section>
<div class="col-12">
	<div class="card">
		<div class="easyui-panel" style="position:relative;overflow:auto;">
			<div class="card-body">
				<div class="easyui-layout">
					<table id="dgGrid" title="" toolbar="#toolbar" class="easyui-datagrid" rowNumbers="true" pagination="true" url="<?= base_url('admin/getBarang') ?>" pageSize="50" pageList="[10,20,50,75,100,125,150,200]" nowrap="true" singleSelect="true">
						<thead>
							<tr>
								<th field="kode_barang" width="15%">Kode Barang</th>
								<th field="nama_barang" width="35%">Nama Barang</th>
								<th field="harga_barang" data-options="formatter:formatRupiah" width="15%">Harga Barang</th>
								<th field="stok" width="10%">Stok</th>
								<th field="Total" data-options="formatter:formatTotal" width="25%">Total</th>
							</tr>
						</thead>
					</table>

					<div id="toolbar" style="padding: 10px">
						<div class="row ml-1">
							<div class="col-sm-6">
								<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="newForm()">Add</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="false" onclick="editForm()">Edit</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="false" onclick="destroy()">Delete</a>
							</div>

							<div class="col-sm-6 pull-right">
								<input id="search" placeholder="Please Enter Search a Goods" style="width:60%;" align="right">
								<a href="javascript:void(0);" id="btn_serach" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Search</a>
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
					<input class="easyui-textbox" name="kode_barang" style="width:100%" data-options="label:'Kode Barang:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input id="nama" class="easyui-textbox" name="nama_barang" style="width:100%" data-options="label:'Nama Barang:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input id="harga" class="easyui-numberbox" name="harga_barang" style="width:100%" data-options="label:'Harga Barang:',required:true,groupSeparator:'.',prefix:'Rp '">
				</div>
				<div style="margin-bottom:20px">
					<input type="number" class="easyui-textbox" name="stok" style="width:100%" data-options="label:'Stok Awal:',required:true">
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
	$(document).ready(function() {
		$('#dgGrid').datagrid({
			minHeight: 720,
			maxHeight: 800,
		});
		$('#search').keyup(function(event) {
			if (event.keyCode == 13) {
				$('#btn_serach').click();
			}
		});
	})

	function doSearch() {
		$('#dgGrid').datagrid('load', {
			search_data: $('#search').val()
		});
	}

	function submitForm() {
		var string = $("#ff").serialize();
		$('#ff').form('submit', {
			url: url,
			onSubmit: function() {
				return $(this).form('validate');
			},
			success: function(result) {
				var result = eval('(' + result + ')');
				if (result.errorMsg) {
					Toast.fire({
						type: 'error',
						title: '' + result.errorMsg + '.'
					})
				} else {
					Toast.fire({
						type: 'success',
						title: '' + result.message + '.'
					})
					$('#dialog-form').dialog('close'); // close the dialog
					$('#dgGrid').datagrid('reload'); // reload the user data
				}
			}
		});
	}

	function newForm() {
		$('#dialog-form').dialog('open').dialog('setTitle', 'Add New Goods');
		$('#ff').form('clear');
		url = 'saveBarang';
	}

	function editForm() {
		var row = $('#dgGrid').datagrid('getSelected');
		if (row) {
			$('#dialog-form').dialog('open').dialog('setTitle', 'Edit Barang' + row.nama_barang);
			$('#ff').form('load', row);
			$('#harga').textbox('setValue', row.harga_barang)
			url = 'updateBarang?id=' + row._id;
		}
	}

	function destroy() {
		var row = $('#dgGrid').datagrid('getSelected');
		if (row) {
			$.messager.confirm('Confirm', 'Are you sure you want to destroy this Goods ? ' + row.nama_barang, function(r) {
				if (r) {
					$.post('destroyBarang', {
						id: row._id
					}, function(result) {
						if (result.errorMsg) {
							Toast.fire({
								type: 'error',
								title: '' + result.errorMsg + '.'
							})
						} else {
							Toast.fire({
								type: 'success',
								title: '' + result.message + '.'
							})
							$('#dgGrid').datagrid('reload');
						}
					}, 'json');
				}
			});
		}
	}

	function formatRupiah(index, row) {
		return accounting.formatMoney(row.harga_barang, "Rp ", 0, ".", ",");
	}

	function formatTotal(index, row) {
		return accounting.formatMoney((row.harga_barang * row.stok), "Rp ", 0, ".", ",");
	}
</script>