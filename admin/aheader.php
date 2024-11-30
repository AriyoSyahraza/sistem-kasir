<?php


require 'koneksi.php';
$query = "SELECT username FROM user WHERE user_id = '{$_SESSION['user_id']}'"
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title></title>
  <meta
    content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    name="viewport" />
  <link
    rel="icon"
    href="../assets/img/kaiadmin/favicon.png"
    type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["../assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/plugins.min.css" />
  <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

  <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.7/css/buttons.dataTables.min.css">

</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar sidebar-style-2" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="index.html" class="logo">
            <img
              src="../assets/img/kaiadmin/logo_light.svg"
              alt="navbar brand"
              class="navbar-brand"
              height="20" />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          
          <ul class="nav nav-secondary">
            

            <li class="nav-section">
              <span class="sidebar-mini-icon">
                <i class="fa fa-ellipsis-h"></i>
              </span>
              <h2 class="text-section">Menu</h2>
            </li>
            <li class="nav-item 
            <?php if ($title == 'Dashboard') {
              echo 'active';
            } ?>">
              <a

                href="index.php"
                aria-expanded="true">
                <i class="fas fa-home"></i>
                <p>Dashboard</p>

              </a>
            </li>
            <li class="nav-item 
            <?php if ($title == 'Menu') {
              echo 'active';
            } ?>">
              <a

                href="menu.php"
                aria-expanded="true">
                <i class="fas fa-bars"></i>
                <p>Menu</p>

              </a>
            </li>
            <li class="nav-item 
            <?php if ($title == 'Pesanan') {
              echo 'active';
            } ?>">
              <a

                href="pesanan.php"
                aria-expanded="true">
                <i class="fas fa-shopping-cart"></i>
                <p>Pesanan</p>

              </a>
            </li>
            <li class="nav-item 
            <?php if ($title == 'Customer') {
              echo 'active';
            } ?>">
              <a

                href="customer.php"
                aria-expanded="true">
                <i class="fas fa-users"></i>
                <p>Customer</p>

              </a>
            </li>
            <li class="nav-item 
            <?php if ($title == 'Laporan Keuangan') {
              echo 'active';
            } ?>">
              <a

                href="laporan_keuangan.php"
                aria-expanded="true">
                <i class="fas fa-users"></i>
                <p>Laporan Keuangan</p>

              </a>
            </li>
            <li class="nav-item 
            <?php if ($title == 'Discount') {
              echo 'active';
            } ?>">
              <a

                href="discount.php"
                aria-expanded="true">
                <i class="fas fa-percentage"></i>
                <p>Discount</p>

              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img
                src="assets/img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <nav
          class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
          <div class="container-fluid">
            

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
              
              
              <li class="nav-item topbar-icon dropdown hidden-caret">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="notifDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false">
                  <i class="fa fa-bell"></i>
                  <span class="notification">4</span>
                </a>
                <ul
                  class="dropdown-menu notif-box animated fadeIn"
                  aria-labelledby="notifDropdown">
                  <li>
                    
                  </li>
                  <li>
                    
                    
                  </li>
                  <!-- <li>
                    <a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i>
                    </a>
                  </li> -->
                </ul>
              </li>
              

              <li class="nav-item topbar-user dropdown hidden-caret">
                <a
                  class="dropdown-toggle profile-pic"
                  data-bs-toggle="dropdown"
                  href="#"
                  aria-expanded="false">
                  <div class="avatar-sm">
                    <img
                      src="assets/img/profile.jpg"
                      alt="..."
                      class="avatar-img rounded-circle" />
                  </div>
                  <span class="profile-username">
                    <span class="op-7">Hi,</span>
                    <span class="fw-bold"><?= $_SESSION['username']; ?></span>
                  </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                  <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                      <div class="user-box">
                        <div class="avatar-lg">
                          <img
                            src="assets/img/profile.jpg"
                            alt="image profile"
                            class="avatar-img rounded" />
                        </div>
                        <div class="u-text">
                          <h4><?= $_SESSION['username']; ?></h4>
                          <p class="text-muted">hello@example.com</p>
                          
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Logout</a>
                    </li>
                  </div>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>

      <div class="container">
        <div class="page-inner">
        
          