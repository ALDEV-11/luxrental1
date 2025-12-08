# 🚗 LuxRental - Premium Car Rental System

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.0+-06B6D4?style=flat&logo=tailwindcss&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

Sistem manajemen rental mobil premium dengan fitur lengkap untuk admin, petugas, dan member. Dibangun dengan PHP native dan MySQL, menggunakan design modern dengan TailwindCSS.

---

## 📸 Screenshots

### Landing Page
Halaman utama dengan tampilan luxury dan modern, menampilkan daftar mobil tersedia.

### Dashboard
Dashboard khusus untuk setiap role (Admin, Petugas, Member) dengan fitur yang berbeda.

### Transaction Management
Sistem transaksi lengkap dengan tracking status sewa, pembayaran, dan pengembalian.

---

## ✨ Features

### 🔐 Multi-Role Authentication
- **Admin**: Full access untuk kelola semua data
- **Petugas**: Kelola member, mobil, dan transaksi
- **Member**: Sewa mobil dan lihat transaksi pribadi

### 👥 Member Management
- Register member baru dengan upload foto
- Aktivasi/Nonaktifkan member
- Validasi NIK dan username unique
- Password encryption dengan bcrypt

### 🚘 Vehicle Management
- CRUD mobil lengkap
- Upload foto mobil
- Filter by status (tersedia/tersewa)
- Detail spesifikasi mobil

### 💰 Transaction System
- Booking mobil dengan tanggal sewa
- Konfirmasi sewa oleh petugas
- Proses pembayaran bertahap
- Status tracking real-time
- Sistem denda otomatis untuk keterlambatan

### 📊 Reporting
- Riwayat transaksi per member
- Laporan pembayaran
- Status sewa aktif

---

## 🛠️ Tech Stack

### Backend
- **PHP 7.4+** - Server-side scripting
- **MySQL 8.0+** - Database management
- **PDO** - Database abstraction layer
- **Session Management** - User authentication

### Frontend
- **TailwindCSS 3.0+** - Modern utility-first CSS
- **Font Awesome 6.4** - Icon library
- **Google Fonts** - Playfair Display & Inter
- **Vanilla JavaScript** - DOM manipulation

### Development Tools
- **MAMP** - Local development server
- **phpMyAdmin** - Database management
- **VS Code** - Code editor

---

## 📁 Project Structure

```
rentalmobil/
├── config/                     # Configuration files
│   ├── koneksi.php            # Database connection
│   └── paths.php              # Path constants & helpers
│
├── includes/                   # Core application
│   ├── auth/                  # Authentication
│   │   ├── login.php
│   │   ├── register.php
│   │   └── logout.php
│   │
│   ├── pages/                 # Main pages
│   │   ├── admin.php
│   │   ├── petugas.php
│   │   ├── member.php
│   │   ├── tambah_mobil.php
│   │   ├── edit_mobil.php
│   │   ├── member_sewa.php
│   │   ├── member_nonaktif.php
│   │   ├── transaksi.php
│   │   ├── bayar.php
│   │   └── sewa_mobil.php
│   │
│   ├── process/               # Backend logic
│   │   ├── proses_login.php
│   │   ├── proses_register.php
│   │   ├── proses_sewa.php
│   │   ├── proses_bayar.php
│   │   ├── proses_kembali.php
│   │   ├── proses_approve.php
│   │   └── ... (20+ files)
│   │
│   └── components/            # Reusable UI
│       └── navbar.php
│
├── assets/                    # Static assets
│   ├── css/
│   ├── js/
│   ├── img/
│   └── vendor/
│
├── uploads/                   # User uploads
│   └── mobil/                # Car images
│
├── backup/                    # Archived files
│
├── index.php                  # Main router
├── landing.php                # Public landing page
├── rental1.sql               # Database schema
│
├── README.md                  # This file
├── FOLDER_STRUCTURE.md       # Detailed structure docs
└── CHANGELOG_FOLDER_STRUCTURE.md
```

---

## 🚀 Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 8.0 or higher
- MAMP/XAMPP/WAMP or similar local server
- Web browser (Chrome, Firefox, Safari)

### Step 1: Clone Repository
```bash
git clone https://github.com/yourusername/luxrental.git
cd luxrental
```

### Step 2: Setup Database
1. Start your local server (MAMP/XAMPP)
2. Open phpMyAdmin: `http://localhost:8888/phpMyAdmin` (or port 80)
3. Create new database: `luxrental`
4. Import SQL file: `rental1.sql`

### Step 3: Configure Database Connection
Edit `config/koneksi.php`:
```php
<?php
$host = 'localhost';
$dbname = 'luxrental';
$user = 'root';           // Your MySQL username
$pass = 'root';           // Your MySQL password
```

### Step 4: Set Permissions
```bash
chmod 755 rentalmobil/
chmod 755 rentalmobil/*/ -R
chmod 644 rentalmobil/*.php -R
chmod 777 rentalmobil/uploads/ -R
```

### Step 5: Access Application
Open in browser:
```
http://localhost:8888/rentalmobil/landing.php
```

---

## 👤 Default Users

### Admin
- **Username**: `admin`
- **Password**: `admin`

### Petugas
- **Username**: `petugas`
- **Password**: `admin`



> ⚠️ **Note**: Change these credentials after first login!

---

## 📖 Usage Guide

### For Members (Customers)

#### 1. Register Account
- Click "Register" on landing page
- Fill in personal information (NIK, Name, Phone, etc.)
- Upload profile photo
- Submit registration

#### 2. Login
- Use your username/NIK and password
- Access member dashboard

#### 3. Rent a Car
- Browse available cars in "Sewa Mobil"
- Select desired car
- Choose rental dates
- Submit booking (status: pending)

#### 4. Payment Process
- Wait for petugas to confirm booking
- After confirmation, pay the amount due
- Upload payment proof if required
- Complete payment

#### 5. Return Car
- Return car on scheduled date
- Petugas will process return
- Pay any additional fees (late charges, damage)

### For Petugas (Staff)

#### 1. Manage Members
- View all registered members
- Activate/Deactivate member accounts
- View member details and history

#### 2. Manage Cars
- Add new cars with photos and specs
- Edit car information
- Delete cars from inventory
- Update car status (available/rented)

#### 3. Process Transactions
- View all pending bookings
- Approve or reject rental requests
- Process car pickups
- Handle car returns
- Calculate and add late charges

### For Admin

#### Full Access
- All petugas features
- System configuration
- User management
- Complete data access

---

## 🗄️ Database Schema

### Main Tables

#### `tbl_user`
```sql
- user (VARCHAR) PK
- pass (VARCHAR) - bcrypt hashed
- lvl (ENUM: 'admin', 'petugas')
```

#### `tbl_member`
```sql
- nik (VARCHAR) PK
- nama (VARCHAR)
- jk (ENUM: 'L', 'P')
- telp (VARCHAR)
- alamat (TEXT)
- user (VARCHAR) UNIQUE
- pass (VARCHAR) - bcrypt hashed
- foto (VARCHAR)
- is_active (TINYINT) DEFAULT 1
```

#### `tbl_mobil`
```sql
- nopol (VARCHAR) PK
- merk (VARCHAR)
- model (VARCHAR)
- tahun (YEAR)
- warna (VARCHAR)
- harga (DECIMAL)
- status (ENUM: 'tersedia', 'tersewa')
- foto (VARCHAR)
```

#### `tbl_transaksi`
```sql
- id_transaksi (INT) PK AUTO_INCREMENT
- nik (VARCHAR) FK -> tbl_member
- nopol (VARCHAR) FK -> tbl_mobil
- tgl_sewa (DATE)
- tgl_kembali (DATE)
- tgl_kembali_actual (DATE) NULLABLE
- total_biaya (DECIMAL)
- status (ENUM: 'pending', 'approved', 'ambil', 'kembali', 'selesai', 'rejected')
- created_at TIMESTAMP
```

#### `tbl_bayar`
```sql
- id_bayar (INT) PK AUTO_INCREMENT
- id_transaksi (INT) FK -> tbl_transaksi
- jumlah (DECIMAL)
- tgl_bayar (TIMESTAMP)
- keterangan (TEXT)
```

#### `tbl_kembali`
```sql
- id_kembali (INT) PK AUTO_INCREMENT
- id_transaksi (INT) FK -> tbl_transaksi
- tgl_kembali_actual (DATE)
- denda (DECIMAL)
- keterangan (TEXT)
```

---

## 🔒 Security Features

### Password Security
- Bcrypt hashing with cost factor 10
- Password verification on login
- No plain text password storage

### Session Management
- Secure session handling
- Role-based access control (RBAC)
- Session timeout on logout
- Auto-redirect if not authenticated

### Input Validation
- Prepared statements (PDO) to prevent SQL injection
- HTML special chars encoding for XSS prevention
- File upload validation (type, size)
- NIK and username uniqueness check

### File Upload Security
- Restricted file types (images only)
- File size limitation
- Unique filename generation (timestamp prefix)
- Secure upload directory (777 permissions with .htaccess)

---

## 🎨 Customization

### Change Theme Colors
Edit TailwindCSS config in `landing.php` or page templates:
```javascript
tailwind.config = {
  theme: {
    extend: {
      colors: {
        'luxury-black': '#0a0a0a',
        'luxury-gray': '#1a1a1a',
        'luxury-gold': '#d4af37',
        'luxury-gold-light': '#f7e98e'
      }
    }
  }
}
```

### Modify Logo
Replace logo in navbar (`includes/components/navbar.php`):
```html
<img src="assets/img/logo.png" alt="LuxRental" class="h-10">
```

### Change Landing Page Content
Edit `landing.php` to customize:
- Hero section text
- Features list
- Footer information
- Contact details

---

## 🐛 Troubleshooting

### Database Connection Error
**Problem**: "Koneksi ke database gagal"
**Solution**: 
- Check MySQL is running
- Verify credentials in `config/koneksi.php`
- Ensure database `luxrental` exists

### Upload Failed
**Problem**: Files not uploading
**Solution**:
```bash
chmod 777 uploads/
chmod 777 uploads/mobil/
```

### Session Not Working
**Problem**: Login doesn't persist
**Solution**:
- Check PHP session settings
- Ensure cookies are enabled in browser
- Clear browser cache

### Page Not Found (404)
**Problem**: Links broken after folder restructure
**Solution**:
- Check all paths use `__DIR__` for relative paths
- Verify `index.php` includes correct file paths
- Review `FOLDER_STRUCTURE.md` for correct structure

---

## 📚 API Documentation

### Authentication Endpoints

#### Login
**File**: `includes/process/proses_login.php`
**Method**: POST
**Parameters**:
- `user` (string) - Username or NIK
- `pass` (string) - Password

**Response**: Redirect to dashboard based on role

#### Register
**File**: `includes/process/proses_register.php`
**Method**: POST
**Parameters**:
- `nik` (string) - 16-digit ID number
- `nama` (string) - Full name
- `jk` (enum) - Gender (L/P)
- `telp` (string) - Phone number
- `alamat` (text) - Address
- `user` (string) - Username
- `pass` (string) - Password
- `foto` (file) - Profile photo

**Response**: Redirect to register page with success/error message

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Coding Standards
- Use PSR-2 coding style
- Comment complex logic
- Use meaningful variable names
- Follow existing folder structure
- Test before submitting PR

---

## 📝 Changelog

### Version 2.0.0 (Latest) - December 2025
- ✅ Complete folder structure reorganization
- ✅ MVC-like architecture implementation
- ✅ Path configuration helper system
- ✅ Improved security with prepared statements
- ✅ Modern UI with TailwindCSS
- ✅ Responsive design for mobile
- ✅ Enhanced member management
- ✅ Transaction status tracking
- ✅ Automated late charge calculation

### Version 1.0.0 - Initial Release
- Basic rental management system
- Admin, petugas, member roles
- Car inventory management
- Transaction processing
- Payment tracking

See `CHANGELOG_FOLDER_STRUCTURE.md` for detailed changes.

---

## 🗺️ Roadmap

### Planned Features
- [ ] Email notifications for bookings
- [ ] SMS gateway integration
- [ ] Online payment gateway (Midtrans)
- [ ] Car availability calendar
- [ ] Customer reviews & ratings
- [ ] Loyalty points system
- [ ] Mobile app (React Native)
- [ ] Advanced reporting & analytics
- [ ] API for third-party integration
- [ ] Multi-language support

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

```
MIT License

Copyright (c) 2025 LuxRental

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 👨‍💻 Authors

- **Your Name** - *Initial work* - [YourGitHub](https://github.com/yourusername)

---

## 🙏 Acknowledgments

- TailwindCSS for the amazing utility-first CSS framework
- Font Awesome for comprehensive icon library
- Google Fonts for beautiful typography
- PHP community for excellent documentation
- All contributors who helped improve this project

---

## 📞 Support

Need help? Here's how to get support:

- 📧 Email: support@luxrental.com
- 💬 Discord: [Join our community](https://discord.gg/luxrental)
- 🐛 Issues: [GitHub Issues](https://github.com/yourusername/luxrental/issues)
- 📖 Docs: [Full Documentation](https://docs.luxrental.com)

---

## ⭐ Show Your Support

Give a ⭐️ if this project helped you!

[![GitHub Stars](https://img.shields.io/github/stars/yourusername/luxrental?style=social)](https://github.com/yourusername/luxrental)
[![GitHub Forks](https://img.shields.io/github/forks/yourusername/luxrental?style=social)](https://github.com/yourusername/luxrental/fork)

---

<div align="center">
  <strong>Built with ❤️ by LuxRental Team</strong>
  <br>
  <sub>Making premium car rental accessible to everyone</sub>
</div>
