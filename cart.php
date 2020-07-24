<?php

  $page_title = 'Agregar venta';
   require_once('includes/load.php');

  $connect = include_once('includes/db.php');
  // Checkin What level user has permission to view this page
  require_once('includes/add_product.php');
  require_once('includes/add_crt.php');
  //$product =  find_by_id('products',(int)$_GET['id']);


   if(isset($_GET['acao']) && in_array($_GET['acao'], array('add', 'del', 'up'))) {
		
    if($_GET['acao'] == 'add' && isset($_GET['id'])){ 
        addCart($product['id'], 1);			
    }

    // if($_GET['acao'] == 'del' && isset($_GET['id']) && preg_match("/^[0-9]+$/", $_GET['id'])){ 
    //     deleteCart($_GET['id']);
    // }

    // if($_GET['acao'] == 'up'){ 
    //     if(isset($_POST['prod']) && is_array($_POST['prod'])){ 
    //         foreach($_POST['prod'] as $id => $qtd){
    //                 updateCart($id, $qtd);
    //         }
    //     }
    // } 
    header('location: cart.php');
 }
 $getResultCarts = getContentCart($connect);

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
        <h1>Carrinho <i class="glyphicon glyphicon-shopping-cart"></i></h1>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Finalizar venda</span>
       </strong>
      </div>
  
      <div class="panel-body">
         <table class="table table-bordered">
           <thead>
           <th> Cliente </th>
           <th> Vendedor </th>
            <th> Produto </th>
            <th> Pagamento </th>
            <th> Parcelas </th>
            <th> Quantidade </th>
            <th> Preço/UN </th>
            <th> Sub Total </th>
            <th> Total </th>
            <th> Ações</th>
           </thead>
             <tbody  id="product_info">
             <?php foreach($getContentCart as $product): ?>
                <tr>
                    <td><input type="text" class="form-control" value="Cliente fulano"/></td>
                    <td><input type="text" class="form-control" value="Vendedor"/></td>
                    <td><input type="text" class="form-control" value="<?php echo $product['name']; ?>"/></td>
                    <td>
                        <select class="form-control">
                                <option value="<?php  ?>">Dinheiro ou Transferência</option>
                                <option value="<?php  ?>">Crédito ou Débito</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" value="<?php  ?>"/></td>
                    <td><input type="text" class="form-control" value="<?php  ?>"/></td>
                    <td><input type="text" class="form-control" value="<?php  ?>"/></td>
                    <td><input type="text" class="form-control" value="<?php  ?>"/></td>
                    <td>
                    <button type="button"  class="btn btn-success" id="add"><i class="glyphicon glyphicon-shopping-cart"></i></button>";
                    </td>
                </tr>
             <?php endforeach; ?>
             </tbody>
         </table>
         <a href="add_sale.php" class="btn btn-small btn-primary">Continuar Comprando</a>
      </div>
           
    </div>
  </div>

</div>


<?php include_once('layouts/footer.php'); ?>
