<?php include_once('includes/load.php'); ?>
<?php
$req_fields = array('username','password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

  if(empty($errors)){

    $user = authenticate_v2($username, $password);

        if($user):
           //create session with id
           $session->login($user['id']);
           //Update Sign in time
           updateLastLogIn($user['id']);
           // redirect user to group home page by user level
           if($user['user_level'] === '1'):
             $session->msg("s", "Ola ".$user['username'].", Bem Vindos ao Controle de Estoque da CA Cursos.");
             redirect('admin.php',false);
           elseif ($user['user_level'] === '2'):
              $session->msg("s", "Ola ".$user['username'].", Bem Vindos ao Controle de Estoque da CA Cursos.");
             redirect('admin.php',false);
           else:
              $session->msg("s", "Ola ".$user['username'].", Bem Vindos ao Controle de Estoque da CA Cursos.");
             redirect('admin.php',false);
           endif;

        else:
          $session->msg("d", "Desculpe nome de usuário / senha incorretos.");
          redirect('/',false);
        endif;

  } else {

     $session->msg("d", $errors);
     redirect('login_v2.php',false);
  }

?>
