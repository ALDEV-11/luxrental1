<?php
include __DIR__ . "/../../config/koneksi.php";

// cek apakah sudah login
if (!isset($_SESSION['login'])) {
    header("Location: ../../landing.php");
    exit;
}

// Tampilkan notifikasi jika ada
if (isset($_SESSION['success'])) {
    echo '<div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.2) 100%); 
                 color: #10b981; 
                 padding: 16px 24px; 
                 border-radius: 12px; 
                 margin: 20px auto; 
                 max-width: 1400px; 
                 border: 2px solid #10b981;
                 box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
                 font-weight: 600;
                 font-size: 15px;
                 display: flex;
                 align-items: center;
                 gap: 12px;">
            <i class="fas fa-check-circle" style="font-size: 20px;"></i>
            ' . $_SESSION['success'] . '
          </div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(220, 38, 38, 0.2) 100%); 
                 color: #ef4444; 
                 padding: 16px 24px; 
                 border-radius: 12px; 
                 margin: 20px auto; 
                 max-width: 1400px; 
                 border: 2px solid #ef4444;
                 box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
                 font-weight: 600;
                 font-size: 15px;
                 display: flex;
                 align-items: center;
                 gap: 12px;">
            <i class="fas fa-exclamation-circle" style="font-size: 20px;"></i>
            ' . $_SESSION['error'] . '
          </div>';
    unset($_SESSION['error']);
}

$role = $_SESSION['role'];
$nik  = ($role === 'member') ? $_SESSION['nik'] : null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>LuxRental - Riwayat Transaksi</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* LuxRental Luxury Theme */
        :root {
            --luxury-black: #0a0a0a;
            --luxury-gray: #1a1a1a;
            --luxury-gold: #d4af37;
            --luxury-gold-light: #f7e98e;
            --luxury-gold-dark: #b8941f;
            --luxury-silver: #c0c0c0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--luxury-black) 0%, var(--luxury-gray) 100%);
            padding: 30px 20px;
            color: var(--luxury-silver);
            position: relative;
            min-height: 100vh;
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
        
        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }
        
        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 50px 30px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.95) 0%, rgba(247, 233, 142, 0.95) 100%);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .page-header h1 {
            font-size: 36px;
            font-weight: 800;
            color: var(--luxury-black);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            position: relative;
        }
        
        .page-header h1 i {
            font-size: 42px;
            color: var(--luxury-black);
        }
        
        .page-header p {
            font-size: 16px;
            color: rgba(10, 10, 10, 0.7);
            font-weight: 500;
            position: relative;
        }
        
        /* Tabs Wrapper */
        .tabs-wrapper {
            background: rgba(26, 26, 26, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(212, 175, 55, 0.2);
            overflow: hidden;
            border: 2px solid var(--luxury-gold);
            backdrop-filter: blur(10px);
        }
        
        .tab-buttons {
            display: flex;
            background: linear-gradient(to bottom, rgba(10, 10, 10, 0.8) 0%, rgba(26, 26, 26, 0.8) 100%);
            padding: 20px 25px 0;
            gap: 10px;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
            overflow-x: auto;
        }
        
        .tab-buttons::-webkit-scrollbar {
            height: 6px;
        }
        
        .tab-buttons::-webkit-scrollbar-track {
            background: rgba(10, 10, 10, 0.5);
            border-radius: 10px;
        }
        
        .tab-buttons::-webkit-scrollbar-thumb {
            background: var(--luxury-gold);
            border-radius: 10px;
        }
        
        .tab-buttons::-webkit-scrollbar-thumb:hover {
            background: var(--luxury-gold-light);
        }
        
        .tab-buttons button {
            padding: 14px 28px;
            cursor: pointer;
            border: 2px solid transparent;
            background: transparent;
            border-radius: 12px 12px 0 0;
            transition: all 0.3s ease;
            font-weight: 600;
            color: var(--luxury-silver);
            font-size: 14px;
            white-space: nowrap;
            position: relative;
            font-family: 'Inter', sans-serif;
        }
        
        .tab-buttons button:hover {
            color: var(--luxury-gold);
            background: rgba(212, 175, 55, 0.1);
        }
        
        .tab-buttons button.active {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            color: var(--luxury-black);
            font-weight: 700;
            border-color: var(--luxury-gold);
            box-shadow: 0 -4px 20px rgba(212, 175, 55, 0.4);
        }
        
        .tab-content {
            display: none;
            padding: 30px;
            animation: fadeIn 0.4s ease;
            background: rgba(10, 10, 10, 0.4);
        }
        
        .tab-content.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .tab-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
        }
        
        .tab-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--luxury-gold);
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Playfair Display', serif;
        }
        
        .tab-title::before {
            content: '';
            width: 5px;
            height: 30px;
            background: linear-gradient(180deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            border-radius: 5px;
        }
        
        .action-buttons {
            display: flex;
            gap: 12px;
        }
        
        .print-btn, .export-btn {
            padding: 11px 22px;
            border: 2px solid var(--luxury-gold);
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--luxury-gold);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
            font-family: 'Inter', sans-serif;
        }
        
        .print-btn:hover {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            border-color: var(--luxury-gold-light);
            color: var(--luxury-black);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
        }
        
        .export-btn:hover {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-color: #10b981;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        
        .table-wrapper {
            overflow-x: auto;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            background: rgba(26, 26, 26, 0.6);
            border: 2px solid var(--luxury-gold);
        }
        
        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-wrapper::-webkit-scrollbar-track {
            background: rgba(10, 10, 10, 0.5);
            border-radius: 10px;
        }
        
        .table-wrapper::-webkit-scrollbar-thumb {
            background: var(--luxury-gold);
            border-radius: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: transparent;
        }
        
        th {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            color: var(--luxury-black);
            padding: 16px 15px;
            text-align: center;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-family: 'Inter', sans-serif;
        }
        
        th:first-child {
            border-radius: 13px 0 0 0;
        }
        
        th:last-child {
            border-radius: 0 13px 0 0;
        }
        
        td {
            padding: 16px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            font-size: 14px;
            color: var(--luxury-silver);
            transition: all 0.3s ease;
        }
        
        tr:hover td {
            background: rgba(212, 175, 55, 0.1);
            color: var(--luxury-gold-light);
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:last-child td:first-child {
            border-radius: 0 0 0 13px;
        }
        
        tr:last-child td:last-child {
            border-radius: 0 0 13px 0;
        }
        
        td strong {
            color: var(--luxury-gold);
            font-weight: 700;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: 2px solid;
        }
        
        .status-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }
        
        .status-waiting {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.2) 0%, rgba(245, 158, 11, 0.2) 100%);
            color: #fbbf24;
            border-color: #fbbf24;
        }
        
        .status-waiting::before {
            background: #fbbf24;
        }
        
        .status-approved {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.2) 100%);
            color: #10b981;
            border-color: #10b981;
        }
        
        .status-approved::before {
            background: #10b981;
        }
        
        .status-rejected {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(220, 38, 38, 0.2) 100%);
            color: #ef4444;
            border-color: #ef4444;
        }
        
        .status-rejected::before {
            background: #ef4444;
        }
        
        .status-completed {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.2) 100%);
            color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .status-completed::before {
            background: #3b82f6;
        }
        
        .btn {
            padding: 9px 18px;
            border: 2px solid;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            font-family: 'Inter', sans-serif;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            color: var(--luxury-black);
            border-color: var(--luxury-gold);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.5);
            background: linear-gradient(135deg, var(--luxury-gold-light) 0%, var(--luxury-gold) 100%);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: white;
            border-color: #dc2626;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.5);
            background: linear-gradient(135deg, #991b1b 0%, #dc2626 100%);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-color: #10b981;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border-color: #f59e0b;
        }
        
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.5);
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        }
        
        .btn-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border-color: #3b82f6;
        }
        
        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }
        
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: rgba(192, 192, 192, 0.5);
        }
        
        .empty-state svg {
            margin-bottom: 25px;
            opacity: 0.2;
        }
        
        .empty-state p {
            font-size: 16px;
            font-weight: 500;
            color: var(--luxury-silver);
            opacity: 0.6;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1040;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            padding: 20px;
            overflow-y: auto;
            pointer-events: auto;
        }
        
        .modal-content {
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.98) 0%, rgba(10, 10, 10, 0.98) 100%);
            margin: 5% auto;
            padding: 35px;
            max-width: 520px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.4s ease;
            border: 2px solid var(--luxury-gold);
            position: relative;
            z-index: 1055;
            pointer-events: auto;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .modal-content h3 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 28px;
            color: var(--luxury-gold);
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-family: 'Playfair Display', serif;
        }
        
        .modal-content h3::before {
            content: '�';
            font-size: 32px;
        }
        
        .modal-content label {
            display: block;
            font-weight: 600;
            margin-top: 18px;
            margin-bottom: 10px;
            color: var(--luxury-gold);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
        }
        
        .modal-content select,
        .modal-content input,
        .modal-content textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            color: var(--luxury-silver);
            background: rgba(10, 10, 10, 0.6);
            pointer-events: auto;
        }
        
        .modal-content select:focus,
        .modal-content input:focus,
        .modal-content textarea:focus {
            outline: none;
            border-color: var(--luxury-gold);
            background: rgba(26, 26, 26, 0.8);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
            color: var(--luxury-gold-light);
        }
        
        .modal-content textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .modal-buttons {
            display: flex;
            gap: 15px;
            margin-top: 28px;
        }
        
        .modal-buttons button {
            flex: 1;
            padding: 14px;
            font-size: 15px;
            pointer-events: auto;
        }
        
        .info-box {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(247, 233, 142, 0.15) 100%);
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 22px;
            border-left: 4px solid var(--luxury-gold);
            font-size: 14px;
            color: var(--luxury-gold-light);
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        
        .info-box::before {
            content: 'ℹ️';
            font-size: 20px;
        }
        
        .info-box strong {
            font-weight: 700;
            color: var(--luxury-gold);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(10, 10, 10, 0.5);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, var(--luxury-gold-light) 100%);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--luxury-gold-light) 0%, var(--luxury-gold) 100%);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
            }
            
            .page-header {
                padding: 35px 20px;
            }
            
            .page-header h1 {
                font-size: 26px;
            }
            
            .tab-buttons {
                padding: 15px 18px 0;
            }
            
            .tab-content {
                padding: 22px 18px;
            }
            
            .tab-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .action-buttons {
                width: 100%;
                flex-direction: column;
            }
            
            .action-buttons button {
                width: 100%;
            }
            
            .modal-content {
                margin: 10% auto;
                padding: 28px;
            }
            
            table {
                font-size: 12px;
            }
            
            th, td {
                padding: 12px 10px;
            }
        }
    </style>
    <script>
        function showTab(tabId) {
            document.querySelectorAll(".tab-content").forEach(el => el.classList.remove("active"));
            document.querySelectorAll(".tab-buttons button").forEach(el => el.classList.remove("active"));
            document.getElementById(tabId).classList.add("active");
            document.querySelector(`[data-tab='${tabId}']`).classList.add("active");
        }
        
        function printDiv(divId) {
            let tabTitle = document.querySelector(`#${divId} .tab-title`).textContent;
            let tableContent = document.querySelector(`#${divId} table`).outerHTML;
            
            let printWindow = window.open('', '_blank', 'height=700,width=1000');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Laporan Transaksi - ${tabTitle}</title>
                        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
                        <style>
                            * {
                                margin: 0;
                                padding: 0;
                                box-sizing: border-box;
                            }
                            
                            body { 
                                font-family: 'Inter', sans-serif; 
                                padding: 40px; 
                                background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
                                color: #c0c0c0;
                                margin: 0;
                            }
                            
                            .print-header {
                                text-align: center;
                                margin-bottom: 35px;
                                padding: 30px;
                                background: linear-gradient(135deg, rgba(212, 175, 55, 0.95) 0%, rgba(247, 233, 142, 0.95) 100%);
                                border-radius: 15px;
                                box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
                            }
                            
                            .print-header h2 {
                                color: #0a0a0a;
                                margin: 0 0 15px 0;
                                font-size: 28px;
                                font-weight: 700;
                                font-family: 'Playfair Display', serif;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                gap: 12px;
                            }
                            
                            .print-header h2::before {
                                content: '👑';
                                font-size: 32px;
                            }
                            
                            .print-info {
                                display: flex;
                                justify-content: space-around;
                                margin-top: 20px;
                                font-size: 13px;
                                background: rgba(10, 10, 10, 0.3);
                                padding: 12px 20px;
                                border-radius: 10px;
                                color: #0a0a0a;
                                font-weight: 600;
                            }
                            
                            table { 
                                width: 100%; 
                                border-collapse: collapse; 
                                margin-top: 20px;
                                font-size: 12px;
                                background: rgba(26, 26, 26, 0.8);
                                border-radius: 12px;
                                overflow: hidden;
                                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
                            }
                            
                            th, td { 
                                border: 1px solid rgba(212, 175, 55, 0.3); 
                                padding: 12px; 
                                text-align: center; 
                            }
                            
                            th { 
                                background: linear-gradient(135deg, #d4af37 0%, #f7e98e 100%);
                                color: #0a0a0a;
                                font-weight: 700;
                                font-size: 12px;
                                text-transform: uppercase;
                                letter-spacing: 0.5px;
                            }
                            
                            td {
                                color: #c0c0c0;
                                font-weight: 500;
                            }
                            
                            tr:nth-child(even) td { 
                                background: rgba(212, 175, 55, 0.05);
                            }
                            
                            tr:hover td {
                                background: rgba(212, 175, 55, 0.1);
                            }
                            
                            strong {
                                color: #d4af37;
                            }
                            
                            .print-footer {
                                margin-top: 40px;
                                padding-top: 20px;
                                border-top: 2px solid rgba(212, 175, 55, 0.3);
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                font-size: 12px;
                                color: #d4af37;
                            }
                            
                            .luxury-badge {
                                background: linear-gradient(135deg, #d4af37 0%, #f7e98e 100%);
                                color: #0a0a0a;
                                padding: 8px 16px;
                                border-radius: 20px;
                                font-weight: 700;
                                font-size: 11px;
                                text-transform: uppercase;
                                letter-spacing: 1px;
                            }
                            
                            @media print {
                                body { 
                                    padding: 20px;
                                    background: white;
                                    color: #333;
                                }
                                
                                .print-header {
                                    background: linear-gradient(135deg, #d4af37 0%, #f7e98e 100%);
                                }
                                
                                table {
                                    background: white;
                                }
                                
                                td {
                                    color: #333;
                                }
                                
                                .print-footer {
                                    color: #666;
                                }
                            }
                            
                            @page {
                                margin: 0.5in;
                                size: landscape;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="print-header">
                            <h2>LuxRental - ${tabTitle}</h2>
                            <div class="print-info">
                                <div><strong>📅 Tanggal:</strong> ${new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</div>
                                <div><strong>🕐 Jam:</strong> ${new Date().toLocaleTimeString('id-ID')}</div>
                            </div>
                        </div>
                        ${tableContent}
                    </body>
                </html>
            `);
            
            printWindow.document.close();
            printWindow.focus();
            
            // Tunggu sebentar sebelum print agar styling terbaca
            setTimeout(() => {
                printWindow.print();
                // printWindow.close(); // Opsional: tutup window setelah print
            }, 500);
        }
        
        function exportToExcel(divId) {
            let tabTitle = document.querySelector(`#${divId} .tab-title`).textContent;
            let table = document.querySelector(`#${divId} table`);
            
            // Clone table untuk menghapus kolom aksi
            let clonedTable = table.cloneNode(true);
            let rows = clonedTable.querySelectorAll('tr');
            
            // Hapus kolom terakhir (Aksi) dari setiap baris
            rows.forEach(row => {
                let lastCell = row.querySelector('th:last-child, td:last-child');
                if (lastCell) {
                    lastCell.remove();
                }
            });
            
            // Buat worksheet dari table
            let html = clonedTable.outerHTML;
            let uri = 'data:application/vnd.ms-excel;base64,';
            let template = `
                <html xmlns:o="urn:schemas-microsoft-com:office:office" 
                      xmlns:x="urn:schemas-microsoft-com:office:excel" 
                      xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta charset="UTF-8">
                    <!--[if gte mso 9]>
                    <xml>
                        <x:ExcelWorkbook>
                            <x:ExcelWorksheets>
                                <x:ExcelWorksheet>
                                    <x:Name>${tabTitle}</x:Name>
                                    <x:WorksheetOptions>
                                        <x:DisplayGridlines/>
                                    </x:WorksheetOptions>
                                </x:ExcelWorksheet>
                            </x:ExcelWorksheets>
                        </x:ExcelWorkbook>
                    </xml>
                    <![endif]-->
                    <style>
                        table {
                            border-collapse: collapse;
                            width: 100%;
                        }
                        th {
                            background-color: #d4af37;
                            color: #0a0a0a;
                            font-weight: bold;
                            padding: 10px;
                            border: 1px solid #b8941f;
                        }
                        td {
                            padding: 8px;
                            border: 1px solid #ddd;
                        }
                        tr:nth-child(even) {
                            background-color: #f9f9f9;
                        }
                    </style>
                </head>
                <body>
                    <h2 style="text-align: center; color: #d4af37; font-family: Arial;">
                        LuxRental - ${tabTitle}
                    </h2>
                    <p style="text-align: center; color: #666;">
                        Tanggal Export: ${new Date().toLocaleDateString('id-ID', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })} | ${new Date().toLocaleTimeString('id-ID')}
                    </p>
                    ${html}
                    <br>
                </body>
                </html>
            `;
            
            // Encode ke base64
            let base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
            let downloadLink = document.createElement("a");
            
            // Buat nama file dengan timestamp
            let timestamp = new Date().toISOString().slice(0,10);
            let filename = `LuxRental_${tabTitle.replace(/\s+/g, '_')}_${timestamp}.xls`;
            
            downloadLink.href = uri + base64(template);
            downloadLink.download = filename;
            downloadLink.click();
        }
    </script>
</head>
<body>

<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-crown"></i> Riwayat Transaksi LuxRental <?= $role === 'member' ? '' : '' ?></h1>
        <p>Kelola dan pantau semua transaksi rental mobil premium Anda</p>
    </div>

    <div class="tabs-wrapper">
        <div class="tab-buttons">
            <button class="active" data-tab="booking" onclick="showTab('booking')">
                <i class="fas fa-clipboard-list"></i> Booking
            </button>
            <button data-tab="aprove" onclick="showTab('aprove')">
                <i class="fas fa-check-circle"></i> Aprove
            </button>
            <button data-tab="ambil" onclick="showTab('ambil')">
                <i class="fas fa-car"></i> Ambil
            </button>
            <button data-tab="kembali" onclick="showTab('kembali')">
                <i class="fas fa-undo-alt"></i> Kembali
            </button>
            <button data-tab="ditolak" onclick="showTab('ditolak')">
                <i class="fas fa-times-circle"></i> Ditolak
            </button>
        </div>

        <?php
        $statusList = ["booking", "aprove", "ambil", "kembali", "ditolak"];
        foreach ($statusList as $status) {
            if ($role === 'member') {
                $sql = "SELECT t.*, mb.nopol,
                               CASE WHEN t.status = 'ditolak' THEN 0 ELSE t.kekurangan END AS kekurangan
                        FROM tbl_transaksi t
                        JOIN tbl_mobil mb ON t.nopol = mb.nopol
                        WHERE t.status = :status AND t.nik = :nik
                        ORDER BY t.id_transaksi DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['status' => $status, 'nik' => $nik]);
            } else {
                $sql = "SELECT t.*, mb.nopol,
                               CASE WHEN t.status = 'ditolak' THEN 0 ELSE t.kekurangan END AS kekurangan
                        FROM tbl_transaksi t
                        JOIN tbl_mobil mb ON t.nopol = mb.nopol
                        WHERE t.status = :status
                        ORDER BY t.id_transaksi DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['status' => $status]);
            }
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div id="<?= $status ?>" class="tab-content <?= $status == 'booking' ? 'active' : '' ?>">
            <div class="tab-header">
                <h3 class="tab-title">Data Transaksi - <?= ucfirst($status) ?></h3>
                <div class="action-buttons">
                    <button class="export-btn" onclick="exportToExcel('<?= $status ?>')">
                        <i class="fas fa-file-excel"></i>
                        Export Excel
                    </button>
                    <button class="print-btn" onclick="printDiv('<?= $status ?>')">
                        <i class="fas fa-print"></i>
                        Cetak Laporan
                    </button>
                </div>
            </div>
            
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <?php if ($role !== 'member') { ?>
                                <th>No Transaksi</th>
                            <?php } ?>
                            <th>Nopol</th>
                            <th>Tgl Booking</th>
                            <th>Tgl Ambil</th>
                            <th>Tgl Kembali</th>
                            <th>Supir</th>
                            <th>Total</th>
                            <th>DP</th>
                            <th>Kekurangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($rows) > 0) {
                            foreach ($rows as $row) { ?>
                            <tr>
                                <?php if ($role !== 'member') { ?>
                                    <td><strong>#<?= $row['id_transaksi'] ?></strong></td>
                                <?php } ?>
                                <td><?= $row['nopol'] ?></td>
                                <td><?= $row['tgl_booking'] ?></td>
                                <td><?= $row['tgl_ambil'] ?></td>
                                <td><?= $row['tgl_kembali'] ?></td>
                                <td><?= $row['supir'] ? "Ya" : "Tidak" ?></td>
                                <td>Rp <?= number_format($row['total'],0,',','.') ?></td>
                                <td>Rp <?= number_format($row['downpayment'],0,',','.') ?></td>
                                <td>Rp <?= number_format($row['kekurangan'],0,',','.') ?></td>
                                <td>
                                    <?php if ($status == 'booking' && $role !== 'member') { ?>
                                        <a class="btn btn-success" href="proses_approve.php?id=<?= $row['id_transaksi'] ?>&status=aprove">Setujui</a>
                                        <a class="btn btn-danger" href="proses_approve.php?id=<?= $row['id_transaksi'] ?>&status=ditolak">Tolak</a>
                                    <?php } elseif ($status == 'booking' && $role === 'member') { ?>
                                        <span class="status-badge status-waiting">Menunggu Approve</span>
                                    <?php } elseif ($status == 'aprove') { ?>
                                        <?php if ($role === 'member') { ?>
                                            <a class="btn btn-primary" href="proses_ambil.php?id=<?= $row['id_transaksi'] ?>">Ambil Mobil</a>
                                        <?php } else { ?>
                                            <span class="status-badge status-approved">Disetujui</span>
                                        <?php } ?>
                                    <?php } elseif ($status == 'ditolak') { ?>
                                        <span class="status-badge status-rejected">Tidak Disetujui</span>
                                    <?php } elseif ($status == 'kembali') { ?>
                                        <?php if ($role === 'member' && $row['kekurangan'] > 0) { ?>
                                            <a class="btn btn-warning" href="proses_bayar.php?id=<?= $row['id_transaksi'] ?>">Bayar Lunas</a>
                                        <?php } else if ($role === 'member') { ?>
                                            <span class="status-badge status-completed">Lunas & Dikembalikan</span>
                                        <?php } else { ?>
                                            <?php if ($row['kekurangan'] > 0) { ?>
                                                <span class="status-badge status-warning">Belum Lunas</span>
                                            <?php } else { ?>
                                                <span class="status-badge status-completed">Lunas & Dikembalikan</span>
                                            <?php } ?>
                                            <button class="btn btn-danger" onclick="openAdminModal(<?= $row['id_transaksi'] ?>, '<?= $row['tgl_kembali'] ?>')">Tambah Denda</button>
                                        <?php } ?>
                                    <?php } elseif ($status == 'ambil') { ?>
                                        <?php if ($role === 'member') { ?>
                                            <button class="btn btn-primary" 
                                                onclick="openModal(<?= $row['id_transaksi'] ?>, '<?= $row['tgl_kembali'] ?>')">
                                                Kembalikan
                                            </button>
                                        <?php } else { ?>
                                            <span class="status-badge status-waiting">Menunggu dikembalikan</span>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <span>-</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } } else { ?>
                            <tr>
                                <td colspan="<?= $role !== 'member' ? '10' : '9' ?>" style="text-align: center; padding: 40px;">
                                    <div class="empty-state">
                                        <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 11.5h.25V19h-4.5v-4.5H10l2-2 2 2z"/>
                                        </svg>
                                        <p>Tidak ada data transaksi dengan status <?= $status ?></p>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php if ($role === 'member') { ?>
<!-- Modal untuk member mengembalikan mobil -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h3>Kembalikan Mobil</h3>
        <form action="proses_kembali.php" method="POST">
            <input type="hidden" name="id_transaksi" id="id_transaksi">
            <input type="hidden" name="tgl_kembali" id="tgl_kembali">

            <label>Kondisi Mobil:</label>
            <select name="kondisi_mobil" id="kondisi_mobil" onchange="hitungDenda()" required>
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik">Baik - Tidak Ada Kerusakan</option>
                <option value="Lecet">Lecet (+Rp 200.000)</option>
                <option value="Rusak Sedang">Rusak Sedang (+Rp 500.000)</option>
                <option value="Rusak Parah">Rusak Parah (+Rp 1.000.000)</option>
                <option value="Hilang">Hilang (+Rp 5.000.000)</option>
            </select>

            <label>Status Pengembalian:</label>
            <select name="status_keterlambatan" id="status_keterlambatan" onchange="hitungDenda()" required>
                <option value="">-- Pilih Status --</option>
                <option value="Tepat Waktu">Tepat Waktu - Tidak Terlambat</option>
                <option value="Terlambat">Terlambat (+Rp 100.000/hari otomatis)</option>
            </select>

            <label>Denda Kerusakan (Rp):</label>
            <input type="number" id="denda_kerusakan" value="0" readonly>

            <label>Denda Keterlambatan (Rp):</label>
            <input type="number" id="denda_telat" value="0" readonly>

            <label>Total Denda (Rp):</label>
            <input type="number" name="denda" id="denda" value="0" readonly>

            <label>Keterangan:</label>
            <textarea name="keterangan" id="keterangan" rows="3"></textarea>

            <div class="modal-buttons">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" onclick="closeModal()">Batal</button>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php if ($role !== 'member') { ?>
<!-- Modal untuk admin menambahkan denda -->
<div id="modalAdmin" class="modal">
    <div class="modal-content">
        <h3>Tambah Denda</h3>
        <form action="proses_tambah_denda.php" method="POST">
            <input type="hidden" name="id_transaksi" id="admin_id_transaksi">
            <input type="hidden" name="admin_tgl_kembali" id="admin_tgl_kembali">

            <div class="info-box">
                <strong>Info:</strong> Denda yang ditambahkan akan otomatis menambah nilai kekurangan pada transaksi.
            </div>

            <label>Jenis Denda:</label>
            <select name="jenis_denda" id="jenis_denda" onchange="hitungDendaAdmin()" required>
                <option value="">-- Pilih Jenis Denda --</option>
                <option value="Kerusakan">Kerusakan Kendaraan</option>
                <option value="Keterlambatan">Keterlambatan Pengembalian</option>
                <option value="Pelanggaran">Pelanggaran Lainnya</option>
                <option value="Kehilangan">Kehilangan Barang</option>
                <option value="Lainnya">Lainnya</option>
            </select>

            <label>Jumlah Denda (Rp):</label>
            <input type="number" name="jumlah_denda" id="jumlah_denda" min="0" required 
                   placeholder="Masukkan jumlah denda atau pilih 'Keterlambatan' untuk hitung otomatis">

            <label>Keterangan Denda:</label>
            <textarea name="keterangan_denda" id="keterangan_denda" rows="3" 
                      placeholder="Jelaskan alasan pemberian denda..." required></textarea>

            <div class="modal-buttons">
                <button type="submit" class="btn btn-primary">Simpan Denda</button>
                <button type="button" class="btn btn-danger" onclick="closeAdminModal()">Batal</button>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<script>
    
// Fungsi untuk member
function openModal(idTransaksi, tglKembali) {
    document.getElementById("modal").style.display = "block";
    document.getElementById("id_transaksi").value = idTransaksi;
    document.getElementById("tgl_kembali").value = tglKembali;
    hitungDenda();
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}

function hitungDenda() {
    let kondisi = document.getElementById("kondisi_mobil").value;
    let statusKeterlambatan = document.getElementById("status_keterlambatan").value;
    let dendaKerusakanField = document.getElementById("denda_kerusakan");
    let dendaTelatField = document.getElementById("denda_telat");
    let dendaTotalField = document.getElementById("denda");
    let keteranganField = document.getElementById("keterangan");

    let dendaKerusakan = 0;
    let dendaTelat = 0;
    let dendaPerHari = 100000;

    // Hitung denda kerusakan
    switch (kondisi) {
        case "Baik": dendaKerusakan = 0; break;
        case "Lecet": dendaKerusakan = 200000; break;
        case "Rusak Sedang": dendaKerusakan = 500000; break;
        case "Rusak Parah": dendaKerusakan = 1000000; break;
        case "Hilang": dendaKerusakan = 5000000; break;
    }

    // Hitung denda keterlambatan otomatis jika pilih "Terlambat"
    if (statusKeterlambatan === "Terlambat") {
        let tglKembali = document.getElementById("tgl_kembali").value;
        if (tglKembali) {
            let tglTarget = new Date(tglKembali);
            let tglHariIni = new Date();
            tglTarget.setHours(0, 0, 0, 0);
            tglHariIni.setHours(0, 0, 0, 0);

            let selisihHari = Math.floor((tglHariIni - tglTarget) / (1000 * 60 * 60 * 24));
            if (selisihHari > 0) {
                dendaTelat = selisihHari * dendaPerHari;
                
                // Auto-fill keterangan keterlambatan
                if (keteranganField) {
                    let keteranganKerusakan = kondisi !== "Baik" && kondisi !== "" ? `Kondisi mobil: ${kondisi}. ` : "";
                    keteranganField.value = `${keteranganKerusakan}Terlambat ${selisihHari} hari pengembalian (@ Rp ${dendaPerHari.toLocaleString('id-ID')}/hari)`;
                }
            } else {
                dendaTelat = 0;
                alert("Tidak ada keterlambatan terdeteksi. Tanggal kembali belum melewati jadwal.");
            }
        }
    } else if (statusKeterlambatan === "Tepat Waktu") {
        dendaTelat = 0;
        
        // Auto-fill keterangan jika hanya ada kerusakan
        if (keteranganField && kondisi && kondisi !== "Baik") {
            keteranganField.value = `Kondisi mobil: ${kondisi}`;
        } else if (keteranganField && kondisi === "Baik") {
            keteranganField.value = "Mobil dikembalikan dalam kondisi baik dan tepat waktu";
        }
    }

    let totalDenda = dendaKerusakan + dendaTelat;
    dendaKerusakanField.value = dendaKerusakan;
    dendaTelatField.value = dendaTelat;
    dendaTotalField.value = totalDenda;
}

// Fungsi untuk admin
function openAdminModal(idTransaksi, tglKembali) {
    document.getElementById("modalAdmin").style.display = "block";
    document.getElementById("admin_id_transaksi").value = idTransaksi;
    document.getElementById("admin_tgl_kembali").value = tglKembali || '';
    
    // Reset form
    document.getElementById("jenis_denda").value = '';
    document.getElementById("jumlah_denda").value = '';
    document.getElementById("keterangan_denda").value = '';
}

function hitungDendaAdmin() {
    let jenisDenda = document.getElementById("jenis_denda").value;
    let tglKembali = document.getElementById("admin_tgl_kembali").value;
    let jumlahDendaField = document.getElementById("jumlah_denda");
    let keteranganField = document.getElementById("keterangan_denda");
    
    // Jika bukan keterlambatan, kosongkan
    if (jenisDenda !== "Keterlambatan") {
        return;
    }
    
    // Hitung denda keterlambatan otomatis
    if (tglKembali) {
        let tglTarget = new Date(tglKembali);
        let tglHariIni = new Date();
        tglTarget.setHours(0, 0, 0, 0);
        tglHariIni.setHours(0, 0, 0, 0);
        
        let selisihHari = Math.floor((tglHariIni - tglTarget) / (1000 * 60 * 60 * 24));
        
        if (selisihHari > 0) {
            let dendaPerHari = 100000;
            let totalDenda = selisihHari * dendaPerHari;
            
            jumlahDendaField.value = totalDenda;
            keteranganField.value = `Keterlambatan ${selisihHari} hari pengembalian mobil (@ Rp ${dendaPerHari.toLocaleString('id-ID')}/hari)`;
            
            alert(`Denda keterlambatan: ${selisihHari} hari × Rp ${dendaPerHari.toLocaleString('id-ID')} = Rp ${totalDenda.toLocaleString('id-ID')}`);
        } else {
            jumlahDendaField.value = 0;
            keteranganField.value = 'Tidak ada keterlambatan';
            alert('Mobil tidak terlambat dikembalikan. Tidak ada denda keterlambatan.');
        }
    } else {
        alert('Data tanggal kembali tidak tersedia untuk transaksi ini.');
    }
}

function closeAdminModal() {
    document.getElementById("modalAdmin").style.display = "none";
    // Refresh halaman untuk melihat perubahan kekurangan
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// Event listener untuk form submit denda
document.addEventListener('DOMContentLoaded', function() {
    const adminForm = document.querySelector('#modalAdmin form');
    if (adminForm) {
        adminForm.addEventListener('submit', function(e) {
            // Tidak perlu preventDefault karena kita ingin form submit normal
            // Tampilkan loading atau feedback
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = 'Menyimpan...';
            submitBtn.disabled = true;
        });
    }
});
</script>

</body>
</html>