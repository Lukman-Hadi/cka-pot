<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-globe"></i> CKA POT
                                <small class="float-right"><?php echo tgl_indo(date("Y-m-d",time())); ?></small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            No Faktur : <strong><?php echo $detail->no_faktur; ?></strong>
                            <br>
                            <b><?php echo $detail->nama_pembeli; ?></b><br>
                            <b>Tanggal Pembelian:</b> <?= tgl_indo($detail->tgl_transaksi); ?><br>
                            <b>No Telfon:</b> <?= $detail->no_telp; ?>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                        <strong>Alamat</strong>
                        <address>
                        <?= $detail->alamat; ?>
                        </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            Barang: <strong><?= $detail->nama_barang; ?></strong> <br>
                            Total: <strong>Rp <?= number_format($detail->total,2,',','.'); ?></strong> <br>
                            Jatuh Tempo Setiap Tanggal: <strong><?= $detail->tgl_tempo; ?></strong>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Kwitansi</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Total Bayar</th>
                                        <th>Sisa Hutang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($detail->status_penjualan ==0){?>
                                    <tr>
                                        <td>1</td>
                                        <td><?= $detail->no_faktur; ?></td>
                                        <td><?= tgl_indo($detail->tgl_transaksi); ?></td>
                                        <td><?= number_format($detail->total,2,',','.'); ?></td>
                                        <td>Lunas</td>
                                    </tr>
                                    <?php } ?>
                                    <?php
                                        $i=1;
                                        $hutang = $detail->total;
                                        $bayar = 0;
                                        foreach($detailtagih as $tagih) {
                                    ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $tagih->kode_bayar; ?></td>
                                        <td><?= tgl_indo($tagih->tgl_bayar); ?></td>
                                        <td>Rp <?= number_format($tagih->total_bayar,0,',','.'); ?></td>
                                        <td>Rp <?= number_format(($hutang-$tagih->total_bayar),0,',','.'); ?></td>
                                    </tr>
                                    <?php
                                        $hutang = $hutang-$tagih->total_bayar;
                                        $bayar += $tagih->total_bayar;
                                        $i++;
                                        } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-6">
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <!-- <p class="lead">Amount Due 2/22/2014</p> -->

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Total Pembayaran:</th>
                                        <?php if(isset($tagih)){
                                            echo "<td>Rp ".number_format($bayar,0,',','.')."</td>";
                                        }else{
                                            echo "<td>Rp ".number_format($detail->total,2,',','.')."</td>";
                                        }?>
                                    </tr>
                                    <tr>
                                        <th>Tunggakan</th>
                                        <td>Rp <?= number_format($tunggakan - $bayar,0,',','.'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Hutang:</th>
                                        <?php if(isset($tagih)){
                                            echo "<td>Rp <?= number_format(($hutang-$tagih->total_bayar),0,',','.'); ?></td>";
                                        }else{
                                            echo "<td>LUNAS</td>";
                                        }?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                            <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                                Payment
                            </button>
                            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-download"></i> Generate PDF
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>