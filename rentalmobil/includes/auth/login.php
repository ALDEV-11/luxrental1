<?php
session_start();

// Jika sudah login, redirect ke halaman sesuai role
if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'petugas') {
        header("Location: index.php");
    } else {
        header("Location: member.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - LuxRental</title>
  <link href="assets/img/favicon.png" rel="icon">
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'luxury-black': '#0a0a0a',
            'luxury-gray': '#1a1a1a',
            'luxury-gold': '#d4af37',
            'luxury-gold-light': '#f7e98e',
            'luxury-gold-dark': '#b8941f'
          },
          fontFamily: {
            'luxury': ['Playfair Display', 'serif'],
            'modern': ['Inter', 'sans-serif']
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
    }
    
    ::-webkit-scrollbar-track {
      background: #0a0a0a;
    }
    
    ::-webkit-scrollbar-thumb {
      background: linear-gradient(180deg, #d4af37, #b8941f);
      border-radius: 5px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(180deg, #f7e98e, #d4af37);
    }
    
    /* Firefox */
    * {
      scrollbar-width: thin;
      scrollbar-color: #d4af37 #0a0a0a;
    }
  </style>
</head>
<body class="bg-luxury-black text-white font-modern min-h-screen flex items-center justify-center relative overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23d4af37" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
  
  <div class="container mx-auto px-6 relative z-10">
    <div class="max-w-md mx-auto">
      <!-- Logo -->
      <div class="text-center mb-8">
        <a href="landing.php" class="inline-flex items-center space-x-3 mb-2">
          <div class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light p-2 rounded-lg">
            <i class="fas fa-crown text-luxury-black text-3xl"></i>
          </div>
          <div class="text-left">
            <h1 class="text-3xl font-luxury font-bold text-luxury-gold">LuxRental</h1>
            <p class="text-xs text-gray-300">Premium Car Experience</p>
          </div>
        </a>
      </div>

      <!-- Login Card -->
      <div class="bg-luxury-gray rounded-2xl shadow-2xl border border-luxury-gold/20 overflow-hidden">
        <div class="p-8">
          <div class="text-center mb-6">
            <h2 class="text-3xl font-luxury font-bold text-luxury-gold mb-2">Welcome Back</h2>
            <p class="text-gray-400">Login to your account</p>
          </div>

          <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-4 text-center">
              <?= htmlspecialchars($_SESSION['error']); ?>
            </div>
            <?php unset($_SESSION['error']); ?>
          <?php endif; ?>

          <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-4 text-center">
              <?= htmlspecialchars($_SESSION['success']); ?>
            </div>
            <?php unset($_SESSION['success']); ?>
          <?php endif; ?>

          <form method="POST" action="../process/proses_login.php" class="space-y-6">
            <div>
              <label for="yourUsername" class="block text-luxury-gold font-medium mb-2">
                <i class="fas fa-user mr-2"></i>Username
              </label>
              <input 
                type="text" 
                name="user" 
                id="yourUsername" 
                class="w-full px-4 py-3 bg-luxury-black border border-luxury-gold/30 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-luxury-gold transition-colors"
                placeholder="Enter your username"
                required
              >
            </div>

            <div>
              <label for="yourPassword" class="block text-luxury-gold font-medium mb-2">
                <i class="fas fa-lock mr-2"></i>Password
              </label>
              <input 
                type="password" 
                name="pass" 
                id="yourPassword" 
                class="w-full px-4 py-3 bg-luxury-black border border-luxury-gold/30 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-luxury-gold transition-colors"
                placeholder="Enter your password"
                required
              >
            </div>

            <button 
              type="submit" 
              class="w-full bg-gradient-to-r from-luxury-gold to-luxury-gold-light text-luxury-black font-semibold py-3 rounded-lg hover:shadow-xl hover:shadow-luxury-gold/30 transform hover:scale-105 transition-all duration-300"
            >
              <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>

            <div class="text-center">
              <p class="text-gray-400">
                Don't have an account? 
                <a href="register.php" class="text-luxury-gold hover:text-luxury-gold-light font-medium transition-colors">Register now</a>
              </p>
            </div>

            <div class="text-center pt-4 border-t border-luxury-gold/20">
              <a href="../../landing.php" class="text-gray-400 hover:text-luxury-gold transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Home
              </a>
            </div>
          </form>
        </div>
      </div>

      <!-- Footer -->
      <div class="text-center mt-8 text-gray-400">
        <p>Crafted with <i class="fas fa-heart text-luxury-gold"></i> for luxury enthusiasts</p>
      </div>
    </div>
  </div>

  <script>
    // Add animation on load
    document.addEventListener('DOMContentLoaded', function() {
      const card = document.querySelector('.bg-luxury-gray');
      card.style.opacity = '0';
      card.style.transform = 'translateY(20px)';
      
      setTimeout(() => {
        card.style.transition = 'all 0.6s ease';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, 100);
    });
  </script>
</body>
</html>