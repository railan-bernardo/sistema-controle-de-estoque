<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $product = find_by_id('client',(int)$_GET['id']);
  if(!$product){
    $session->msg("d","ID Vazio");
    redirect('client.php');
  }
?>
<?php
  $delete_id = delete_by_id('client',(int)$product['id']);
  if($delete_id){
      $session->msg("s","Cliente Excluido");
      redirect('client.php');
  } else {
      $session->msg("d","Falhou a Exclusão");
      redirect('client.php');
  }
?>