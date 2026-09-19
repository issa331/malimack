<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/functions.php';
header('Content-Type: application/json; charset=utf-8');
$id=(int)($_POST['song_id']??0);
if(!$id){echo json_encode(['ok'=>false]);exit;}
$pdo->beginTransaction();
try{
  $pdo->prepare("UPDATE songs SET plays=plays+1 WHERE id=?")->execute([$id]);
  if(current_user()) $pdo->prepare("INSERT INTO history(user_id,song_id) VALUES(?,?)")->execute([current_user()['id'],$id]);
  $pdo->commit(); echo json_encode(['ok'=>true]);
}catch(Throwable $e){$pdo->rollBack(); echo json_encode(['ok'=>false]);}
?>
