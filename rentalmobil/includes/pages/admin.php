<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      padding: 20px;
      min-height: 100vh;
    }
    
    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding: 20px 30px;
      border-radius: 12px;
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
    }
    
    .header:hover {
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
      transform: translateY(-2px);
    }
    
    .header h1 {
      font-size: 2rem;
      color: #2c3e50;
      font-weight: 600;
      letter-spacing: -0.5px;
    }
    
    .user-info {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .user-info img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #3498db;
      transition: all 0.3s ease;
    }
    
    .user-info img:hover {
      transform: scale(1.1);
      border-color: #2ecc71;
    }
    
    /* Cards */
    .cards {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 25px;
      margin-bottom: 40px;
    }
    
    .card {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      cursor: pointer;
    }
    
    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: #3498db;
    }
    
    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .card.available::before {
      background: #2ecc71;
    }
    
    .card.rented::before {
      background: #e74c3c;
    }
    
    .card.maintenance::before {
      background: #f39c12;
    }
    
    .card h3 {
      font-size: 0.95rem;
      color: #7f8c8d;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .card h3 i {
      font-size: 1.2rem;
    }
    
    .card p {
      font-size: 2.2rem;
      font-weight: 700;
      color: #2c3e50;
    }
    
    .card.total p {
      color: #3498db;
    }
    
    .card.available p {
      color: #2ecc71;
    }
    
    .card.rented p {
      color: #e74c3c;
    }
    
    .card.maintenance p {
      color: #f39c12;
    }
    
    /* Tables */
    .table-container {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }
    
    .table-container:hover {
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .table-header h2 {
      color: #2c3e50;
      font-weight: 600;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
    }
    
    table th, table td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #ecf0f1;
    }
    
    table th {
      background-color: #f8f9fa;
      font-weight: 600;
      color: #2c3e50;
      position: sticky;
      top: 0;
    }
    
    table tr {
      transition: all 0.2s ease;
    }
    
    table tr:hover {
      background-color: #f8f9fa;
      transform: scale(1.01);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .status {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
      display: inline-block;
      transition: all 0.2s ease;
    }
    
    .status:hover {
      transform: scale(1.05);
    }
    
    .status.available {
      background-color: #d4edda;
      color: #155724;
    }
    
    .status.rented {
      background-color: #f8d7da;
      color: #721c24;
    }
    
    .status.maintenance {
      background-color: #fff3cd;
      color: #856404;
    }
    
    .btn {
      padding: 8px 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }
    
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    .btn-edit {
      background-color: #3498db;
      color: white;
    }
    
    .btn-edit:hover {
      background-color: #2980b9;
    }
    
    .btn-delete {
      background-color: #e74c3c;
      color: white;
    }
    
    .btn-delete:hover {
      background-color: #c0392b;
    }
    
    .btn-add {
      background: linear-gradient(135deg, #2ecc71, #1abc9c);
      color: white;
      margin-bottom: 20px;
      padding: 10px 20px;
      font-size: 0.9rem;
    }
    
    .btn-add:hover {
      background: linear-gradient(135deg, #27ae60, #16a085);
    }
    
    .action-buttons {
      display: flex;
      gap: 8px;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
      .cards {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    
    @media (max-width: 768px) {
      .cards {
        grid-template-columns: 1fr;
      }
      
      .header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
      }
      
      .action-buttons {
        flex-direction: column;
      }
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <!-- Header -->
  <div class="header">
    <h1>🏎️Selamat Datang Di Rental Mobil</h1>
    <div class="user-info">
    </div>
  </div>
  
  <!-- Cards -->
  <div class="cards">
    <div class="card total">
      <h3>Total Mobil</h3>
      <p>24</p>
    </div>
    <div class="card available">
      <h3>Tersedia</h3>
      <p>15</p>
    </div>
    <div class="card rented">
      <h3>Disewa</h3>
      <p>7</p>
    </div>
    <div class="card maintenance">
      <h3>Perawatan</h3>
      <p>2</p>
    </div>
  </div>

  <script>
    // Simple JavaScript for buttons
    document.addEventListener('DOMContentLoaded', function() {
      // Add event listeners for buttons
      const addBtn = document.querySelector('.btn-add');
      const editBtns = document.querySelectorAll('.btn-edit');
      const deleteBtns = document.querySelectorAll('.btn-delete');
      
      addBtn.addEventListener('click', function() {
        alert('Fitur tambah mobil akan dibuka');
        // Anda bisa menambahkan modal atau form untuk menambah mobil
      });
      
      editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          const row = this.closest('tr');
          const carId = row.cells[0].textContent;
          alert(`Edit mobil dengan ID: ${carId}`);
        });
      });
      
      deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          const row = this.closest('tr');
          const carId = row.cells[0].textContent;
          if (confirm(`Apakah Anda yakin ingin menghapus mobil dengan ID: ${carId}?`)) {
            row.remove();
            alert('Mobil berhasil dihapus');
          }
        });
      });
    });
  </script>
</body>
</html>