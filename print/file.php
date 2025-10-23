<?php
require 'vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $r_name = $_POST['r_name'];
    $c_name = $_POST['c_name'];
    $day =$_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $date = $year . '-' . $month . '-' . $day;
    $type = $_POST['type'];
    $time = date('H');
    $location = $_POST['location'];


    // Load Word template
    $templateProcessor = new TemplateProcessor('summon.docx');
    
$templateProcessor->setValue('id', $id);
$templateProcessor->setValue('r_name', $r_name);
$templateProcessor->setValue('c_name', $c_name);
$templateProcessor->setValue('date', $date);
$templateProcessor->setValue('type', $type);
$templateProcessor->setValue('time', $time);
$templateProcessor->setValue('day', $day);
$templateProcessor->setValue('month', $month);
$templateProcessor->setValue('year', $year);
$templateProcessor->setValue('location', $location);



    // Save new file
    $newFile = 'filled_document.docx';
    $templateProcessor->saveAs($newFile);

    // Serve file to browser for download
    header('Content-Description: File Transfer');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="'.basename($newFile).'"');
readfile($newFile);

    exit;
}
?>

        