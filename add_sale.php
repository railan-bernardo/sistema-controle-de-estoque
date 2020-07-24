<?php

  $page_title = 'Adicionar venda';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php

  if(isset($_POST['add_sale'])){
    $req_fields = array('s_id','quantity','price','total','date');
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$_POST['s_id']);
          $s_qty     = $db->escape($_POST['quantity']);
          $s_price     = $db->escape($_POST['total']);
          $date      = $db->escape($_POST['date']);
          $s_date    = make_date();

          $sql  = "INSERT INTO sales (";
          $sql .= " product_id,qty,price,date";
          $sql .= ") VALUES (";
          $sql .= "'{$p_id}','{$s_qty}','{$s_price}','{$date}'";
          $sql .= ")";

                if($db->query($sql)){
                  update_product_qty($s_qty,$p_id);
                  $session->msg('s',"Venta agregada ");
                  redirect('add_sale.php', false);
                } else {
                  $session->msg('d','Lo siento, registro falló.');
                  redirect('add_sale.php', false);
                }
        } else {
           $session->msg("d", $errors);
           redirect('add_sale.php',false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Buscar</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Procurar pelo nome">
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
          <span>Adicionar no Carrinho</span>
       </strong>
      </div>
      <div class="panel-body">
     
         <table class="table table-bordered">
           <thead>
            <th> Produto </th>
            <th> Modelo </th>
            <th> Preço Unitário / Dinheiro </th>
            <th> Preço Unitário / Crédito </th>
            <th> Ações</th>
           </thead>
             <tbody  id="product_info">

              </tbody>
         </table>
       
      </div>
    </div>
  </div>

</div>


<?php include_once('layouts/footer.php'); ?>
