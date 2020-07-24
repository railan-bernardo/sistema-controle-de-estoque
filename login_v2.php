<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('admin.php', false);}
?>

<div class="login-page">
    <div class="text-center">
       <h1>Seja Bem Vindo</h1>
       <p>Faça login para iniciar sua sessão</p>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="auth_v2.php" class="clearfix">
        <div class="form-group">
              <label for="username" class="control-label">Nome do usuário</label>
              <input type="name" class="form-control" name="username" placeholder="Nome do usuário">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Senha</label>
            <input type="password" name= "password" class="form-control" placeholder="Senha">
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-info  pull-right">Login</button>
        </div>
    </form>
</div>
<?php include_once('layouts/header.php'); ?>
