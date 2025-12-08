<?php
// Tidak perlu session_start() di sini karena hanya form tampilan
if (isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - LuxRental</title>
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
    /* Custom Scrollbar - Main Page */
    ::-webkit-scrollbar {
      width: 12px;
    }
    
    ::-webkit-scrollbar-track {
      background: #0a0a0a;
      border-left: 1px solid rgba(212, 175, 55, 0.1);
    }
    
    ::-webkit-scrollbar-thumb {
      background: linear-gradient(180deg, #d4af37, #b8941f);
      border-radius: 6px;
      border: 2px solid #0a0a0a;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(180deg, #f7e98e, #d4af37);
      border: 2px solid #1a1a1a;
    }
    
    /* Custom Scrollbar for Textarea */
    textarea::-webkit-scrollbar {
      width: 8px;
    }
    
    textarea::-webkit-scrollbar-track {
      background: #1a1a1a;
      border-radius: 4px;
    }
    
    textarea::-webkit-scrollbar-thumb {
      background: #d4af37;
      border-radius: 4px;
    }
    
    textarea::-webkit-scrollbar-thumb:hover {
      background: #f7e98e;
    }
    
    /* Firefox */
    * {
      scrollbar-width: thin;
      scrollbar-color: #d4af37 #0a0a0a;
    }
    
    textarea {
      scrollbar-width: thin;
      scrollbar-color: #d4af37 #1a1a1a;
    }

    /* Smooth Scrolling */
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body class="bg-luxury-black text-white font-modern min-h-screen py-12 relative">
  <!-- Background Pattern -->
  <div class="fixed inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23d4af37" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20 pointer-events-none"></div>
  
  <div class="container mx-auto px-6 relative z-10">
    <div class="max-w-2xl mx-auto">
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

      <!-- Register Card -->
      <div class="bg-luxury-gray rounded-2xl shadow-2xl border border-luxury-gold/20 overflow-hidden">
        <div class="p-8">
          <div class="text-center mb-6">
            <h2 class="text-3xl font-luxury font-bold text-luxury-gold mb-2">Create Account</h2>
            <p class="text-gray-400">Join the luxury car experience</p>
          </div>

          <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-4 text-center">
              <?= htmlspecialchars($_GET['error']); ?>
            </div>
          <?php endif; ?>

          <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-4 text-center">
              <?= htmlspecialchars($_GET['success']); ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="../process/proses_register.php" enctype="multipart/form-data" class="space-y-5">
            
            <!-- Grid Layout for Form Fields -->
            <div class="grid md:grid-cols-2 gap-5">
              <!-- NIK -->
              <div>
                <label for="nik" class="block text-luxury-gold font-medium mb-2">
                  <i class="fas fa-id-card mr-2"></i>Member ID
                </label>
                <input 
                  type="number" 
                  name="nik" 
                  id="nik" 
                  max="9999999999"
                  min="1"
                  oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);"
                  class="w-full px-4 py-3 bg-luxury-black border border-luxury-gold/30 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-luxury-gold transition-colors"
                  placeholder="Enter your Member ID (max 10 digits)"
                  required
                >
                <div id="cek_nik" class="mt-1 text-sm"></div>
                <p class="text-xs text-gray-400 mt-1"><i class="fas fa-info-circle mr-1"></i>Use a unique number (max 10 digits)</p>
              </div>

              <!-- Nama -->
              <div>
                <label for="nama" class="block text-luxury-gold font-medium mb-2">
                  <i class="fas fa-user mr-2"></i>Full Name
                </label>
                <input 
                  type="text" 
                  name="nama" 
                  id="nama"
                  class="w-full px-4 py-3 bg-luxury-black border border-luxury-gold/30 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-luxury-gold transition-colors"
                  placeholder="Enter your name"
                  required
                >
              </div>

              <!-- Jenis Kelamin -->
              <div>
                <label for="jk" class="block text-luxury-gold font-medium mb-2">
                  <i class="fas fa-venus-mars mr-2"></i>Gender
                </label>
                <select 
                  name="jk" 
                  id="jk"
                  class="w-full px-4 py-3 bg-luxury-black border border-luxury-gold/30 rounded-lg text-white focus:outline-none focus:border-luxury-gold transition-colors"
                  required
                >
                  <option value="">-- Select Gender --</option>
                  <option value="L">Male</option>
                  <option value="P">Female</option>
                </select>
              </div>

              <!-- Telepon -->
              <div>
                <label for="telp" class="block text-luxury-gold font-medium mb-2">
                  <i class="fas fa-phone mr-2"></i>Phone Number
                </label>
                <input 
                  type="text" 
                  name="telp" 
                  id="telp"
                  class="w-full px-4 py-3 bg-luxury-black border border-luxury-gold/30 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-luxury-gold transition-colors"
                  placeholder="Enter your phone"
                  required
                >
              </div>
            </div>

            <!-- Alamat -->
            <div>
              <label for="alamat" class="block text-luxury-gold font-medium mb-2">
                <i class="fas fa-map-marker-alt mr-2"></i>Address
              </label>
              <textarea 
                name="alamat" 
                id="alamat"
                rows="3"
                class="w-full px-4 py-3 bg-luxury-black border border-luxury-gold/30 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-luxury-gold transition-colors resize-none"
                placeholder="Enter your address"
                required
              ></textarea>
            </div>

            <!-- Grid for Username and Password -->
            <div class="grid md:grid-cols-2 gap-5">
              <!-- Username -->
              <div>
                <label for="user" class="block text-luxury-gold font-medium mb-2">
                  <i class="fas fa-at mr-2"></i>Username
                </label>
                <input 
                  type="text" 
                  name="user" 
                  id="user"
                  class="w-full px-4 py-3 bg-luxury-black border border-luxury-gold/30 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-luxury-gold transition-colors"
                  placeholder="Choose a username"
                  required
                >
                <div id="cek_user" class="mt-1 text-sm"></div>
              </div>

              <!-- Password -->
              <div>
                <label for="pass" class="block text-luxury-gold font-medium mb-2">
                  <i class="fas fa-lock mr-2"></i>Password
                </label>
                <input 
                  type="password" 
                  name="pass" 
                  id="pass"
                  class="w-full px-4 py-3 bg-luxury-black border border-luxury-gold/30 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-luxury-gold transition-colors"
                  placeholder="Create a password"
                  required
                >
              </div>
            </div>

            <!-- Foto -->
            <div>
              <label for="foto" class="block text-luxury-gold font-medium mb-2">
                <i class="fas fa-camera mr-2"></i>Profile Photo (Optional)
              </label>
              <input 
                type="file" 
                name="foto" 
                id="foto"
                accept="image/*"
                class="w-full px-4 py-3 bg-luxury-black border border-luxury-gold/30 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-luxury-gold file:text-luxury-black file:font-medium hover:file:bg-luxury-gold-light transition-colors"
              >
            </div>

            <!-- Submit Button -->
            <button 
              type="submit" 
              class="w-full bg-gradient-to-r from-luxury-gold to-luxury-gold-light text-luxury-black font-semibold py-3 rounded-lg hover:shadow-xl hover:shadow-luxury-gold/30 transform hover:scale-105 transition-all duration-300"
            >
              <i class="fas fa-user-plus mr-2"></i>Create Account
            </button>

            <div class="text-center">
              <p class="text-gray-400">
                Already have an account? 
                <a href="login.php" class="text-luxury-gold hover:text-luxury-gold-light font-medium transition-colors">Login</a>
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

  <!-- jQuery for AJAX validation -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function(){
      // Add animation on load
      const card = document.querySelector('.bg-luxury-gray');
      card.style.opacity = '0';
      card.style.transform = 'translateY(20px)';
      
      setTimeout(() => {
        card.style.transition = 'all 0.6s ease';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, 100);

      // Validasi NIK - Maksimal 10 digit
      $("#nik").on("input keyup", function(){
        var nik = $(this).val();
        var nikLength = nik.toString().length;
        
        // Cek panjang NIK
        if(nikLength > 10){
          $("#cek_nik").html("<span class='text-red-400 font-medium'><i class='fas fa-exclamation-triangle mr-1'></i>NIK maksimal 10 digit!</span>");
          $(this).addClass('border-red-500');
          $(this).removeClass('border-luxury-gold/30');
          // Potong nilai jika lebih dari 10 digit
          $(this).val(nik.toString().substring(0, 10));
          return;
        } else {
          $(this).removeClass('border-red-500');
          $(this).addClass('border-luxury-gold/30');
        }
        
        // Cek ketersediaan NIK jika ada input
        if(nikLength > 0 && nikLength <= 10){
          // Cek apakah NIK sudah terdaftar via AJAX
          $.ajax({
            url: "cek_nik.php",
            method: "POST",
            data: {nik: nik},
            success: function(data){
              $("#cek_nik").html(data);
            }
          });
        } else if(nikLength === 0) {
          $("#cek_nik").html("");
        }
      });

      // Cek Username
      $("#user").on("keyup change", function(){
        var user = $(this).val();
        if(user.length > 0){
          $.ajax({
            url: "cek_user.php",
            method: "POST",
            data: {user: user},
            success: function(data){
              $("#cek_user").html(data);
            }
          });
        } else {
          $("#cek_user").html("");
        }
      });
    });
  </script>
</body>
</html>
