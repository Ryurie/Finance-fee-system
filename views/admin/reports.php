<?php 
// views/admin/reports.php
session_start();
include '../layouts/header.php'; 
include '../layouts/sidebar.php'; 
require_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$total_collected = 0;
try {
    $total_collected = $db->query("SELECT SUM(amount) FROM payments WHERE status = 'verified'")->fetchColumn() ?: 0;
} catch(PDOException $e) { }
?>

<style>
    .report-card { background: #fff; border-radius: 16px; padding: 2rem; border: 1px solid #f1f5f9; text-align: center; }
    .print-btn { background: #1e293b; color: white; padding: 0.8rem 1.5rem; border-radius: 10px; border: none; font-weight: 700; cursor: pointer; }
    
    @media print {
        .sidebar, .print-btn, #themeToggle { display: none !important; }
        .main-content-wrapper { padding: 0 !important; }
        .report-card { border: none; box-shadow: none; }
    }
</style>

<div style="width: 100%; margin-top: 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="margin: 0; font-weight: 900; font-size: 2rem;">Financial Reports</h1>
        <button class="print-btn" onclick="window.print()">🖨️ Print Report</button>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <div class="report-card">
            <h3 style="color: #64748b; font-size: 0.9rem; text-transform: uppercase;">Total Collection (Verified)</h3>
            <p style="font-size: 3rem; font-weight: 900; color: #10b981; margin: 1rem 0;">₱<?php echo number_format($total_collected, 2); ?></p>
            <div style="height: 4px; background: #dcfce3; border-radius: 2px; width: 50%; margin: 0 auto;"></div>
        </div>

        <div class="report-card">
            <h3 style="color: #64748b; font-size: 0.9rem; text-transform: uppercase;">Collection Status</h3>
            <p style="color: #1e293b; font-weight: 700; margin-top: 1.5rem;">Official Summary of Fees and Grants</p>
            <p style="font-size: 0.85rem; color: #64748b;">Generated on <?php echo date('M d, Y h:i A'); ?></p>
        </div>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>