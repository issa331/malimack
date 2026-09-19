<?php
require_once __DIR__.'/config/database.php';
require_once __DIR__.'/includes/functions.php';
$id=(int)($_GET['id']??0);
$st=$pdo->prepare("SELECT title,audio_file,downloadable FROM songs WHERE id=?");
$st->execute([$id]);$s=$st->fetch();
if(!$s || !(int)$s['downloadable']){http_response_code(403);exit('Téléchargement non autorisé.');}
$path=__DIR__.'/'.$s['audio_file'];
if(!is_file($path)){http_response_code(404);exit('Fichier introuvable.');}
$pdo->prepare("UPDATE songs SET downloads=downloads+1 WHERE id=?")->execute([$id]);
header('Content-Type: audio/mpeg');
header('Content-Length: '.filesize($path));
header('Content-Disposition: attachment; filename="'.preg_replace('/[^A-Za-z0-9._-]+/','_',basename($s['title'])).'.mp3"');
readfile($path);
exit;
?>