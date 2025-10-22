<?php
header('Access-Control-Allow-Origin: http://localhost:8000'); // Add this line
include 'config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and validate form data
    $errors = [];
    
    // Required fields validation
    $required = ['c_name', 'r_name', 'details', 'location'];
    foreach ($required as $field) {
        if (empty(trim($_POST[$field] ?? ''))) {
            $errors[$field] = "This field is required";
        }
    }
    
    // Contact number validation
    if (!empty($_POST['c_contact']) && !preg_match('/^[0-9]{10,11}$/', $_POST['c_contact'])) {
        $errors['c_contact'] = "Invalid contact number format";
    }
    
    if (!empty($_POST['r_contact']) && !preg_match('/^[0-9]{10,11}$/', $_POST['r_contact'])) {
        $errors['r_contact'] = "Invalid contact number format";
    }
    
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }
    
    // Process valid data
    $c_name = trim($_POST['c_name']);
    $c_contact = trim($_POST['c_contact'] ?? '');
    $c_address = trim($_POST['c_address'] ?? '');
    $r_name = trim($_POST['r_name']);
    $r_contact = trim($_POST['r_contact'] ?? '');
    $r_address = trim($_POST['r_address'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $details = trim($_POST['details']);
    $location = trim($_POST['location']);
    $date_time = trim($_POST['date'] ?? '') ?: date('Y-m-d H:i:s');

    try {
        // First verify table structure
        $stmt = $conn->query("DESCRIBE blotter");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        $requiredColumns = ['c_name', 'c_contact', 'c_address', 'r_name', 'r_contact', 'r_address', 'type', 'details', 'location', 'date_time'];
        $missingColumns = array_diff($requiredColumns, $columns);
        
        if (!empty($missingColumns)) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Database table missing columns: ' . implode(', ', $missingColumns)]);
            exit;
        }
        
        // Check if update_at column exists
        $hasUpdateAt = in_array('update_at', $columns);
        
        $sql = "INSERT INTO blotter 
                (c_name, c_contact, c_address, r_name, r_contact, r_address, type, details, location, date_time" . 
                ($hasUpdateAt ? ", update_at)" : ")") . 
                " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?" . 
                ($hasUpdateAt ? ", ?)" : ")");
        
        $params = [
            $c_name, $c_contact, $c_address, 
            $r_name, $r_contact, $r_address,
            $type, $details, $location,
            $date_time
        ];
        
        if ($hasUpdateAt) {
            $params[] = date('Y-m-d H:i:s');
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        echo json_encode(['success' => true, 'message' => 'Blotter added successfully']);
        exit;
    } catch (PDOException $e) {
        error_log('Database Error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage(), 'full_error' => $e->__toString()]);
        exit;
    }
}

http_response_code(400);
echo json_encode(['success' => false, 'error' => 'Invalid request method']);
exit;
?>