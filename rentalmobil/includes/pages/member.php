<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxRental - Member Dashboard</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
        :root {
            --luxury-black: #0a0a0a;
            --luxury-gray: #1a1a1a;
            --luxury-gold: #d4af37;
            --luxury-gold-light: #f7e98e;
            --luxury-gold-dark: #b8941f;
            --luxury-silver: #c0c0c0;
            --card-bg: rgba(255, 255, 255, 0.98);
            --shadow: 0 10px 30px rgba(212, 175, 55, 0.15);
            --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--luxury-black) 0%, var(--luxury-gray) 100%);
            color: var(--luxury-silver);
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }
        
        /* Welcome Section */
        .welcome-section {
            text-align: center;
            padding: 60px 40px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.95) 0%, rgba(247, 233, 142, 0.95) 100%);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.3);
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }
        
        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .welcome-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .crown-icon {
            font-size: 48px;
            color: var(--luxury-black);
            margin-bottom: 20px;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .welcome-section h1 {
            font-size: 48px;
            color: var(--luxury-black);
            margin-bottom: 20px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }
        
        .welcome-section p {
            font-size: 18px;
            color: var(--luxury-black);
            max-width: 800px;
            margin: 0 auto 35px;
            opacity: 0.85;
            line-height: 1.8;
            position: relative;
            z-index: 1;
        }
        
        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .dashboard-card {
            background: rgba(10, 10, 10, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 2px solid var(--luxury-gold);
        }
        
        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--luxury-gold), var(--luxury-gold-light));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.6s ease;
        }
        
        .dashboard-card:hover::before {
            transform: scaleX(1);
        }
        
        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.4);
            border-color: var(--luxury-gold-light);
            background: rgba(26, 26, 26, 0.8);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            background: transparent;
        }
        
        .card-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--luxury-black);
            font-size: 28px;
            margin-right: 20px;
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.4);
            flex-shrink: 0;
        }
        
        .card-title {
            font-size: 26px;
            color: var(--luxury-gold);
            font-weight: 700;
            font-family: 'Playfair Display', serif;
        }
        
        .card-content {
            color: var(--luxury-silver);
            line-height: 1.8;
            opacity: 0.95;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .card-content p {
            color: var(--luxury-silver);
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
            background: rgba(212, 175, 55, 0.1);
            backdrop-filter: blur(5px);
            border-radius: 15px;
            transition: var(--transition);
            border: 1px solid var(--luxury-gold);
        }
        
        .stat-item:hover {
            background: rgba(212, 175, 55, 0.2);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
            border-color: var(--luxury-gold-light);
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: var(--luxury-gold);
            margin-bottom: 8px;
            font-family: 'Playfair Display', serif;
        }
        
        .stat-label {
            font-size: 14px;
            color: var(--luxury-silver);
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 25px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 16px 38px;
            border-radius: 50px;
            border: none;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            position: relative;
            z-index: 1;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--luxury-black) 0%, var(--luxury-gray) 100%);
            color: var(--luxury-gold);
            border: 2px solid var(--luxury-gold);
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--luxury-black);
            color: var(--luxury-black);
        }
        
        .btn:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 12px 30px rgba(212, 175, 55, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            color: var(--luxury-black);
        }
        
        .btn-outline:hover {
            background: var(--luxury-black);
            color: var(--luxury-gold);
        }
        
        /* Feature List */
        .feature-list {
            list-style-type: none;
            margin-top: 20px;
        }
        
        .feature-item {
            padding: 15px 0;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--luxury-silver);
        }
        
        .feature-item:last-child {
            border-bottom: none;
        }
        
        .feature-item i {
            color: var(--luxury-gold);
            font-size: 20px;
        }
        
        /* Notification & Activity Items */
        .notification-item, .activity-item {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
        }
        
        .notification-item:last-child, .activity-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .notification-title, .activity-title {
            font-weight: 700;
            color: var(--luxury-gold);
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Playfair Display', serif;
        }
        
        .notification-desc, .activity-desc {
            font-size: 15px;
            color: var(--luxury-silver);
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .activity-time {
            font-size: 13px;
            color: var(--luxury-gold);
            font-weight: 600;
        }
        
        footer {
            text-align: center;
            padding: 40px 25px;
            color: var(--luxury-silver);
            font-size: 14px;
            margin-top: 50px;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
        }
        
        footer p {
            margin: 0;
        }
        
        footer .crown-footer {
            color: var(--luxury-gold);
            margin: 0 5px;
        }
        
        /* Info Card */
        .info-card {
            background: rgba(212, 175, 55, 0.1);
            backdrop-filter: blur(5px);
            border: 1px solid var(--luxury-gold);
            border-left: 4px solid var(--luxury-gold);
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
        }
        
        .info-card h4 {
            color: var(--luxury-gold);
            font-family: 'Playfair Display', serif;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .info-card p {
            color: var(--luxury-silver);
            line-height: 1.6;
            margin: 0;
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--luxury-gray);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--luxury-gold) 0%, var(--luxury-gold-dark) 100%);
            border-radius: 10px;
            border: 2px solid var(--luxury-gray);
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--luxury-gold-light) 0%, var(--luxury-gold) 100%);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                align-items: stretch;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .welcome-section {
                padding: 40px 25px;
            }
            
            .welcome-section h1 {
                font-size: 36px;
            }
            
            .welcome-section p {
                font-size: 16px;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .card-icon {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }
            
            .card-title {
                font-size: 22px;
            }
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .welcome-section {
            animation: fadeIn 0.8s ease-out;
        }
        
        .dashboard-card {
            animation: slideIn 0.6s ease-out forwards;
            opacity: 0;
        }
        
        .dashboard-card:nth-child(1) { animation-delay: 0.1s; }
        .dashboard-card:nth-child(2) { animation-delay: 0.2s; }
        .dashboard-card:nth-child(3) { animation-delay: 0.3s; }
        .dashboard-card:nth-child(4) { animation-delay: 0.4s; }
        .dashboard-card:nth-child(5) { animation-delay: 0.5s; }
        .dashboard-card:nth-child(6) { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <div class="container">
        <section class="welcome-section">
            <i class="fas fa-crown crown-icon"></i>
            <h1>Selamat Datang di LuxRental</h1>
            <p>Terima kasih telah mempercayai LuxRental sebagai mitra perjalanan eksklusif Anda. Nikmati pengalaman menyewa kendaraan mewah dengan layanan premium dan kenyamanan yang tak tertandingi.</p>
            <div class="action-buttons">
              <a href="index.php?page=sewa_mobil" class="btn btn-primary"><i class="fas fa-car"></i>Sewa Mobil Mewah</a>
              <a href="#" class="btn btn-outline"><i class="fas fa-receipt"></i>Lihat Transaksi</a>
            </div>
        </section>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-car-side"></i>
                    </div>
                    <h3 class="card-title">Armada Mewah</h3>
                </div>
                <div class="card-content">
                    <p>Koleksi kendaraan premium kami siap menemani perjalanan Anda dengan gaya dan kenyamanan maksimal.</p>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">50+</div>
                            <div class="stat-label">Mobil Mewah</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">15</div>
                            <div class="stat-label">Brand Premium</div>
                        </div>
                    </div>
                    <div class="info-card">
                        <h4><i class="fas fa-star"></i> Tersedia Sekarang</h4>
                        <p>Mercedes-Benz, BMW, Audi, Range Rover, dan lebih banyak lagi kendaraan eksklusif menanti Anda.</p>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="card-title">Jaminan & Asuransi</h3>
                </div>
                <div class="card-content">
                    <p>Setiap penyewaan dilindungi dengan asuransi komprehensif dan jaminan kualitas terbaik untuk ketenangan pikiran Anda.</p>
                    <ul class="feature-list">
                        <li class="feature-item">
                            <i class="fas fa-check-circle"></i> Asuransi All Risk
                        </li>
                        <li class="feature-item">
                            <i class="fas fa-check-circle"></i> Layanan 24/7
                        </li>
                        <li class="feature-item">
                            <i class="fas fa-check-circle"></i> Roadside Assistance
                        </li>
                        <li class="feature-item">
                            <i class="fas fa-check-circle"></i> Garansi Mobil Bersih
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h3 class="card-title">Member Premium</h3>
                </div>
                <div class="card-content">
                    <p>Nikmati privilege eksklusif sebagai member LuxRental dengan berbagai keuntungan istimewa:</p>
                    <ul class="feature-list">
                        <li class="feature-item">
                            <i class="fas fa-gem"></i> Diskon Hingga 20%
                        </li>
                        <li class="feature-item">
                            <i class="fas fa-gem"></i> Prioritas Booking
                        </li>
                        <li class="feature-item">
                            <i class="fas fa-gem"></i> Free Upgrade Kelas
                        </li>
                        <li class="feature-item">
                            <i class="fas fa-gem"></i> Concierge Service
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <h3 class="card-title">Layanan Khusus</h3>
                </div>
                <div class="card-content">
                    <div class="notification-item">
                        <div class="notification-title">
                            <span><i class="fas fa-user-tie"></i> Supir Profesional</span>
                        </div>
                        <div class="notification-desc">Layanan supir berpengalaman tersedia untuk kenyamanan perjalanan Anda dengan tarif khusus member.</div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-title">
                            <span><i class="fas fa-map-marked-alt"></i> Antar Jemput</span>
                        </div>
                        <div class="notification-desc">Gratis antar jemput ke bandara atau hotel untuk penyewaan minimal 3 hari.</div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-title">
                            <span><i class="fas fa-spa"></i> Detailing Service</span>
                        </div>
                        <div class="notification-desc">Layanan pembersihan dan perawatan mobil premium sebelum penggunaan.</div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-percent"></i>
                    </div>
                    <h3 class="card-title">Promo Spesial</h3>
                </div>
                <div class="card-content">
                    <div class="activity-item">
                        <div class="activity-title">
                            <span><i class="fas fa-gift"></i> Weekend Luxury</span>
                            <span class="activity-time">Hingga 31 Okt</span>
                        </div>
                        <div class="activity-desc">Diskon 25% untuk penyewaan Jumat-Minggu. Nikmati akhir pekan dengan gaya!</div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-title">
                            <span><i class="fas fa-calendar-check"></i> Long Term Deal</span>
                            <span class="activity-time">Promo Bulanan</span>
                        </div>
                        <div class="activity-desc">Sewa 7 hari, bayar 5 hari. Hemat hingga 30% untuk rental jangka panjang.</div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-title">
                            <span><i class="fas fa-star"></i> First Time Bonus</span>
                            <span class="activity-time">Member Baru</span>
                        </div>
                        <div class="activity-desc">Cashback 15% untuk penyewaan pertama Anda sebagai member LuxRental.</div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="card-title">Dukungan Member</h3>
                </div>
                <div class="card-content">
                    <p>Tim customer service kami siap membantu Anda 24/7 untuk pengalaman rental yang sempurna.</p>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">24/7</div>
                            <div class="stat-label">Customer Care</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><5 Min</div>
                            <div class="stat-label">Response Time</div>
                        </div>
                    </div>
                    <div class="info-card">
                        <h4><i class="fas fa-phone-alt"></i> Hubungi Kami</h4>
                        <p>WhatsApp: +62 812-3456-7890<br>Email: vip@luxrental.com</p>
                    </div>
                </div>
            </div>
        </div>
        
        <footer>
            <p>© 2025 LuxRental <i class="fas fa-crown crown-footer"></i> Premium Car Rental Service. All rights reserved.</p>
            <p style="margin-top: 10px; opacity: 0.7;">Elegance in Every Journey</p>
        </footer>
    </div>
</body>
</html>