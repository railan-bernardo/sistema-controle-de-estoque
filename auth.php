<?php include_once('includes/load.php'); ?>
<?php
$req_fields = array('login','senha' );
validate_fields($req_fields);
$username = remove_junk($_POST['login']);
$password = remove_junk($_POST['senha']);

if(empty($errors)){
  $user_id = authenticate($username, $password);
  if($user_id){
    //create session with id
     $session->login($user_id);
    //Update Sign in time
     updateLastLogIn($user_id);
     $session->msg("s", "Bem Vindos ao Controle de Estoque da CA Cursos.");
     redirect('admin.php',false);

  } else {
    $session->msg("d", "Nome de usuario ou Senha incorreto!");
    redirect('/',false);
  }

} else {
   $session->msg("d", $errors);
   redirect('/',false);
}

?>
