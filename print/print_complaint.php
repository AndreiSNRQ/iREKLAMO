<?php
require 'vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Check if form data is provided
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Error: Invalid request method");
}

// Get form data
$id = $_POST['id'];
$c_name = $_POST['c_name'];
$r_name = $_POST['r_name'];
$type = $_POST['type'];
$details = $_POST['details'];
$date = $_POST['date']; // Changed from $_POST['date_time'] to $_POST['date']
try {
    
    // Load Word template
    $templateProcessor = new TemplateProcessor('complaint.docx');
    
    // Set values in template
    $templateProcessor->setValue('id', $id);
    $templateProcessor->setValue('c_name', $c_name);
    $templateProcessor->setValue('r_name', $r_name);
    $templateProcessor->setValue('type', $type);
    $templateProcessor->setValue('details', $details);
    
    $dateObj = new DateTime($date);
    $templateProcessor->setValue('month', $dateObj->format('F'));
    $templateProcessor->setValue('day', $dateObj->format('j'));
    $templateProcessor->setValue('year', $dateObj->format('Y'));
    
    // Save filled document
    $newFile = 'filled_complaint_' . $id . '.docx';
    $templateProcessor->saveAs($newFile);
    
    // Output for download
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="'.basename($newFile).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($newFile));
    readfile($newFile);
    exit;
    
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
} catch (Exception $e) {
    die("Error processing document: " . $e->getMessage());
}
?>