<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/functions.php';
require_login(); $user=current_user(); $error='';
if(is_post()){ verify_csrf(); $action=$_POST['action']??'';
 if($action==='create'){ $name=trim($_POST['name']??''); if($name!==''){ $st=$pdo->prepare("INSERT INTO playlists(user_id,name) VALUES(?,?)"); $st->execute([$user['id'],$name]); } }
 if($action==='delete'){ $id=(int)$_POST['id']; $st=$pdo->prepare("DELETE FROM playlists WHERE id=? AND user_id=?"); $st->execute([$id,$user['id']]); }
 redirect('playlist.php');
}
$st=$pdo->prepare("SELECT p.*, COUNT(ps.id) song_count FROM playlists p LEFT JOIN playlist_songs ps ON ps.playlist_id=p.id WHERE p.user_id=? GROUP BY p.id ORDER BY p.created_at DESC"); $st->execute([$user['id']]); $lists=$st->fetchAll();
$pageTitle='Playlists'; include __DIR__.'/includes/header.php';
?>
<section class="section"><div class="section-head"><div><span class="eyebrow">BIBLIOTHÈQUE</span><h1>Mes playlists</h1></div></div>
<form method="post" class="inline-create"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="create"><input class="form-control dark-input" name="name" placeholder="Nom de la nouvelle playlist" required><button class="btn-gold">Créer</button></form>
<div class="playlist-grid"><?php foreach($lists as $p): ?><div class="playlist-card"><div class="playlist-art"><i class="fa-solid fa-music"></i></div><strong><?=e($p['name'])?></strong><small><?=$p['song_count']?> morceau<?= $p['song_count']>1?'s':''?></small><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=$p['id']?>"><button class="danger-link" onclick="return confirm('Supprimer cette playlist ?')">Supprimer</button></form></div><?php endforeach; ?></div>
</section>
<?php include __DIR__.'/includes/footer.php'; ?>
