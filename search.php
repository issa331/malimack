<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/functions.php';
$q=trim($_GET['q']??'');
$rows=[];
if($q!==''){
  $like='%'.$q.'%';
  $st=$pdo->prepare("SELECT s.*, ar.name artist_name FROM songs s JOIN artists ar ON ar.id=s.artist_id LEFT JOIN albums al ON al.id=s.album_id WHERE s.title LIKE ? OR ar.name LIKE ? OR al.title LIKE ? OR s.genre LIKE ? ORDER BY s.plays DESC LIMIT 50");
  $st->execute([$like,$like,$like,$like]); $rows=$st->fetchAll();
}
$pageTitle='Recherche'; include __DIR__.'/includes/header.php';
?>
<section class="section search-page"><div class="search-box"><form><div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input autofocus name="q" value="<?=e($q)?>" placeholder="Titre, artiste, album, genre..."></div></form></div>
<?php if($q===''): ?><div class="empty-state"><i class="fa-solid fa-music"></i><h2>Que veux-tu écouter ?</h2><p>Recherche parmi les musiques, artistes et albums de MALIMACK.</p></div>
<?php elseif(!$rows): ?><div class="empty-state"><i class="fa-solid fa-circle-question"></i><h2>Aucun résultat</h2><p>Essaie un autre mot-clé.</p></div>
<?php else: ?><div class="section-head"><h2>Résultats pour « <?=e($q)?> »</h2></div><div class="song-list"><?php foreach($rows as $s): ?><div class="song-row"><img src="<?=e($s['cover']?:asset('assets/icons/default-cover.svg'))?>" alt=""><div><strong><?=e($s['title'])?></strong><small><?=e($s['artist_name'])?></small></div><button onclick='playSong(<?=json_encode(["id"=>(int)$s["id"],"title"=>$s["title"],"artist"=>$s["artist_name"],"cover"=>$s["cover"],"audio"=>$s["audio_file"]],JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT)?>)' class="round-play"><i class="fa-solid fa-play"></i></button></div><?php endforeach; ?></div><?php endif; ?></section>
<?php include __DIR__.'/includes/footer.php'; ?>
