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
	            url="<?= base_url('admin/getUsers') ?>" 
	            pageSize="50" 
	            pageList="[10,20,50,75,100,125,150,200]" 
	            nowrap="true" 
	            singleSelect="true">
	              <thead>
	                  <tr>
	                      <th field="nik" width="10%">Nik</th>
	                      <th field="nama" width="20%">Nama</th>
	                      <th field="jk" width="10%">Jenis Kelamin</th>
	                      <th field="posisi" width="20%">Posisi</th>
	                      <th field="alamat" width="30%">Alamat</th>
	                      <th field="is_aktif" data-options="formatter:formatDetailactive" width="10%" align="center">Status</th>
	                  </tr>
	              </thead>
	          </table>

	          <div id="toolbar" style="padding: 10px">
	              <div class="row ml-1">
	                  <div class="col-sm-6">
	                  	<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="newForm()">Add</a>
	                  	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="false" onclick="editForm()">Edit</a>
	                  	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="false" onclick="aktif()">Aktif / Non Aktif</a>
	                  	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="false" onclick="destroy()">Delete</a>
	                  </div>
	                  
	                  <div class="col-sm-6 pull-right">
	                      <input  id="search" placeholder="Please Enter Search a Users" style="width:60%;" align="right">
	                      <a href="javascript:void(0);"  id="btn_serach" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Search</a>
	                  </div>
	              </div>
	          </div>
	        </div>
	    </div>
	  </div>
	  <!-- /.card-header -->
	  <!-- Dialog -->
	  <div id="dialog-form" class="easyui-window" title="Add New Menu" data-options="modal:true,closed:true,iconCls:'icon-save',inline:false,onResize:function(){
	          $(this).window('hcenter');
	      }" style="width:100%;max-width:500px;padding:30px 60px;">
	      	<form id="ff" class="easyui-form" method="post" data-options="novalidate:false" enctype="multipart/form-data">
	      		<div style="margin-bottom:20px">
					<input class="easyui-textbox" name="nik" style="width:100%" data-options="label:'Nik:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input id="pass" class="easyui-passwordbox" name="password" prompt="Password" iconWidth="28" style="width:100%" data-options="label:'Password:',required:false">
				</div>
				<div style="margin-bottom:20px">
					<input id="nama" class="easyui-textbox" name="nama" style="width:100%" data-options="label:'Nama Lengkap:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input id="jk" class="easyui-textbox" name="jk" style="width:100%" data-options="label:'Jenis Kelamin:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-textbox" name="tempat_lahir" style="width:100%" data-options="label:'Tempat Lahir:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-textbox" name="tgl_lahir" type="date" style="width:100%" data-options="label:'Tanggal Lahir:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-textbox" name="tgl_masuk" type="date" style="width:100%" data-options="label:'Tanggal Masuk:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input id="islevel" class="easyui-textbox" name="posisi" style="width:100%" data-options="label:'Posisi :',required:true">
				</div>
				<div style="margin-bottom:20px">
					<textarea class="easyui-textbox" name="alamat" style="width:100%" data-options="label:'Alamat :',required:true,multiline:true,height:100"></textarea>
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
  	$('#islevel').combobox({
  	    url:'islevel',
  	    valueField:'_id',
  	    textField:'posisi',
        setText:'posisi'
  	});
  	$('#jk').combobox({
		textField: 'jenis',
		valueField: 'value',
		data: [
			{ 'jenis': 'Laki-Laki', "value": 'L' },
			{ 'jenis': 'Perempuan', "value": 'P' },
		]
  	});
  	$('#dgGrid').datagrid({
  		minHeight:720,
    	maxHeight:800,
	});
    $('#search').keyup(function(event){
      if(event.keyCode == 13){
        $('#btn_serach').click();
      }
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
	$('#dialog-form').dialog('open').dialog('setTitle','Add New Users');
	$('#ff').form('clear');
	url = 'saveUsers';
}

function editForm(){
	var row = $('#dgGrid').datagrid('getSelected');
		if (row){
			$('#dialog-form').dialog('open').dialog('setTitle','Edit Users' + row.nama);
			$('#ff').form('load',row);
			$('#pass').textbox('setValue', '');
			$('#islevel').textbox('setValue', '');
			$('#jk').textbox('setValue', '');
			url = 'updateUsers?id='+row._id;
		}
}

function destroy(){
    var row = $('#dgGrid').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm','Are you sure you want to destroy this Users ? '+ row.nama,function(r){
            if (r){
                $.post('destroyUsers',{id:row._id},function(result){
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

function aktif(){
    var row = $('#dgGrid').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm','Are you sure you want to Aktif or Non Aktif ? '+ row.nama,function(r){
            if (r){
                $.post('aktifUsers',{id:row._id},function(result){
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

function formatDetailactive(index, row){
	if (row.is_aktif == 1){
		return '<span class="l-btn-left"><span class="l-btn-text"><i class="fa fa-eye" style="color:#007bff;"></i> Active</span></span>';
	}else{
		return '<span class="l-btn-left"><span class="l-btn-text"><i class="fa fa-eye-remove" style="color:#007bff;"></i> In Active</span></span>';
	}
}

// function formatDetail(index,row){
// 	if (row.photo == '' || row.photo == null){
// 		return '<a href="#" class="pop" data-backdrop="static" onClick="zoomImage()"><img src="../assets/avatars/profil.png" width="25"></a>';		
// 	}else{
// 		return '<a href="#" class="pop" data-backdrop="static" onClick="zoomImage()"><img src="../assets/avatars/'+row.photo+'" width="25"></a>';
// 	}
// }
</script>