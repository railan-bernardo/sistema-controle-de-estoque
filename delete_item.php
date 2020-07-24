<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php
  $d_sale = find_by_id('sales',(int)$_GET['id']);
  if(!$d_sale){
    $session->msg("d","ID Vazio.");
    redirect('list_product.phpid='.(int)$ids['id'].'&date='.$_GET['date']);
  }
?>
<?php
  $delete_id = delete_by_id('sales',(int)$d_sale['id']);
  if($delete_id){
      $session->msg("s","Item Excluido.");
      redirect('list_product.phpid='.(int)$ids['id'].'&date='.$_GET['date']);
  } else {
      $session->msg("d","Falhou ao Excluir");
      redirect('list_product.phpid='.(int)$ids['id'].'&date='.$_GET['date']);
  }
?>
