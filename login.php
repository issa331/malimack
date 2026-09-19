<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/functions.php';
if (current_user()) redirect('index.php');
$error='';
if (is_post()) {
  verify_csrf();
  $email=trim($_POST['email']??''); $password=$_POST['password']??'';
  $st=$pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1"); $st->execute([$email]); $u=$st->fetch();
  if($u && password_verify($password,$u['password'])) { session_regenerate_id(true); $_SESSION['user_id']=$u['id']; redirect('index.php'); }
  $error='Email ou mot de passe incorrect.';
}
$pageTitle='Connexion'; include __DIR__.'/includes/header.php';
?>
<div class="auth-wrap"><div class="auth-card"><span class="eyebrow">BIENVENUE</span><h1>Connexion</h1>
<?php if($error): ?><div class="alert alert-danger"><?=e($error)?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<label>Email</label><input class="form-control dark-input" type="email" name="email" required autocomplete="email">
<label>Mot de passe</label><input class="form-control dark-input" type="password" name="password" required autocomplete="current-password">
<button class="btn-gold w-100 mt-3">Se connecter</button></form>
<p class="auth-switch">Pas encore de compte ? <a href="register.php">Créer un compte</a></p></div></div>
<?php include __DIR__.'/includes/footer.php'; ?>
