<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/functions.php';
if (current_user()) redirect('index.php');
$error='';
if (is_post()) {
  verify_csrf();
  $name=trim($_POST['name']??''); $email=trim($_POST['email']??''); $p=$_POST['password']??''; $c=$_POST['confirm']??'';
  if(mb_strlen($name)<2 || !filter_var($email,FILTER_VALIDATE_EMAIL)) $error='Informations invalides.';
  elseif(strlen($p)<8) $error='Le mot de passe doit contenir au moins 8 caractères.';
  elseif($p!==$c) $error='Les mots de passe ne correspondent pas.';
  else {
    $st=$pdo->prepare("SELECT id FROM users WHERE email=?"); $st->execute([$email]);
    if($st->fetch()) $error='Cet email est déjà utilisé.';
    else { $st=$pdo->prepare("INSERT INTO users(name,email,password,role) VALUES(?,?,?,'user')"); $st->execute([$name,$email,password_hash($p,PASSWORD_DEFAULT)]); redirect('login.php'); }
  }
}
$pageTitle='Inscription'; include __DIR__.'/includes/header.php';
?>
<div class="auth-wrap"><div class="auth-card"><span class="eyebrow">REJOINS MALIMACK</span><h1>Créer un compte</h1>
<?php if($error): ?><div class="alert alert-danger"><?=e($error)?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<label>Nom</label><input class="form-control dark-input" name="name" required>
<label>Email</label><input class="form-control dark-input" type="email" name="email" required>
<label>Mot de passe</label><input class="form-control dark-input" type="password" name="password" minlength="8" required>
<label>Confirmation</label><input class="form-control dark-input" type="password" name="confirm" minlength="8" required>
<button class="btn-gold w-100 mt-3">Créer mon compte</button></form>
<p class="auth-switch">Déjà inscrit ? <a href="login.php">Se connecter</a></p></div></div>
<?php include __DIR__.'/includes/footer.php'; ?>
