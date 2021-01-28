<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="index3.html" class="brand-link">
		<img src="<?=base_url()?>assets/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">CKA Pot</span>
	</a>
	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?=base_url()?>assets/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block"><?= $this->session->userdata('nama');?></a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="<?=base_url()?>" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Users
							<i class="fas fa-angle-left right"></i>
							<span class="badge badge-info right">2</span>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?=base_url()?>admin/users" class="nav-link">
								<i class="far fa-user fa-xs nav-icon"></i>
								<p>Pegawai</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url()?>admin/posisi" class="nav-link">
								<i class="fas fa-user-shield nav-icon"></i>
								<p>Posisi</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-warehouse"></i>
						<p>
							Gudang
							<i class="fas fa-angle-left right"></i>
							<span class="badge badge-info right">2</span>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?=base_url()?>admin/barangMasuk" class="nav-link">
								<i class="fa fa-truck-loading nav-icon"></i>
								<p>Barang Masuk</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url()?>admin/barang" class="nav-link">
								<i class="fas fa-boxes nav-icon"></i>
								<p>Barang</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-cash-register"></i>
						<p>
							Transaksi
							<i class="fas fa-angle-left right"></i>
							<span class="badge badge-info right">2</span>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?=base_url()?>admin/penjualan" class="nav-link">
								<i class="fa fa-file-invoice-dollar fa-xs nav-icon"></i>
								<p>Penjualan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url()?>admin/penagihan" class="nav-link">
								<i class="fas fa-receipt nav-icon"></i>
								<p>Penagihan</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-file-contract"></i>
						<p>
							Laporan
							<i class="fas fa-angle-left right"></i>
							<span class="badge badge-info right">2</span>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="fa fa-file-invoice-dollar fa-xs nav-icon"></i>
								<p>Laporan Penjualan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="pages/layout/top-nav-sidebar.html" class="nav-link">
								<i class="fas fa-receipt nav-icon"></i>
								<p>Laporan Penagihan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="pages/layout/top-nav-sidebar.html" class="nav-link">
								<i class="fas fa-hand-holding-usd nav-icon"></i>
								<p>Laporan Pendapatan</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-header">Approval</li>
				<li class="nav-item">
					<a href="<?=base_url()?>admin/penjualanapprove" class="nav-link">
						<i class="nav-icon fa fa-check-double"></i>
						<p>
							Approval Penjualan
							<span class="badge badge-info right">2</span>
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="pages/calendar.html" class="nav-link">
						<i class="nav-icon fa fa-check-double"></i>
						<p>
							Approval Penagihan
							<span class="badge badge-info right">2</span>
						</p>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>