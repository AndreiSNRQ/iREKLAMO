<?php   
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reportType = $_POST['report_type'];
    $dateFrom = $_POST['date_from'];
    $dateTo = $_POST['date_to'];

    // Prepare data based on report type
    $data = [
        'blotters' => [],
        'complaints' => []
    ];
    $filename = '';

    // Fetch data first
    if ($reportType === 'all' || $reportType === 'blotter') {
        $blotterQuery = "SELECT * FROM blotter WHERE date_time BETWEEN :date_from AND :date_to ORDER BY date_time DESC";
        $stmt = $conn->prepare($blotterQuery);
        $stmt->execute([':date_from' => $dateFrom, ':date_to' => $dateTo]);
        $data['blotters'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if ($reportType === 'all' || $reportType === 'complaint') {
        $complaintQuery = "SELECT * FROM complaint WHERE date_time BETWEEN :date_from AND :date_to AND status != 'transfer' ORDER BY date_time DESC";
        $stmt = $conn->prepare($complaintQuery);
        $stmt->execute([':date_from' => $dateFrom, ':date_to' => $dateTo]);
        $data['complaints'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Generate CSV
    header('Content-Type: text/csv');
    $filename = 'reports/report_' . date("YmdHis") . '.csv';
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    $output = fopen('php://output', 'w');

    if ($reportType === 'all') {
        fputcsv($output, ['Blotter Reports']);
        fputcsv($output, ['Case No.', 'Complainant', 'Respondent', 'Type', 'Status', 'Details', 'Date']);
        foreach ($data['blotters'] as $row) {
            fputcsv($output, [
                $row['id'],
                $row['c_name'],
                $row['r_name'],
                $row['type'],
                $row['status'],
                $row['details'],
                date('Y-m-d H:i:s', strtotime($row['date_time']))
            ]);
        }
        fputcsv($output, []);
        fputcsv($output, ['Complaint Reports']);
        fputcsv($output, ['Case No.', 'Complainant', 'Respondent', 'Type', 'Status', 'Details', 'Date']);
        foreach ($data['complaints'] as $row) {
            fputcsv($output, [
                $row['id'],
                $row['c_name'],
                $row['r_name'],
                $row['type'],
                $row['status'],
                $row['details'],
                date('Y-m-d H:i:s', strtotime($row['date_time']))
            ]);
        }
    } else {
        $title = ucfirst($reportType) . ' Reports';
        fputcsv($output, [$title]);
        fputcsv($output, ['Case No.', 'Complainant', 'Respondent', 'Type', 'Details', 'Date']);
        foreach ($data[$reportType.'s'] as $row) {
            fputcsv($output, [
                $row['id'],
                $row['c_name'],
                $row['r_name'],
                $row['type'],
                $row['details'],
                date('Y-m-d H:i:s', strtotime($row['date_time']))
            ]);
        }
    }

    fclose($output);

    // Insert document record after successful file generation
    // Only insert document record if user is logged in
    if (isset($_SESSION['user_id'])) {
        try {
            $insertDoc = $conn->prepare("INSERT INTO documents (case_id, document_type, from_date, to_date, file_path, generated_by, generated_at) VALUES (NULL, :type, :from_date, :to_date, :file_path, :user_id, NOW())");
            $insertDoc->execute([
                ':from_date' => $dateFrom,
                ':to_date' => $dateTo,
                ':type' => $reportType,
                ':file_path' => $filename,
                ':user_id' => $_SESSION['user_id']
            ]);
            error_log("Successfully inserted document record for file: " . $filename);
        } catch (PDOException $e) {
            error_log("Error inserting document record: " . $e->getMessage());
        }
    }
    exit;



    if ($reportType === 'all') {
        if (!empty($data['blotters'])) {
            fputcsv($output, ['Blotter Reports']);
            fputcsv($output, ['Case No.', 'Complainant', 'Respondent', 'Type', 'Status', 'Details', 'Date']);
            foreach ($data['blotters'] as $row) {
                fputcsv($output, [
                    $row['B-'.$row['id']],
                    $row['c_name'],
                    $row['r_name'],
                    $row['type'],
                    $row['status'],
                    $row['details'],
                    $row['date_time']
                ]);
            }
            fputcsv($output, []);
        }
        
        if (!empty($data['complaints'])) {
            fputcsv($output, ['Complaint Reports']);
            fputcsv($output, ['Case No.', 'Complainant', 'Respondent', 'Type', 'Status', 'Details', 'Date']);
            foreach ($data['complaints'] as $row) {
                fputcsv($output, [
                    $row['C-'.$row['id']],
                    $row['c_name'],
                    $row['r_name'],
                    $row['type'],
                    $row['status'],
                    $row['details'],
                    $row['date_time']
                ]);
            }
        }
    } else {
        $title = ucfirst($reportType) . ' Reports';
        fputcsv($output, [$title]);
        
        if (!empty($data[$reportType.'s'])) {
            fputcsv($output, ['Case No.', 'Complainant', 'Respondent', 'Type', 'Details', 'Date']);
            foreach ($data[$reportType.'s'] as $row) {
                fputcsv($output, [
                    $row['id'],
                    $row['c_name'],
                    $row['r_name'],
                    $row['type'],
                    $row['details'],
                    $row['date_time']
                ]);
            }
        } else {
            fputcsv($output, ['No records found for the selected date range']);
        }
    }

    fclose($output);
    exit;
}
?>

<div id="reportModal" class="fixed inset-0 backdrop-blur-sm z-100 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Generate Report</h3>
            <button onclick="closeReportModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="reportForm" action="generate_report_modal.php" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Report Type</label>
                <select name="report_type" class="border rounded w-full py-2 px-3 text-gray-700">
                    <option value="all">All Types</option>
                    <option value="blotter">Blotter Only</option>
                    <option value="complaint">Complaint Only</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Date Range</label>
                <div class="flex items-center gap-2">
                    <input type="date" name="date_from" class="border rounded w-full py-2 px-3 text-gray-700">
                    <span>to</span>
                    <input type="date" name="date_to" class="border rounded w-full py-2 px-3 text-gray-700">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openReportModal() {
    document.getElementById('reportModal').classList.remove('hidden');
}

function closeReportModal() {
    document.getElementById('reportModal').classList.add('hidden');
}
</script>