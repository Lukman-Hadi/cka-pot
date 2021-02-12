<section class="content-header"></section>
<div class="col-12">
	<div class="card">
		<div class="easyui-panel" style="position:relative;overflow:auto;">
			<div class="card-body">
				<div class="easyui-layout">
					<table id="dgGrid" title="" toolbar="#toolbar" class="easyui-datagrid" rowNumbers="true" pagination="true" url="<?= base_url('admin/getApprovePenjualan') ?>" pageSize="50" pageList="[10,20,50,75,100,125,150,200]" nowrap="true" singleSelect="true">
						<thead>
							<tr>
								<th field="no_faktur" width="5%">No KWT</th>
								<th field="nama_pembeli" width="10%">Nama Konsumen</th>
								<th field="alamat" width="20%">Alamat Kosumen</th>
								<th field="no_telp" width="10%">Telp Kosumen</th>
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
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="newForm()">Approve</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="false" onclick="destroy()">Delete</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" plain="false" onclick="detail()">Detail</a>
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
	</div>
</div>
<div id="dialog-form" class="easyui-window" title="Add New Goods" data-options="modal:true,closed:true,iconCls:'icon-save',inline:false,onResize:function(){
	          $(this).window('hcenter');
	      }" style="width:100%;max-width:500px;padding:30px 60px;">
	<form id="ff" class="easyui-form" method="post" data-options="novalidate:false" enctype="multipart/form-data">
		<div style="margin-bottom:20px">
			<input class="easyui-textbox" id="ispenagih" name="id_penagih" style="width:100%" data-options="label:'Penagih:',required:true">
		</div>
		<input type="text" name="id" id="id_penjualan" hidden>
	</form>
	<div id="dialog-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="submitForm()">Simpan</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
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
		$('#ispenagih').combobox({
			url: 'ispenagih',
			valueField: '_id',
			textField: 'nama',
			setText: 'nama',
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
				console.log('result', result)
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
		var row = $('#dgGrid').datagrid('getSelected');
		console.log('row :>> ', row);
		$('#dialog-form').dialog('open').dialog('setTitle', 'Add New Goods');
		$('#ff').form('clear');
		$('#id_penjualan').val(row._id)
		url = 'approvePenjualan';
	}

	function catatan() {
		var row = $('#dgGrid').datagrid('getSelected');
		if (row) {
			$('#catatan-form').dialog('open').dialog('setTitle', 'Tambah Catatan ' + row.no_faktur);
			url = 'saveCatatanPenjualan?id=' + row._id;
		}
	}

	function approve() {
		var row = $('#dgGrid').datagrid('getSelected');
		if (row) {
			$.messager.confirm('Confirm', 'Are you sure you want to Approve this sales ? ' + row.no_faktur, function(r) {
				if (r) {
					$.post('approvePenjualan', {
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

	function saveCatatan() {
		var string = $("#catatan").serialize();
		$('#catatan').form('submit', {
			url: url,
			onSubmit: function() {
				return $(this).form('validate');
			},
			success: function(result) {
				console.log('result', result)
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
					$('#catatan-form').dialog('close'); // close the dialog
					$('#dgGrid').datagrid('reload'); // reload the user data
				}
			}
		});
	}

	function editForm() {
		var row = $('#dgGrid').datagrid('getSelected');
		if (row) {
			$('#dialog-form').dialog('open').dialog('setTitle', 'Edit Barang' + row.nama_barang);
			$('#ff').form('load', row);
			$('#harga').textbox('setValue', row.harga_barang)
			url = 'updatePenjualan?id=' + row._id;
		}
	}

	function detail() {
		var row = $('#dgGrid').datagrid('getSelected');
		if (row) {
			window.location.replace("getdetailpenjualan/" + row._id);
		}
	}

	function destroy() {
		var row = $('#dgGrid').datagrid('getSelected');
		if (row) {
			$.messager.confirm('Confirm', 'Are you sure you want to destroy this Goods ? ' + row.nama_barang, function(r) {
				if (r) {
					$.post('destroyPenjualan', {
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
		return accounting.formatMoney(row.total, "Rp ", 0, ".", ",");
	}

	function formatStatusBeli(i, r) {
		if (r.status_penjualan == 0) {
			return 'Tunai';
		} else {
			return 'Kredit';
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

	function formatTerakhirBayar(i, r) {
		let t = r.last_update.split(/[- :]/);
		console.log('r', t)
		// // Apply each element to the Date function
		// let d = new Date(r.last_update).toDateString();
		// return d;
		let bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		let tanggal = t[2];
		let bulan = t[1];
		let tahun = t[0];
		console.log('tanggal', tanggal)

		return tanggal + " " + bulanIndo[Math.abs(bulan)] + " " + tahun;
	}

	function formatApprove(i, r) {
		console.log('r.status_approve', r.status_approve)
		if (r.status_approve == 1) {
			return 'Sudah Approve'
		} else {
			return 'Belum Approve'
		}
	}
</script>