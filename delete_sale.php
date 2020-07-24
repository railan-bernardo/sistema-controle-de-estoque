<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php
  $d_sale = find_by_id('ordercarts',(int)$_GET['id']);
  if(!$d_sale){
    $session->msg("d","ID Vazio.");
    redirect('sales.php');
  }
?>
<?php
  $delete_id = delete_by_id('ordercarts',(int)$d_sale['id']);
  if($delete_id){
      $session->msg("s","Venda Excluida.");
      redirect('sales.php');
  } else {
      $session->msg("d","Falhou ao Excluir");
      redirect('sales.php');
  }
?>
