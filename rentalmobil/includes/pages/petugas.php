<?php
if(!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("Location: ../auth/login.php");
    exit;
}

// Koneksi database
$koneksi = new mysqli("localhost", "root", "root", "luxrental");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query data mobil
$query_tersedia = "SELECT COUNT(*) as total FROM tbl_mobil WHERE status='tersedia'";
$result_tersedia = $koneksi->query($query_tersedia);
$tersedia = $result_tersedia->fetch_assoc()['total'];

$query_sewa = "SELECT COUNT(*) as total FROM tbl_mobil WHERE status='disewa'";
$result_sewa = $koneksi->query($query_sewa);
$sewa = $result_sewa->fetch_assoc()['total'];

$query_total_mobil = "SELECT COUNT(*) as total FROM tbl_mobil";
$result_total = $koneksi->query($query_total_mobil);
$total_mobil = $result_total->fetch_assoc()['total'];

// Query transaksi hari ini
$query_transaksi = "SELECT COUNT(*) as total FROM tbl_transaksi WHERE DATE(tgl_ambil) = CURDATE()";
$result_transaksi = $koneksi->query($query_transaksi);
$transaksi_hari_ini = $result_transaksi ? $result_transaksi->fetch_assoc()['total'] : 0;

// Query pengembalian hari ini  
$query_kembali = "SELECT COUNT(*) as total FROM tbl_kembali WHERE DATE(tgl_kembali) = CURDATE()";
$result_kembali = $koneksi->query($query_kembali);
$kembali_hari_ini = $result_kembali ? $result_kembali->fetch_assoc()['total'] : 0;

// Query total pendapatan bulan ini
$query_pendapatan = "SELECT SUM(total) as pendapatan FROM tbl_transaksi WHERE MONTH(tgl_ambil) = MONTH(CURDATE()) AND YEAR(tgl_ambil) = YEAR(CURDATE()) AND (status='aprove' OR status='ambil' OR status='kembali')";
$result_pendapatan = $koneksi->query($query_pendapatan);
if($result_pendapatan) {
    $row_pendapatan = $result_pendapatan->fetch_assoc();
    $pendapatan_bulan = $row_pendapatan['pendapatan'] ?? 0;
} else {
    $pendapatan_bulan = 0;
}

// Query member aktif
$query_member = "SELECT COUNT(*) as total FROM tbl_member WHERE is_active = 1";
$result_member = $koneksi->query($query_member);
$member_aktif = $result_member ? $result_member->fetch_assoc()['total'] : 0;

// Query transaksi pending approval
$query_pending = "SELECT COUNT(*) as total FROM tbl_transaksi WHERE status='booking'";
$result_pending = $koneksi->query($query_pending);
$pending_approval = $result_pending ? $result_pending->fetch_assoc()['total'] : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Petugas - LuxRental</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
  <style>
    :root {
      --luxury-black: #0a0a0a;
      --luxury-gray: #1a1a1a;
      --luxury-gold: #d4af37;
      --luxury-gold-light: #f7e98e;
      --luxury-silver: #c0c0c0;
      --luxury-white: #ffffff;
    }
    
    * {
      margin: 0; 
      padding: 0; 
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }
    
    body { 
      background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
      min-height: 100vh;
      padding: 30px 20px;
      color: var(--luxury-silver);
    }
    
    .container {
      max-width: 1400px;
      margin: 0 auto;
    }
    
    /* Page Header Styling */
    .page-header {
      text-align: center;
      margin-bottom: 40px;
      position: relative;
      z-index: 1;
    }
    
    .page-header h1 {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      font-weight: 700;
      color: var(--luxury-gold);
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
      text-shadow: 0 2px 20px rgba(212, 175, 55, 0.4);
    }
    
    .page-header h1 i {
      font-size: 2.5rem;
      color: var(--luxury-gold-light);
    }
    
    .page-header p {
      font-size: 1.1rem;
      color: var(--luxury-silver);
      max-width: 600px;
      margin: 0 auto;
    }
    
    .welcome-badge {
      display: inline-block;
      background: linear-gradient(135deg, var(--luxury-gold) 0%, #c9a532 100%);
      color: var(--luxury-black);
      padding: 8px 20px;
      border-radius: 25px;
      font-size: 0.9rem;
      font-weight: 600;
      margin-top: 10px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    /* Cards Styling */
    .cards { 
      display: grid; 
      grid-template-columns: repeat(4, 1fr); 
      gap: 25px; 
      margin-bottom: 40px;
    }
    
    .card { 
      background: rgba(26, 26, 26, 0.95);
      backdrop-filter: blur(10px);
      border: 2px solid var(--luxury-gold);
      border-radius: 20px;
      padding: 30px 25px;
      box-shadow: 0 10px 40px rgba(212, 175, 55, 0.1);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }
    
    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--luxury-gold), var(--luxury-gold-light), var(--luxury-gold));
    }
    
    .card:hover {
      transform: translateY(-12px) scale(1.03);
      box-shadow: 0 20px 50px rgba(212, 175, 55, 0.3);
      border-color: var(--luxury-gold-light);
    }
    
    .card-icon {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      font-size: 2rem;
      color: var(--luxury-black);
      background: linear-gradient(135deg, var(--luxury-gold) 0%, #c9a532 100%);
      box-shadow: 0 8px 20px rgba(212, 175, 55, 0.4);
      transition: all 0.3s ease;
    }
    
    .card:hover .card-icon {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 12px 30px rgba(212, 175, 55, 0.6);
    }
    
    .card h3 { 
      font-size: 0.95rem; 
      color: var(--luxury-gold-light);
      margin-bottom: 15px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1.5px;
    }
    
    .card p { 
      font-size: 3rem; 
      font-family: 'Playfair Display', serif;
      font-weight: 700; 
      color: var(--luxury-gold);
      margin-bottom: 10px;
      text-shadow: 0 2px 10px rgba(212, 175, 55, 0.3);
    }
    
    .card .card-desc {
      font-size: 0.85rem;
      color: var(--luxury-silver);
      margin-top: 8px;
    }
    
    .stats-trend {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: 10px;
      font-size: 0.85rem;
      font-weight: 600;
      padding: 6px 15px;
      border-radius: 20px;
      background: rgba(212, 175, 55, 0.1);
    }
    
    .trend-up {
      color: #2ecc71;
    }
    
    .trend-down {
      color: #e74c3c;
    }
    
    .stats-trend i {
      margin-right: 5px;
    }
    
    /* Additional Info Section */
    .additional-info {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 25px;
      margin-top: 40px;
    }
    
    .info-box {
      background: rgba(26, 26, 26, 0.95);
      backdrop-filter: blur(10px);
      border: 2px solid rgba(212, 175, 55, 0.3);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 40px rgba(212, 175, 55, 0.1);
      transition: all 0.3s ease;
    }
    
    .info-box:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 50px rgba(212, 175, 55, 0.2);
      border-color: var(--luxury-gold);
    }
    
    .info-box h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.8rem;
      color: var(--luxury-gold);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .info-box h2 i {
      color: var(--luxury-gold-light);
    }
    
    .info-box p {
      color: var(--luxury-silver);
      line-height: 1.8;
      margin-bottom: 20px;
      font-size: 1rem;
    }
    
    .info-list {
      list-style-type: none;
    }
    
    .info-list li {
      padding: 15px;
      border-bottom: 1px solid rgba(212, 175, 55, 0.2);
      display: flex;
      align-items: center;
      gap: 12px;
      transition: all 0.3s ease;
      border-radius: 8px;
    }
    
    .info-list li:hover {
      background: rgba(212, 175, 55, 0.05);
      padding-left: 20px;
    }
    
    .info-list li:last-child {
      border-bottom: none;
    }
    
    .info-list li i {
      color: var(--luxury-gold);
      width: 25px;
      font-size: 1.1rem;
    }
    
    .info-list li span {
      color: var(--luxury-silver);
      flex: 1;
    }
    
    /* Responsive */
    @media (max-width: 1200px) { 
      .cards { 
        grid-template-columns: repeat(2, 1fr); 
      } 
      
      .additional-info {
        grid-template-columns: 1fr;
      }
    }
    
    @media (max-width: 768px) { 
      .cards { 
        grid-template-columns: 1fr; 
        gap: 20px;
      }
      
      .header h1 {
        font-size: 2rem;
      }
      
      .card {
        padding: 25px 20px;
      }
      
      .card p {
        font-size: 2.2rem;
      }
    }
    
    @media (max-width: 480px) {
      body {
        padding: 20px 15px;
      }
      
      .header {
        padding: 20px 15px;
      }
      
      .header h1 {
        font-size: 1.8rem;
      }
      
      .card-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
      }
    }
    
    /* Animation */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .card {
      animation: fadeInUp 0.5s ease forwards;
    }
    
    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }
  </style>
</head>
<body>
  <div class="container">
    <!-- Page Header -->
    <div class="page-header">
      <h1><i class="fas fa-crown"></i> Dashboard Petugas LuxRental <i class="fas fa-crown"></i></h1>
      <p>Selamat datang, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Petugas'; ?>!</p>
      <span class="welcome-badge"><i class="fas fa-shield-alt"></i> Panel Kontrol Premium</span>
    </div>

    
    <!-- Cards -->
    <div class="cards">
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-car-side"></i>
        </div>
        <h3>Mobil Tersedia</h3>
        <p><?php echo $tersedia; ?></p>
        <span class="card-desc">Siap disewakan</span>
      </div>
      
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-road"></i>
        </div>
        <h3>Sedang Disewa</h3>
        <p><?php echo $sewa; ?></p>
        <span class="card-desc">Dalam perjalanan</span>
      </div>
      
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-warehouse"></i>
        </div>
        <h3>Total Armada</h3>
        <p><?php echo $total_mobil; ?></p>
        <span class="card-desc">Kendaraan premium</span>
      </div>
      
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-users"></i>
        </div>
        <h3>Member Aktif</h3>
        <p><?php echo $member_aktif; ?></p>
        <span class="card-desc">Pelanggan setia</span>
      </div>
    </div>
    
    <!-- Second Row Cards -->
    <div class="cards">
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-file-invoice-dollar"></i>
        </div>
        <h3>Transaksi Hari Ini</h3>
        <p><?php echo $transaksi_hari_ini; ?></p>
        <span class="card-desc">Rental baru</span>
      </div>
      
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-undo-alt"></i>
        </div>
        <h3>Pengembalian Hari Ini</h3>
        <p><?php echo $kembali_hari_ini; ?></p>
        <span class="card-desc">Kendaraan kembali</span>
      </div>
      
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-clock"></i>
        </div>
        <h3>Menunggu Approval</h3>
        <p><?php echo $pending_approval; ?></p>
        <span class="card-desc">Perlu ditinjau</span>
      </div>
      
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-money-bill-wave"></i>
        </div>
        <h3>Pendapatan Bulan Ini</h3>
        <p style="font-size: 1.5rem;">Rp <?php echo number_format($pendapatan_bulan, 0, ',', '.'); ?></p>
        <span class="card-desc">Total revenue</span>
      </div>
    </div>
    
    <!-- Additional Info Section -->
    <div class="additional-info">
      <div class="info-box">
        <h2><i class="fas fa-cog"></i> Fitur Sistem</h2>
        <p>Kelola bisnis rental dengan fitur lengkap dan profesional:</p>
        <ul class="info-list">
          <li><i class="fas fa-check-circle"></i> <span>Manajemen armada kendaraan premium</span></li>
          <li><i class="fas fa-check-circle"></i> <span>Pencatatan transaksi real-time</span></li>
          <li><i class="fas fa-check-circle"></i> <span>Sistem approval otomatis</span></li>
          <li><i class="fas fa-check-circle"></i> <span>Laporan keuangan detail</span></li>
          <li><i class="fas fa-check-circle"></i> <span>Tracking pengembalian kendaraan</span></li>
          <li><i class="fas fa-check-circle"></i> <span>Database member terintegrasi</span></li>
        </ul>
      </div>
      
      <div class="info-box">
        <h2><i class="fas fa-chart-line"></i> Performa Hari Ini</h2>
        <p>Statistik operasional rental mobil saat ini:</p>
        <ul class="info-list">
          <li><i class="fas fa-percentage"></i> <span>Tingkat Okupansi: <?php echo $total_mobil > 0 ? round(($sewa/$total_mobil)*100, 1) : 0; ?>%</span></li>
          <li><i class="fas fa-car-side"></i> <span>Kendaraan Siap: <?php echo $tersedia; ?> unit</span></li>
          <li><i class="fas fa-hourglass-half"></i> <span>Pending Approval: <?php echo $pending_approval; ?> transaksi</span></li>
          <li><i class="fas fa-calendar-check"></i> <span>Pengembalian Hari Ini: <?php echo $kembali_hari_ini; ?> unit</span></li>
          <li><i class="fas fa-users-cog"></i> <span>Total Member: <?php echo $member_aktif; ?> orang</span></li>
          <li><i class="fas fa-trophy"></i> <span>Status: Premium Service Active</span></li>
        </ul>
      </div>
    </div>
  </div>

  <script>
    // Animasi counter
    function animateCounter(element, target) {
      let current = 0;
      const increment = target / 50;
      const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
          element.textContent = target;
          clearInterval(timer);
        } else {
          element.textContent = Math.floor(current);
        }
      }, 20);
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Animate all counters
      const cards = document.querySelectorAll('.card');
      cards.forEach(card => {
        const counter = card.querySelector('p');
        if (counter && !counter.textContent.includes('Rp')) {
          const target = parseInt(counter.textContent);
          if (!isNaN(target)) {
            counter.textContent = '0';
            setTimeout(() => animateCounter(counter, target), 300);
          }
        }
      });

      // Card hover effects
      cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-12px) scale(1.03)';
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0) scale(1)';
        });
      });

      // Info box animations
      const infoBoxes = document.querySelectorAll('.info-box');
      infoBoxes.forEach((box, index) => {
        box.style.opacity = '0';
        box.style.transform = 'translateY(30px)';
        setTimeout(() => {
          box.style.transition = 'all 0.6s ease';
          box.style.opacity = '1';
          box.style.transform = 'translateY(0)';
        }, 500 + (index * 200));
      });
    });
  </script>
</body>
</html>