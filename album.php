<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/functions.php';
$id=(int)($_GET['id']??0);
$st=$pdo->prepare("SELECT al.*, ar.name artist_name FROM albums al JOIN artists ar ON ar.id=al.artist_id WHERE al.id=?"); $st->execute([$id]); $album=$st->fetch();
if(!$album){ http_response_code(404); exit('Album introuvable.'); }
$st=$pdo->prepare("SELECT s.*, ar.name artist_name FROM songs s JOIN artists ar ON ar.id=s.artist_id WHERE s.album_id=? ORDER BY s.id"); $st->execute([$id]); $songs=$st->fetchAll();
$pageTitle=$album['title']; include __DIR__.'/includes/header.php';
?>
<section class="album-hero"><img src="<?=e($album['cover']?:asset('assets/icons/default-cover.svg'))?>" alt=""><div><span class="eyebrow">ALBUM</span><h1><?=e($album['title'])?></h1><a href="artist.php?id=<?=(int)$album['artist_id']?>"><?=e($album['artist_name'])?></a><p><?=$album['release_year']?> · <?=count($songs)?> morceau<?=count($songs)>1?'s':''?></p><p><?=nl2br(e($album['description']))?></p><button class="btn-gold" onclick='playAlbum(<?=json_encode(array_map(fn($s)=>["id"=>(int)$s["id"],"title"=>$s["title"],"artist"=>$s["artist_name"],"cover"=>$s["cover"],"audio"=>$s["audio_file"]],$songs),JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT)?>)'><i class="fa-solid fa-play"></i> Tout écouter</button></div></section>
<section class="section"><div class="song-list"><?php foreach($songs as $i=>$s): ?><div class="song-row"><span class="track-number"><?=str_pad((string)($i+1),2,'0',STR_PAD_LEFT)?></span><img src="<?=e($s['cover']?:$album['cover']?:asset('assets/icons/default-cover.svg'))?>" alt=""><div><strong><?=e($s['title'])?></strong><small><?=e($s['genre'])?></small></div><button onclick='playSong(<?=json_encode(["id"=>(int)$s["id"],"title"=>$s["title"],"artist"=>$s["artist_name"],"cover"=>$s["cover"]?:$album["cover"],"audio"=>$s["audio_file"]],JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT)?>)' class="round-play"><i class="fa-solid fa-play"></i></button></div><?php endforeach; ?></div></section>
<?php include __DIR__.'/includes/footer.php'; ?>
