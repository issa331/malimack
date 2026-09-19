<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/functions.php';
$id=(int)($_GET['id']??0);
$st=$pdo->prepare("SELECT * FROM artists WHERE id=?"); $st->execute([$id]); $artist=$st->fetch();
if(!$artist){ http_response_code(404); exit('Artiste introuvable.'); }
$st=$pdo->prepare("SELECT s.*, a.name artist_name FROM songs s JOIN artists a ON a.id=s.artist_id WHERE s.artist_id=? ORDER BY s.plays DESC LIMIT 30"); $st->execute([$id]); $songs=$st->fetchAll();
$st=$pdo->prepare("SELECT al.*, COUNT(s.id) song_count FROM albums al LEFT JOIN songs s ON s.album_id=al.id WHERE al.artist_id=? GROUP BY al.id ORDER BY al.created_at DESC"); $st->execute([$id]); $albums=$st->fetchAll();
$pageTitle=$artist['name']; include __DIR__.'/includes/header.php';
?>
<section class="artist-hero"><img src="<?=e($artist['photo']?:asset('assets/icons/default-avatar.svg'))?>" alt=""><div><span class="eyebrow">ARTISTE</span><h1><?=e($artist['name'])?></h1><p><?=nl2br(e($artist['bio']))?></p></div></section>
<section class="section"><div class="section-head"><h2>Musiques populaires</h2></div><div class="song-list"><?php foreach($songs as $s): ?><div class="song-row"><img src="<?=e($s['cover']?:asset('assets/icons/default-cover.svg'))?>" alt=""><div><strong><?=e($s['title'])?></strong><small><?=e($s['genre'])?> · <?=number_format((int)$s['plays'])?> lectures</small></div><button onclick='playSong(<?=json_encode(["id"=>(int)$s["id"],"title"=>$s["title"],"artist"=>$s["artist_name"],"cover"=>$s["cover"],"audio"=>$s["audio_file"]],JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT)?>)' class="round-play"><i class="fa-solid fa-play"></i></button></div><?php endforeach; ?></div></section>
<section class="section"><div class="section-head"><h2>Albums</h2></div><div class="album-grid"><?php foreach($albums as $al): ?><a class="album-card" href="album.php?id=<?=(int)$al['id']?>"><img loading="lazy" src="<?=e($al['cover']?:asset('assets/icons/default-cover.svg'))?>" alt=""><strong><?=e($al['title'])?></strong><small><?=$al['release_year']?> · <?=$al['song_count']?> titres</small></a><?php endforeach; ?></div></section>
<?php include __DIR__.'/includes/footer.php'; ?>
