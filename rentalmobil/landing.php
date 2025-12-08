<?php
include __DIR__ . '/config/koneksi.php';
// Mengambil data mobil dari database
try {
    $stmt = $pdo->query("SELECT * FROM tbl_mobil WHERE status = 'tersedia' ORDER BY tahun DESC LIMIT 6");
    $mobil_list = $stmt->fetchAll();
} catch(PDOException $e) {
    $mobil_list = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'LuxRental - Premium Car Rental Service'; ?></title>
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: #0a0a0a;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #d4af37, #b8941f);
            border-radius: 6px;
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
<body class="bg-luxury-black text-white font-modern">
    <!-- Header & Navigation -->
    <header class="bg-luxury-gray shadow-2xl sticky top-0 z-50 border-b border-luxury-gold/20">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light p-2 rounded-lg">
                        <i class="fas fa-crown text-luxury-black text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-luxury font-bold text-luxury-gold">LuxRental</h1>
                        <p class="text-xs text-gray-300">Premium Car Experience</p>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-luxury-gold font-medium hover:text-luxury-gold-light transition-colors">Home</a>
                    <a href="#cars" class="text-gray-300 hover:text-luxury-gold transition-colors">Our Fleet</a>
                    <a href="#features" class="text-gray-300 hover:text-luxury-gold transition-colors">Services</a>
                    <a href="#contact" class="text-gray-300 hover:text-luxury-gold transition-colors">Contact</a>
                    <div class="flex space-x-3">
                        <a href="includes/auth/login.php" class="bg-transparent border border-luxury-gold text-luxury-gold px-4 py-2 rounded-lg hover:bg-luxury-gold hover:text-luxury-black transition-all">
                            Login
                        </a>
                        <a href="includes/auth/register.php" class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light text-luxury-black px-4 py-2 rounded-lg font-medium hover:shadow-lg hover:shadow-luxury-gold/25 transition-all">
                            Register
                        </a>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button class="text-luxury-gold">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen flex items-center">
        <!-- Background with overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-luxury-black via-luxury-gray to-luxury-black opacity-95"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23d4af37" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-6xl md:text-7xl font-luxury font-bold mb-6 bg-gradient-to-r from-luxury-gold via-luxury-gold-light to-luxury-gold bg-clip-text text-transparent">
                    Luxury Beyond
                    <span class="block">Ordinary</span>
                </h2>
                <p class="text-xl md:text-2xl text-gray-300 mb-8 leading-relaxed">
                    Experience the pinnacle of automotive excellence with our premium fleet of luxury vehicles.
                    <span class="text-luxury-gold">Where elegance meets performance.</span>
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    <a href="includes/auth/login.php" class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light text-luxury-black px-8 py-4 rounded-xl font-semibold text-lg hover:shadow-2xl hover:shadow-luxury-gold/30 transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Book Now
                    </a>
                    <a href="#cars" class="border-2 border-luxury-gold text-luxury-gold px-8 py-4 rounded-xl font-semibold text-lg hover:bg-luxury-gold hover:text-luxury-black transition-all duration-300">
                        <i class="fas fa-car mr-2"></i>
                        Explore Fleet
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-3xl mx-auto">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-luxury-gold mb-2">500+</div>
                        <div class="text-gray-400">Happy Clients</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-luxury-gold mb-2">50+</div>
                        <div class="text-gray-400">Luxury Cars</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-luxury-gold mb-2">24/7</div>
                        <div class="text-gray-400">Support</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-luxury-gold mb-2">5★</div>
                        <div class="text-gray-400">Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Fleet Section -->
    <section id="cars" class="py-20 bg-gradient-to-b from-luxury-black to-luxury-gray">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h3 class="text-4xl md:text-5xl font-luxury font-bold mb-4 text-luxury-gold">Our Premium Fleet</h3>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Discover our collection of meticulously maintained luxury vehicles, each offering unparalleled comfort and performance.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($mobil_list as $mobil): ?>
                <div class="bg-luxury-gray rounded-2xl overflow-hidden shadow-2xl border border-luxury-gold/20 hover:border-luxury-gold/50 transition-all duration-300 group">
                    <div class="h-64 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                        <?php
                        $foto_path = "uploads/mobil/" . htmlspecialchars($mobil['foto']);
                        if (!file_exists($foto_path) || empty($mobil['foto'])) {
                            echo '<i class="fas fa-car text-6xl text-luxury-gold opacity-50"></i>';
                        } else {
                            echo '<img src="' . $foto_path . '" alt="' . htmlspecialchars($mobil['brand'] . ' ' . $mobil['type']) . '" class="w-full h-full object-cover">';
                        }
                        ?>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-xl font-semibold text-luxury-gold"><?php echo htmlspecialchars($mobil['brand'] . ' ' . $mobil['type']); ?></h4>
                            <span class="bg-luxury-gold text-luxury-black px-3 py-1 rounded-full text-sm font-medium"><?php echo htmlspecialchars($mobil['tahun']); ?></span>
                        </div>
                        <p class="text-gray-300 mb-4">Nopol: <?php echo htmlspecialchars($mobil['nopol']); ?></p>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-luxury-gold">
                                Rp <?php echo number_format($mobil['harga'], 0, ',', '.'); ?><span class="text-sm text-gray-400">/day</span>
                            </div>
                            <a href="includes/auth/login.php" class="bg-luxury-gold text-luxury-black px-4 py-2 rounded-lg font-medium hover:bg-luxury-gold-light transition-colors">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-luxury-black">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h3 class="text-4xl md:text-5xl font-luxury font-bold mb-4 text-luxury-gold">Why Choose LuxRental?</h3>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    We provide more than just car rental - we deliver an unparalleled luxury experience.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center p-8 bg-luxury-gray rounded-2xl border border-luxury-gold/20 hover:border-luxury-gold/50 transition-all duration-300">
                    <div class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light p-4 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-crown text-2xl text-luxury-black"></i>
                    </div>
                    <h4 class="text-2xl font-semibold mb-4 text-luxury-gold">Premium Fleet</h4>
                    <p class="text-gray-300 leading-relaxed">
                        Our carefully curated collection features only the finest luxury vehicles from prestigious brands, maintained to perfection.
                    </p>
                </div>

                <div class="text-center p-8 bg-luxury-gray rounded-2xl border border-luxury-gold/20 hover:border-luxury-gold/50 transition-all duration-300">
                    <div class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light p-4 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-user-tie text-2xl text-luxury-black"></i>
                    </div>
                    <h4 class="text-2xl font-semibold mb-4 text-luxury-gold">Professional Chauffeurs</h4>
                    <p class="text-gray-300 leading-relaxed">
                        Our professionally trained chauffeurs ensure your journey is not just comfortable, but truly memorable.
                    </p>
                </div>

                <div class="text-center p-8 bg-luxury-gray rounded-2xl border border-luxury-gold/20 hover:border-luxury-gold/50 transition-all duration-300">
                    <div class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light p-4 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-clock text-2xl text-luxury-black"></i>
                    </div>
                    <h4 class="text-2xl font-semibold mb-4 text-luxury-gold">24/7 Concierge</h4>
                    <p class="text-gray-300 leading-relaxed">
                        Round-the-clock support ensures your needs are met anytime, anywhere. Luxury never sleeps.
                    </p>
                </div>

                <div class="text-center p-8 bg-luxury-gray rounded-2xl border border-luxury-gold/20 hover:border-luxury-gold/50 transition-all duration-300">
                    <div class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light p-4 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-shield-alt text-2xl text-luxury-black"></i>
                    </div>
                    <h4 class="text-2xl font-semibold mb-4 text-luxury-gold">Full Insurance</h4>
                    <p class="text-gray-300 leading-relaxed">
                        Comprehensive insurance coverage gives you peace of mind for every mile of your luxury journey.
                    </p>
                </div>

                <div class="text-center p-8 bg-luxury-gray rounded-2xl border border-luxury-gold/20 hover:border-luxury-gold/50 transition-all duration-300">
                    <div class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light p-4 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-2xl text-luxury-black"></i>
                    </div>
                    <h4 class="text-2xl font-semibold mb-4 text-luxury-gold">Delivery Service</h4>
                    <p class="text-gray-300 leading-relaxed">
                        We bring luxury to your doorstep with our complimentary delivery and pickup service.
                    </p>
                </div>

                <div class="text-center p-8 bg-luxury-gray rounded-2xl border border-luxury-gold/20 hover:border-luxury-gold/50 transition-all duration-300">
                    <div class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light p-4 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-star text-2xl text-luxury-black"></i>
                    </div>
                    <h4 class="text-2xl font-semibold mb-4 text-luxury-gold">VIP Treatment</h4>
                    <p class="text-gray-300 leading-relaxed">
                        Every client receives VIP treatment with personalized service and exclusive benefits.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-luxury-gray via-luxury-black to-luxury-gray">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-4xl md:text-5xl font-luxury font-bold mb-6 text-luxury-gold">Ready for the Ultimate Drive?</h3>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Experience luxury like never before. Book your premium vehicle today and elevate your journey to extraordinary heights.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="includes/auth/login.php" class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light text-luxury-black px-8 py-4 rounded-xl font-semibold text-lg hover:shadow-2xl hover:shadow-luxury-gold/30 transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Book Now
                </a>
                <a href="#contact" class="border-2 border-luxury-gold text-luxury-gold px-8 py-4 rounded-xl font-semibold text-lg hover:bg-luxury-gold hover:text-luxury-black transition-all duration-300">
                    <i class="fas fa-phone mr-2"></i>
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-luxury-gray border-t border-luxury-gold/20 py-16">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-gradient-to-r from-luxury-gold to-luxury-gold-light p-2 rounded-lg">
                            <i class="fas fa-crown text-luxury-black text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-luxury font-bold text-luxury-gold">LuxRental</h1>
                            <p class="text-xs text-gray-300">Premium Car Experience</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        LuxRental is your gateway to luxury automotive experiences. We provide premium vehicles and unparalleled service for discerning clients who demand excellence.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-luxury-gold text-luxury-black p-3 rounded-lg hover:bg-luxury-gold-light transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-luxury-gold text-luxury-black p-3 rounded-lg hover:bg-luxury-gold-light transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-luxury-gold text-luxury-black p-3 rounded-lg hover:bg-luxury-gold-light transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-luxury-gold text-luxury-black p-3 rounded-lg hover:bg-luxury-gold-light transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-xl font-semibold mb-6 text-luxury-gold">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#home" class="text-gray-300 hover:text-luxury-gold transition-colors">Home</a></li>
                        <li><a href="#cars" class="text-gray-300 hover:text-luxury-gold transition-colors">Our Fleet</a></li>
                        <li><a href="#features" class="text-gray-300 hover:text-luxury-gold transition-colors">Services</a></li>
                        <li><a href="about.php" class="text-gray-300 hover:text-luxury-gold transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-luxury-gold transition-colors">Terms & Conditions</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-luxury-gold transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-xl font-semibold mb-6 text-luxury-gold">Contact Us</h4>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-map-marker-alt text-luxury-gold"></i>
                            <span class="text-gray-300">Jakarta, Indonesia</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-luxury-gold"></i>
                            <span class="text-gray-300">+62 123 456 7890</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-luxury-gold"></i>
                            <span class="text-gray-300">info@luxrental.com</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-clock text-luxury-gold"></i>
                            <span class="text-gray-400">24/7 Available</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-luxury-gold/20 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; 2025 LuxRental. All rights reserved. | Crafted with <i class="fas fa-heart text-luxury-gold"></i> for luxury enthusiasts.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
            