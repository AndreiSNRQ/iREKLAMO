<?php
require "../config.php";
$id = intval($_GET['id'] ?? 0);
$q = $pdo->prepare("SELECT * FROM complaints WHERE id=? LIMIT 1");
$q->execute([$id]);
$data = $q->fetch(PDO::FETCH_ASSOC);
echo json_encode(["success"=>$data?true:false,"data"=>$data]);
?>
