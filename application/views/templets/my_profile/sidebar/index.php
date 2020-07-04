<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center nav-link disabled" href="#">
        <div class="sidebar-brand-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="sidebar-brand-text mx-3">WP-CI-Login-<?= $name_tittle; ?> </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- QUERY MENU -->
    <?php 
    # mengambil data dari session yang berada di kontrol Auth.php
    $role_id = $this->session->userdata('role_id');

    # mengabil data dengan mengabunkan beberapa table
    $querymenu =  "SELECT   user_menu.id, user_menu.menu
                    FROM    user_menu 
                    JOIN    user_access_menu 
                    ON      user_menu.id = user_access_menu.menu_id
                    WHERE   user_access_menu.role_id = '$role_id'
                ORDER BY    user_access_menu.menu_id 
                    ASC 
                    ";
    # jika data sudah dapat, ambil sebaris sesuai dari data session role_id
    $menu = $this->db->query($querymenu)->result_array();
    // var_dump($menu);
    // die;
    ?>

    <!-- LOOPING MENU -->
    <?php foreach ($menu as $m) : ?>
    <div class="sidebar-heading">
        <!-- mengabil data dari kolum atau fill menu yang berada di table user_menu -->
        <?= $m['menu'] ?>
    </div>

    <!-- SIAPKAN SUB-MENU SESUAI MENU-->
    <?php 
    # mengambil primarykey yang ada di table user_menu untuk di gabungkan
    # dengan primarykey user_sub_menu
    $menuid = $m['id'];

    # mengambil semua data dari table user_sub_menu dengan primarykey yang 
    # di ambil dari table user_menu 
    $querysubmenu = "SELECT *
                    FROM    user_sub_menu 
                    JOIN    user_menu 
                    ON      user_sub_menu.menu_id = user_menu.id
                    WHERE   user_sub_menu.menu_id = '$menuid'
                    AND     user_sub_menu.is_active = 1 
                    ";

    # selesai mencari data lalu di ambil data sesuai syntax sql di atas
    $submenu = $this->db->query($querysubmenu)->result_array();
    ?>

    <!-- Me-looping bagian-bagian menu untuk side bar -->
    <?php foreach ($submenu as $sm) : ?>

    <?php if ($sm['title'] != $tittle) : ?>
    <li class="nav-item ">
        <?php else : ?>
    <li class="nav-item active">
        <?php endif; ?>
        <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
            <i class="<?= $sm['icon']; ?>"></i>
            <span><?= $sm['title']; ?></span></a>
    </li>
    <?php endforeach; ?>

    <!-- Divider -->
    <hr class="sidebar-divider mt-3">

    <?php endforeach; ?>

    <!-- heading -->
    <!-- <div class="sidebar-heading">
        Administrator
    </div> -->


    <!-- Nav Item - Dashboard -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li> -->



    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        User
    </div> -->

    <!-- Nav Item - Charts -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="far fa-fw fa-user"></i>
            <span>My profile</span></a>
    </li> -->

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar - ->                                                                                                                                                      