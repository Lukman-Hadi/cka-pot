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
	            url="<?= base_url('admin/getMenus') ?>" 
	            pageSize="50" 
	            pageList="[10,20,50,75,100,125,150,200]" 
	            nowrap="true" 
	            singleSelect="true">
	              <thead>
	                  <tr>
	                      <th field="title" width="40%">Title</th>
	                      <th field="uri" width="30%">URL</th>
	                      <th field="icon" width="20%">ICON</th>
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
	                      <input  id="search" placeholder="Please Enter Search a Menu" style="width:60%;" align="right">
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
					<input class="easyui-textbox" name="title" style="width:100%" data-options="label:'Nama Menu:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-textbox" name="uri" style="width:100%" data-options="label:'Link Menu:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-textbox" name="icon" style="width:100%" data-options="label:'Icon Menu:',required:true">
				</div>
				<div style="margin-bottom:20px">
					<input id="ismain" class="easyui-textbox" name="is_main" style="width:100%" data-options="label:'Main Menu:',required:false">
				</div>
				<div style="margin-bottom:20px">
					<input class="easyui-numberbox" name="order" style="width:100%" data-options="label:'Urutan:',required:true">
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
  	$('#ismain').combobox({
  	    url:'ismain',
  	    valueField:'_id',
  	    textField:'title',
        setText:'title'
  	});
  	$('#dgGrid').datagrid({
  		minHeight:410,
    	maxHeight:520,
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
	$('#dialog-form').dialog('open').dialog('setTitle','Add New Menu');
	$('#ff').form('clear');
	url = 'saveMenu';
}

function editForm(){
	var row = $('#dgGrid').datagrid('getSelected');
		if (row){
			$('#dialog-form').dialog('open').dialog('setTitle','Edit Menu' + row.title);
			$('#ff').form('load',row);
			url = 'updateMenu?id='+row._id;
		}
}

function destroy(){
    var row = $('#dgGrid').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm','Are you sure you want to destroy this Menu ? '+ row.title,function(r){
            if (r){
                $.post('destroyMenu',{id:row._id},function(result){
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
        $.messager.confirm('Confirm','Are you sure you want to Aktif or Non Aktif ? '+ row.title,function(r){
            if (r){
                $.post('aktifMenu',{id:row._id},function(result){
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

</script>