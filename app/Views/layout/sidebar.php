 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="<?= base_url() ?>index3.html" class="brand-link">
         <img src="<?= base_url() ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">AdminLTE 3</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="<?= base_url() ?>dist/img/user2-160x160.jpg" class="img-circle elevation-2 mt-2" alt="User Image">
             </div>
             <div class="info">
                 <a href="#" class="d-block"><?= user()->username ?></a>
                 <a href="<?= site_url('logout') ?>" class="text-sm text-danger">Logout</a>

             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item">
                     <a href="<?= site_url('/') ?>" class="nav-link <?= ($sidebar == 'home') ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-home"></i>
                         <p>
                             Home
                         </p>
                     </a>
                 </li>
                 <?php if (in_groups('Administrator')) : ?>
                     <li class="nav-header">ADMINISTRATOR</li>

                     <?php if ($sidebar == 'kategori') : ?>
                         <li class="nav-item menu-open active">
                         <?php elseif ($sidebar == 'satuan') : ?>
                         <li class="nav-item menu-open active">
                         <?php elseif ($sidebar == 'costcentre') : ?>
                         <li class="nav-item menu-open active">
                         <?php elseif ($sidebar == 'barang') : ?>
                         <li class="nav-item menu-open active">
                         <?php else : ?>
                         <li class="nav-item menu-close">
                         <?php endif; ?>
                         <a href="#" class="nav-link">
                             <i class="nav-icon fas fa-tachometer-alt"></i>
                             <p>
                                 Master
                                 <i class="right fas fa-angle-left"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="<?= site_url('barang') ?>" class="nav-link <?= ($sidebar == 'barang') ? 'active' : '' ?>">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Barang</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="<?= site_url('kategori') ?>" class="nav-link <?= ($sidebar == 'kategori') ? 'active' : '' ?>">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Kategori</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="<?= site_url('satuan') ?>" class="nav-link <?= ($sidebar == 'satuan') ? 'active' : '' ?>">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Satuan</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="<?= site_url('costcentre') ?>" class="nav-link <?= ($sidebar == 'costcentre') ? 'active' : '' ?>">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Cost Centre</p>
                                 </a>
                             </li>
                         </ul>
                         </li>

                         <?php if ($sidebar == 'barangmasuk') : ?>
                             <li class="nav-item menu-open">
                             <?php elseif ($sidebar == 'barangkeluar') : ?>
                             <li class="nav-item menu-open">
                             <?php else : ?>
                             <li class="nav-item menu-close">
                             <?php endif; ?>
                             <a href="#" class="nav-link">
                                 <i class="nav-icon fas fa-copy"></i>
                                 <p>
                                     Transaksi
                                     <i class="fas fa-angle-left right"></i>
                                 </p>
                             </a>
                             <ul class="nav nav-treeview">
                                 <li class="nav-item">
                                     <a href="<?= site_url('barangmasuk') ?>" class="nav-link <?= ($sidebar == 'barangmasuk') ? 'active' : '' ?>">
                                         <i class="far fa-circle nav-icon"></i>
                                         <p>Barang Masuk</p>
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a href="<?= site_url('barangkeluar') ?>" class="nav-link <?= ($sidebar == 'barangkeluar') ? 'active' : '' ?>">
                                         <i class="far fa-circle nav-icon"></i>
                                         <p>Barang Keluar</p>
                                     </a>
                                 </li>
                             </ul>
                             </li>
                         <?php endif; ?>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>