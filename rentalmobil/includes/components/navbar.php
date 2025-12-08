<!DOCTYPE html>
<html lang="en">
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome for Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- Vendor CSS Files -->


  <!-- Template Main CSS File -->
 

  <!-- Custom LuxRental Styling -->
  <style>
    /* Luxury Gold Theme */
    .header {
      background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%) !important;
      border-bottom: 2px solid rgba(212, 175, 55, 0.2);
    }
    
    .sidebar {
      background: linear-gradient(180deg, #1a1a1a 0%, #0a0a0a 100%) !important;
      border-right: 1px solid rgba(212, 175, 55, 0.2);
    }
    
    .sidebar-nav .nav-link {
      color: #c0c0c0 !important;
      transition: all 0.3s ease;
      border: 1px solid rgba(212, 175, 55, 0.3) !important;
      border-radius: 8px;
      margin: 5px 10px;
      background: transparent !important;
    }
    
    .sidebar-nav .nav-link:hover {
      color: #0a0a0a !important;
      background: linear-gradient(135deg, #d4af37, #f7e98e) !important;
      border: 1px solid #d4af37 !important;
      transform: translateX(5px);
      box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }
    
    .sidebar-nav .nav-link:hover i {
      color: #0a0a0a !important;
    }
    
    .sidebar-nav .nav-link i {
      color: #d4af37;
      transition: all 0.3s ease;
    }
    
    .toggle-sidebar-btn {
      color: #d4af37 !important;
      font-size: 28px;
      transition: all 0.3s ease;
    }
    
    .toggle-sidebar-btn:hover {
      color: #f7e98e !important;
      transform: scale(1.1);
      cursor: pointer;
    }
    
    /* Remove all animations */
  </style>

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center" style="text-decoration: none;">
        <div style="background: linear-gradient(135deg, #d4af37, #f7e98e); padding: 10px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 10px; box-shadow: 0 4px 10px rgba(212, 175, 55, 0.3);">
          <i class="fas fa-crown" style="font-size: 26px; color: #0a0a0a;"></i>
        </div>
        <div class="d-none d-lg-block">
          <span style="color: #d4af37; font-weight: 700; font-size: 1.4rem; font-family: 'Playfair Display', serif; display: block; line-height: 1.2;">LuxRental</span>
          <span style="color: #888; font-size: 0.65rem; font-weight: 400;">Premium Car Experience</span>
        </div>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    

    

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <?php
    $role = $_SESSION['role'];

    switch ($role):
      case 'admin':
    ?>
      <!-- Menu Admin -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=tambah_mobil">
          <i class="bi bi-speedometer2"></i><span>Dashboard Admin</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=transaksi">
          <i class="bi bi-receipt"></i><span>Transaksi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=member_nonaktif">
          <i class="bi bi-person-x"></i><span>Nonaktif Member</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="includes/auth/logout.php">
          <i class="bi bi-box-arrow-left"></i><span>Logout</span>
        </a>
      </li>

    <?php
        break;
      case 'petugas':
    ?>
      <!-- Menu Petugas -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=petugas">
          <i class="bi bi-grid"></i><span>Dashboard Petugas</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=member_sewa">
            <i class="bi bi-people-fill"></i><span>Kelola Member</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=member_nonaktif">
          <i class="bi bi-person-x"></i><span>Nonaktif Member</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=tambah_mobil">
          <i class="bi bi-car-front-fill"></i><span>Kelola Mobil</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=transaksi">
          <i class="bi bi-receipt-cutoff"></i><span>Transaksi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="includes/auth/logout.php">
          <i class="bi bi-box-arrow-left"></i><span>Logout</span>
        </a>
      </li>

    <?php
        break;
      case 'member':
    ?>
      <!-- Menu User -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=member">
          <i class="bi bi-house-door"></i><span>Dashboard User</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=sewa_mobil">
          <i class="bi bi-car-front"></i><span>Sewa Mobil</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=bayar">
          <i class="bi bi-journal-text"></i><span>Transaksi Saya</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="includes/auth/logout.php">
          <i class="bi bi-box-arrow-left"></i><span>Logout</span>
        </a>
      </li>

    <?php
        break;
    endswitch;
    ?>

  </ul>
</aside>
<!-- End Sidebar -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>