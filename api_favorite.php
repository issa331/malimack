<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/functions.php';
header('Content-Type: application/json; charset=utf-8');
if(!current_user()){http_response_code(401); echo json_encode(['ok'=>false,'login'=>true]); exit;}
$id=(int)($_POST['song_id']??0); $u=current_user();
$st=$pdo->prepare("SELECT id FROM favorites WHERE user_id=? AND song_id=?"); $st->execute([$u['id'],$id]); $f=$st->fetch();
if($f){$pdo->prepare("DELETE FROM favorites WHERE id=?")->execute([$f['id']]); echo json_encode(['ok'=>true,'favorite'=>false]);}
else{$pdo->prepare("INSERT INTO favorites(user_id,song_id) VALUES(?,?)")->execute([$u['id'],$id]); echo json_encode(['ok'=>true,'favorite'=>true]);}
?>
