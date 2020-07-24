<?php
  $page_title = 'Comfirmar Pagamento';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);

?>
<?php
$sale = find_by_id('ordercarts',(int)$_GET['id']);

if(!$sale){
  $session->msg("d","ID da venda ausente.");
  redirect('sales.php');
}
?>
<?php $product = find_by_id('ordercarts',$sale['product_ids']); ?>
<?php

  if(isset($_POST['update_sale'])){
    $req_fields = array('statu' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$sale['product_ids']);
          $s_statu     = $db->escape($_POST['statu']);

          $sql  = "UPDATE ordercarts SET";
          $sql .= " product_ids= '{$p_id}',statuss='{$s_statu}'";
          $sql .= " WHERE id ='{$sale['id']}'";
          $result = $db->query($sql);

          $session->msg("s","Pagamento Comfirmado.");
        } else {
           $session->msg("d", $errors);
           redirect('edit_sale.php?id='.(int)$sale['id'],false);
        }
        redirect('sales.php');
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
  <div class="panel">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Comfirmar Pagamento</span>
     </strong>
     <div class="pull-right">
       <a href="sales.php" class="btn btn-info">Mostrar todas as Vendas</a>
     </div>
    </div>

    <div class="panel-body">
       <table class="table table-bordered">
         <thead>
          <th> Status </th>
         </thead>
           <tbody  id="product_info">
              <tr>
              <form method="post" action="edit_sale.php?id=<?php echo (int)$sale['id']; ?>">
                <td id="s_name">
                  <select name="statu" class="form-control">
                    <option value="<?php echo remove_junk($product['statuss']); ?>">Pendente</option>
                    <option value="2">Comfirmardo</option>
                  </select>
                 
                </td>
                <td>
                  <button type="submit" name="update_sale" class="btn btn-success">Comfirmar Pagamento</button>
                </td>
              </form>
              </tr>
           </tbody>
       </table>

    </div>
  </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
