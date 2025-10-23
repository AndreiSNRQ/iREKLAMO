<?php
require_once 'config.php';
header('Content-Type: application/json');

// get months range (last 12 months)
$months = [];
for ($i = 11; $i >= 0; $i--) {
    $m = new DateTime("first day of -$i month");
    $key = $m->format('Y-m'); // YYYY-MM
    $label = $m->format('M Y'); // Oct 2024
    $months[$key] = $label;
}

// complaints per month (active only by default)
$complaintsPerMonth = array_fill_keys(array_keys($months), 0);
$sql = "SELECT DATE_FORMAT(date_time, '%Y-%m') AS ym, COUNT(*) AS cnt
        FROM complaint
        WHERE status <> 'archived' AND status <> 'transfer'
        AND date_time >= DATE_SUB(CURRENT_DATE, INTERVAL 11 MONTH)
        GROUP BY ym";
foreach ($conn->query($sql, PDO::FETCH_ASSOC) as $r) {
    if (isset($complaintsPerMonth[$r['ym']])) $complaintsPerMonth[$r['ym']] = (int)$r['cnt'];
}

// resolved per month
$resolvedPerMonth = array_fill_keys(array_keys($months), 0);
$sql2 = "SELECT DATE_FORMAT(date_time, '%Y-%m') AS ym, COUNT(*) AS cnt
         FROM complaint
         WHERE status = 'resolved'
         AND date_time >= DATE_SUB(CURRENT_DATE, INTERVAL 11 MONTH)
         GROUP BY ym";
foreach ($conn->query($sql2, PDO::FETCH_ASSOC) as $r) {
    if (isset($resolvedPerMonth[$r['ym']])) $resolvedPerMonth[$r['ym']] = (int)$r['cnt'];
}

// blotter trends per type (counts per month)
// gather distinct types
$typeRows = $conn->query("SELECT DISTINCT type FROM blotter")->fetchAll(PDO::FETCH_COLUMN);
$blotterTrends = [];
foreach ($typeRows as $type) {
    $row = array_fill_keys(array_keys($months), 0);
    $sql3 = "SELECT DATE_FORMAT(date_time, '%Y-%m') AS ym, COUNT(*) AS cnt FROM blotter
             WHERE type = :type AND date_time >= DATE_SUB(CURRENT_DATE, INTERVAL 11 MONTH)
             GROUP BY ym";
    $stmt = $conn->prepare($sql3);
    $stmt->execute([':type' => $type]);
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (isset($row[$r['ym']])) $row[$r['ym']] = (int)$r['cnt'];
    }
    $blotterTrends[$type] = $row;
}

// totals
$totalBlotter = (int)$conn->query("SELECT COUNT(*) FROM blotter")->fetchColumn();
$totalComplaints = (int)$conn->query("SELECT COUNT(*) FROM complaint WHERE status NOT IN ('archived','transfer')")->fetchColumn();
$totalResolved = (int)$conn->query("SELECT COUNT(*) FROM complaint WHERE status = 'resolved'")->fetchColumn();

echo json_encode([
    'months' => array_values($months),
    'complaintsPerMonth' => array_values($complaintsPerMonth),
    'resolvedPerMonth' => array_values($resolvedPerMonth),
    'blotterTrends' => $blotterTrends,
    'totals' => [
        'totalBlotter' => $totalBlotter,
        'totalComplaints' => $totalComplaints,
        'totalResolved' => $totalResolved
    ]
]);
