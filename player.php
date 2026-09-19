<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/functions.php';
$id=(int)($_GET['id']??0);
$st=$pdo->prepare("SELECT s.*, ar.name artist_name FROM songs s JOIN artists ar ON ar.id=s.artist_id WHERE s.id=?"); $st->execute([$id]); $s=$st->fetch();
if(!$s) exit('Morceau introuvable.');
header('Content-Type: application/json; charset=utf-8');
echo json_encode(["id"=>(int)$s['id'],"title"=>$s['title'],"artist"=>$s['artist_name'],"cover"=>$s['cover'],"audio"=>$s['audio_file'],"downloadable"=>(int)$s['downloadable']]);
?>
