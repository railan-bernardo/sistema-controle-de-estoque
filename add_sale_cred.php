<?php
  $page_title = 'Adicionar venda';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php

  if(isset($_POST['add_sale_cred'])){
    $req_fields = array('s_id','parcela','quantity','price','total', 'date' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$_POST['s_id']);
          $s_pa      = $db->escape($_POST['parcela']);
          $s_qty     = $db->escape((int)$_POST['quantity']);
          $s_total   = $db->escape($_POST['total']);
          $date      = $db->escape($_POST['date']);
          $s_date    = make_date();

          $sql  = "INSERT INTO sales (";
          $sql .= " product_id,qty,c_parcela,price,date";
          $sql .= ") VALUES (";
          $sql .= "'{$p_id}','{$s_pa}','{$s_qty}','{$s_total}','{$s_date}'";
          $sql .= ")";

                if($db->query($sql)){
                  update_product_qty($s_qty,$p_id);
                  $session->msg('s',"Venda Adicionada ");
                  redirect('add_sale_cred.php', false);
                } else {
                  $session->msg('d','O registro Falhou!');
                  redirect('add_sale_cred.php', false);
                }
        } else {
           $session->msg("d", $errors);
           redirect('add_sale_cred.php',false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajaxs.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Buscar</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Buscar pelo nome do produto">
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Editar venda</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale_cred.php">
         <table class="table table-bordered">
           <thead>
            <th> Produto </th>
            <th> Parcelas </th>
            <th> Débito / Crédito </th>
            <th> Quantidade </th>
            <th> Total </th>
            <th> Vendido em</th>
            <th> Ações</th>
           </thead>
             <tbody  id="product_infos"> </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
