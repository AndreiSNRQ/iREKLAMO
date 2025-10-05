<?php
require_once 'config.php';
require_once 'residents.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['file_content'])) {
    echo json_encode(['error' => 'No file content provided']);
    exit;
}

try {
    $content = $_POST['file_content'];
    $result = processDocumentWithPython($content);
    
    if ($result === null) {
        throw new Exception('Python script returned no data');
    }
    
    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode([
        'error' => 'Document processing failed',
        'details' => $e->getMessage(),
        'python_error' => isset($output) ? implode("\n", $output) : null
    ]);
}
?>