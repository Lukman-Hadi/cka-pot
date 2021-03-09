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
            <a href="<?= base_url('admin');?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <?php 
            $menu = $this->menu_model->getMenus($this->session->userdata('posisi'));
            foreach ($menu->result() as $row) : 
            $submenu=$this->menu_model->getSubMenus($this->session->userdata('posisi'),$row->_id);
            if ($submenu->num_rows() > 0){ ?>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon <?= $row->icon;?>"></i>
                    <p>
                      <?= $row->title;?>
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right"><?= $submenu->num_rows();?></span>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <?php foreach ($submenu->result() as $sub) :?>
                      <li class="nav-item">
                          <a href="<?= base_url($sub->uri);?>" class="nav-link">
                            <i class="<?= $sub->icon;?> nav-icon"></i>
                            <p><?= $sub->title;?></p>
                          </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
              </li>
            <?php }else{ ?>
            <li class="nav-item">
              <a href="<?= base_url('admin/dashboard');?>" class="nav-link">
                <i class="nav-icon <?= $row->icon;?>"></i>
                <p><?= $row->title;?></p>
              </a>
            </li>
          <?php } endforeach;?>
		  <li class="nav-header">KUUK</li>
		  <?php if($this->session->posisi == 2 || $this->session->posisi == 1 || $this->session->posisi == 6){ ?>
			<?php if($this->session->posisi == 1 || $this->session->posisi == 6){ ?>
				<li class="nav-item">
					<a href="<?=base_url()?>admin/inputtagihan" class="nav-link">
						<i class="nav-icon fa fa-check-double"></i>
						<p>
							Input Penagihan
						</p>
					</a>
				</li>
				<?php }else{?>
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
					<a href="<?=base_url()?>admin/penagihanapprove" class="nav-link">
						<i class="nav-icon fa fa-check-double"></i>
						<p>
							Approval Penagihan
							<span class="badge badge-info right">2</span>
						</p>
					</a>
				</li>
				<?php }}?>
				<li class="nav-item">
					<a href="<?=base_url()?>admin/logout" class="nav-link">
						<i class="nav-icon fa fa-sign-out-alt"></i>
						<p>
							Logout
						</p>
					</a>
				</li>
        </ul>
    </nav> 
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>