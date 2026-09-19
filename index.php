<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Accueil';

$trending = $pdo->query("SELECT s.*, a.name artist_name FROM songs s JOIN artists a ON a.id=s.artist_id ORDER BY s.plays DESC, s.created_at DESC LIMIT 8")->fetchAll();
$new = $pdo->query("SELECT s.*, a.name artist_name FROM songs s JOIN artists a ON a.id=s.artist_id ORDER BY s.created_at DESC LIMIT 8")->fetchAll();
$artists = $pdo->query("SELECT ar.*, COUNT(s.id) song_count FROM artists ar LEFT JOIN songs s ON s.artist_id=ar.id GROUP BY ar.id ORDER BY song_count DESC, ar.name LIMIT 8")->fetchAll();
$albums = $pdo->query("SELECT al.*, ar.name artist_name, COUNT(s.id) song_count FROM albums al JOIN artists ar ON ar.id=al.artist_id LEFT JOIN songs s ON s.album_id=al.id GROUP BY al.id ORDER BY al.created_at DESC LIMIT 6")->fetchAll();

include __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="hero-content">
    <span class="eyebrow">PLATEFORME MUSICALE MALIENNE</span>
    <h1>La musique malienne,<br><span>partout avec toi.</span></h1>
    <p>Découvre les artistes, albums et sons qui font vibrer le Mali.</p>
    <div class="hero-actions"><a class="btn-gold" href="#tendances">Écouter maintenant <i class="fa-solid fa-play"></i></a><a class="btn-ghost" href="<?= asset('search.php') ?>">Découvrir</a></div>
  </div>
</section>

<section class="section" id="tendances">
  <div class="section-head"><div><span class="eyebrow">À L'ÉCOUTE</span><h2>Tendances</h2></div><a href="<?= asset('search.php') ?>">Voir tout <i class="fa-solid fa-arrow-right"></i></a></div>
  <div class="song-grid"><?php foreach($trending as $s): include __DIR__.'/includes/song-card.php'; endforeach; ?></div>
</section>

<section class="section">
  <div class="section-head"><div><span class="eyebrow">NOUVEAU</span><h2>Dernières sorties</h2></div></div>
  <div class="song-grid"><?php foreach($new as $s): include __DIR__.'/includes/song-card.php'; endforeach; ?></div>
</section>

<section class="section">
  <div class="section-head"><div><span class="eyebrow">DÉCOUVRE</span><h2>Artistes populaires</h2></div></div>
  <div class="artist-grid"><?php foreach($artists as $a): ?>
    <a class="artist-card" href="<?= asset('artist.php?id='.(int)$a['id']) ?>">
      <img loading="lazy" src="<?= e($a['photo'] ?: asset('assets/icons/default-avatar.svg')) ?>" alt="<?= e($a['name']) ?>">
      <strong><?= e($a['name']) ?></strong><small><?= (int)$a['song_count'] ?> morceau<?= $a['song_count']>1?'s':'' ?></small>
    </a>
  <?php endforeach; ?></div>
</section>

<section class="section">
  <div class="section-head"><div><span class="eyebrow">COLLECTIONS</span><h2>Albums</h2></div></div>
  <div class="album-grid"><?php foreach($albums as $al): ?>
    <a class="album-card" href="<?= asset('album.php?id='.(int)$al['id']) ?>">
      <img loading="lazy" src="<?= e($al['cover'] ?: asset('assets/icons/default-cover.svg')) ?>" alt="<?= e($al['title']) ?>">
      <strong><?= e($al['title']) ?></strong><small><?= e($al['artist_name']) ?> · <?= (int)$al['release_year'] ?></small>
    </a>
  <?php endforeach; ?></div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
