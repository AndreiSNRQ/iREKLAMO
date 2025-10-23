<?php
require 'vendor/autoload.php';
require '../config.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Get parameters from either POST or GET
$id = $_REQUEST['id'] ?? null;
$day = $_REQUEST['day'] ?? null;
$month = $_REQUEST['month'] ?? null;
$year = $_REQUEST['year'] ?? null;
$time = $_REQUEST['time'] ?? null;

if ($id && $day && $month && $year && $time) {
    
    // Get blotter details from database
    if (!isset($conn)) {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    $stmt = $conn->prepare("SELECT c_name, r_name, type FROM blotter WHERE id = ?");
    $stmt->execute([$id]);
    $blotter = $stmt->fetch();
    
    if (!$blotter) {
        die("Blotter record not found");
    }
    
    // Update blotter status to 'summon'
    $stmt = $conn->prepare("SELECT status FROM blotter WHERE id = ?");
    $stmt->execute([$id]);
    $currentStatus = $stmt->fetchColumn();

    if ($currentStatus === 'summon') {
        $updateStmt = $conn->prepare("UPDATE blotter SET status = 'summon 2' WHERE id = ?");
        $updateStmt->execute([$id]);
    } elseif ($currentStatus === 'summon 2') {
        $updateStmt = $conn->prepare("UPDATE blotter SET status = 'summon 3' WHERE id = ?");
        $updateStmt->execute([$id]);
    } else {
        $updateStmt = $conn->prepare("UPDATE blotter SET status = 'summon' WHERE id = ?");
        $updateStmt->execute([$id]);
    }
    
    $c_name = $blotter['c_name'];
    $r_name = $blotter['r_name'];
    $type = $blotter['type'];

    // Load template
    $templateProcessor = new TemplateProcessor('summons.docx');
    
    $templateProcessor->setValue('id', $id);
    $templateProcessor->setValue('r_name', $r_name);
    $templateProcessor->setValue('c_name', $c_name);
    $templateProcessor->setValue('day', $day);
    $templateProcessor->setValue('month', $month);
    $templateProcessor->setValue('year', $year);
    $templateProcessor->setValue('type', $type);
    $templateProcessor->setValue('time', $time);

    // Ensure summons directory exists
    if (!is_dir('files/summons')) {
        mkdir('files/summons', 0777, true);
    }
    
    // Save new file with sanitized filename
    $sanitized_name = preg_replace('/[^\w\s.-]/', '', $c_name);
    $newFile = 'files/summons/summons_'.$sanitized_name.'.docx';
    
    try {
        $templateProcessor->saveAs($newFile);
    } catch (Exception $e) {
        die('Error saving file: '.$e->getMessage());
    }

    // Serve file to browser for download
    if (!file_exists($newFile)) {
        die('Error: Failed to generate document');
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="'.basename($newFile).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($newFile));
     flush();
     readfile($newFile);
     unlink($newFile);
     
     // Return success response for AJAX handling
     header('Content-Type: application/json');
     echo json_encode(['success' => false]);
     exit;
} else {
    die("Missing required parameters");
}
?>