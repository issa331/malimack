<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/functions.php';
require_login(); $user=current_user();
$st=$pdo->prepare("SELECT s.*, ar.name artist_name FROM favorites f JOIN songs s ON s.id=f.song_id JOIN artists ar ON ar.id=s.artist_id WHERE f.user_id=? ORDER BY f.created_at DESC"); $st->execute([$user['id']]); $songs=$st->fetchAll();
$pageTitle='Favoris'; include __DIR__.'/includes/header.php';
?>
<section class="section"><div class="section-head"><div><span class="eyebrow">MA COLLECTION</span><h1>Mes favoris</h1></div></div>
<?php if(!$songs): ?><div class="empty-state"><i class="fa-regular fa-heart"></i><h2>Aucun favori</h2><p>Ajoute tes morceaux préférés pour les retrouver ici.</p></div><?php else: ?><div class="song-list"><?php foreach($songs as $s): ?><div class="song-row"><img src="<?=e($s['cover']?:asset('assets/icons/default-cover.svg'))?>" alt=""><div><strong><?=e($s['title'])?></strong><small><?=e($s['artist_name'])?></small></div><button onclick='playSong(<?=json_encode(["id"=>(int)$s["id"],"title"=>$s["title"],"artist"=>$s["artist_name"],"cover"=>$s["cover"],"audio"=>$s["audio_file"]],JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT)?>)' class="round-play"><i class="fa-solid fa-play"></i></button></div><?php endforeach; ?></div><?php endif; ?></section>
<?php include __DIR__.'/includes/footer.php'; ?>
