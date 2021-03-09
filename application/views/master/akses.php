<section class="content-header"></section>
<div class="col-12">
    <div class="card">
    <!-- BEGIN card-body -->
        <div class="card-body">
            
            <div class="p-b-10 ">
            <a href="<?php echo base_url('admin/level') ?>" class="btn btn-warning"> Kembali</a>
            </div>
                <table id="mytable" class="table table-striped table-td-valign-middle table-bordered bg-white">
                <thead>
                    <tr>
                        <th width="1%" class="no-sort">#</th>
                        <th>Nama Modul</th>
                        <th width="10%" class="no-sort text-center">Checklist</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                foreach ($menu as $m) {
                    echo "<tr>
                        <td>$no</td>
                        <td>$m->title</td>
                        <td class='checkbox-col' align='center'>
                            <div class='checkbox-inline'><input type='checkbox' ".  checked_akses($this->uri->segment(3), $m->_id)." onClick='kasi_akses($m->_id)' id='table_checkbox_$no'>
                                <label for='table_checkbox_$no'></label>
                            </div>
                        </td>
                        </tr>";
                    $no++;
                };
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    function kasi_akses(id_menu){
        //alert(id_menu);
        var id_menu = id_menu;
        var level = '<?php echo $this->uri->segment(3); ?>';
        //alert(level);
        $.ajax({
            url:"<?php echo base_url()?>admin/kasi_akses_ajax",
            data:"id_menu=" + id_menu + "&level="+ level ,
            success: function(html)
            { 
                //load();
                //alert('sukses');
            }
        });
    }    
</script>