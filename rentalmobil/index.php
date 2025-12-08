<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

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

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <?php include 'includes/components/navbar.php'; ?>

  <!-- ======= Main Content Area ======= -->
  <main id="main" class="main">

    <?php
    if (isset($_GET['page'])) {
      $page = $_GET['page'];

      switch ($page) {
        case 'admin':
          include 'includes/pages/admin.php';
          break;
        case 'petugas':
          include 'includes/pages/petugas.php';
          break;
        case 'transaksi':
          include 'includes/pages/transaksi.php';
          break;
        case 'tambah_mobil':
          include 'includes/pages/tambah_mobil.php';
          break;
        case 'edit_mobil':
          include 'includes/pages/edit_mobil.php';
          break;
        case 'sewa_mobil':
          include 'includes/pages/sewa_mobil.php';
          break;
        case 'member':
          include 'includes/pages/member.php';
          break;
        case 'bayar':
          include 'includes/pages/bayar.php';
          break;
        case 'member_sewa':
          include 'includes/pages/member_sewa.php';
          break;
        case 'member_nonaktif':
          include 'includes/pages/member_nonaktif.php';
          break;

        default:
          echo "<div class='alert alert-danger text-center'><h5>Halaman tidak ditemukan!</h5></div>";
          break;
      }
    } else {
      include 'home.php';
    }
    ?>

  </main><!-- End Main -->

  <!-- Optional Footer -->


</body>
</html>