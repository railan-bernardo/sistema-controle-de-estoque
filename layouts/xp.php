<?php
  $page_title = 'Editar produto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php


$product = find_by_id('products',$_GET['id']);

$products = join_product_table();
$all_categories = find_all('categories');
$all_status = find_all('status');
$all_photo = find_all('media');

?>
<?php

if(isset($_POST['add_sale'])){
    $req_fields = array('s_id','product-title','subtotal','quantity','price','total','ftotal','credit','status-pedido','date' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$_POST['s_id']);
          $s_qty     = $db->escape($_POST['quantity']);
          $s_price     = $db->escape($_POST['price']);
          $s_total   = $db->escape($_POST['total']);
          $s_ftotal   = $db->escape($_POST['ftotal']);
          $s_spayment   = $db->escape($_POST['status-pedido']);
          $s_credit   = $db->escape($_POST['credit']);
          $date      = $db->escape($_POST['date']);
          $s_date    = make_date();

          $sql  = "INSERT INTO sales (";
          $sql .= " product_id,qty,price,date,c_parcela,status_payment,price_total,f_total";
          $sql .= ") VALUES (";
          $sql .= "'{$p_id}','{$s_qty}','{$s_price}','{$s_date}','{$s_credit}','{$s_spayment}','{$s_total}','{$s_ftotal}'";
          $sql .= ")";

                if($db->query($sql)){
                  update_product_qty($s_qty,$p_id);
                  $session->msg('s',"Venda Adicionada ");
                  redirect('teste.php?id= echo (int)$product[id]', false);
                } else {
                  $session->msg('d','O registro Falhou!');
                  redirect('teste.php?id='.$product['id'], false);
                }
        } else {
           $session->msg("d", $errors);
           redirect('teste.php?id='.$product['id'], false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>

</div>
  <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Lançar Pedidos</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
           <form method="post" action="teste.php?id=<?php echo (int)$product['id'] ?>" id="product_info">
              <div class="form-group">
              <input type="hidden" class="form-control" name="s_id" value="<?php echo (int)$product['id']; ?>">
              <label>Nome</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']);?>">
               </div>
              </div>
              <!-- <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                  <label>Categoria</label>
                    <select class="form-control" name="product-categorie">
                    <option value="">Seleciona uma categoría</option>
                   <?php // foreach ($all_categories as $cat): ?>
                     <option value="<?php //echo (int)$cat['id']; ?>" <?php //if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                       <?php //echo remove_junk($cat['name']); ?></option>
                   <?php //endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-6">
                  <label>Foto</label>
                    <select class="form-control" name="product-photo">
                      <option value=""> Sem imagem</option>
                      <?php  //foreach ($all_photo as $photo): ?>
                        <option value="<?php //echo (int)$photo['id'];?>" <?php// if($product['media_id'] === $photo['id']): echo "selected"; endif; ?> >
                        <?php //echo $photo['file_name'];?></option>

                      <?php// endforeach; ?>
                    </select>
                    <?php
                       //// foreach ($products as $pro):
                           //if($product['media_id'] === $photo['id']): var_dump($photo['id']); endif;
                        //endforeach;
                    ?>
                  <?php //if($product['media_id'] === $photo['id']): var_dump($photo['id']);?>
                  
                  <img class="img-avatar img-circle" src="uploads/products/<?php //echo $photo['file_name']; ?>" alt="">
                <?php //endif; ?>
                  </div>
                </div>
              </div> -->

              <div class="form-group">
                <div class="row">
                  <!-- <div class="col-md-6">
                  <label>Marca</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-th-large"></i>
                     </span>
                     <input type="text" class="form-control" name="product-marca" value="<?php echo remove_junk($product['product_marca']);?>">
                  </div>
                  </div> -->
                  <div class="col-md-6">
                  
                    <label for="qty">Em Estoque</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-tags"></i>
                      </span>
                      <input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>">
                   </div>
                  </div>

                  <div class="col-md-6">
                  <label>Modelo</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-pushpin"></i>
                     </span>
                     <input type="text" class="form-control" name="product-model" value="<?php echo remove_junk($product['product_model']);?>">
                  </div>
                  </div>
                </div>
              </div>


              <div class="form-group">
              <!-- <div class="col-md-6">
              <label>Descrição (opcional)</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="description" value="<?php echo remove_junk($product['description']); ?>">
               </div>
              </div> -->

              <!-- <div class="col-md-6">
                     <label>Status</label>
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-th-large"></i>
                        </span>
                        <select class="form-control" name="status">
                        <?php  //foreach ($all_status as $st): ?>
                          <option value="<?php //echo (int)$st['id']; ?>" <?php //if($product['status_id'] === $st['id']): echo "selected"; endif; ?> >
                            <?php //if($st['statu'] == 1): echo 'Ativo'; else: echo 'Inativo'; endif; ?></option>
                        <?php// endforeach; ?>
                           
                        </select>
                      </div>
                  </div>
              </div> -->

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Quantidade</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-th"></i>
                      </span>
                      <input type="number" class="form-control" name="quantity" value="0">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                  <label>Forma de Pagamento</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                     
                      <select name="price" class="form-control" id="forma">
                            <option id="op1" selected value="<?php echo $product['sale_price']; ?>">Dinheiro ou Transferência</option>
                            <option id="op2" value="<?php echo $product['deb_credit']; ?>">Débito ou Crédito</option>
                       </select>
                      <span class="input-group-addon"><i class="glyphicon glyphicon-shopping-cart"></i></span>
                   </div>
                  </div>
                 </div>

                 <div class="col-md-4">
                  <div class="form-group">
                  <label>Parcelas</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-credit-card"></i>
                      </span>
                     
                      <select name="credit" class="form-control" id="forma2">
                            <option selected value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                       </select>
                      <span class="input-group-addon">x de</span>
                   </div>
                  </div>
                 </div>

                 <div class="col-md-4">
                   <div class="form-group">
                   <label>Data</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-calendar"></i>
                       </span>
                       <input type="date" class="form-control datePicker" name="date" data-date data-date-format="yyyy-mm-dd">
                     
                    </div>
                   </div>
                  </div>

                
                 <div class="col-md-4">
                  <div class="form-group">
                  <label>Status da Venda</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-hourglass"></i>
                      </span>
                     
                      <select name="status-pedido" class="form-control" id="forma">
                            <option selected value="1">A Vista</option>
                            <option selected value="2">Transferência</option>
                            <option selected value="3">Débito</option>
                            <option value="4">Crédito</option>
                       </select>
                      <span class="input-group-addon"></span>
                   </div>
                  </div>
                 </div>

                  <div class="col-md-4">
                   <div class="form-group">
                   <label>Preço unico</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-usd"></i>
                       </span>
                       <input type="text" class="form-control" name="subtotal" value="<?php echo $product['sale_price']; ?>">
                       <span class="input-group-addon">.00</span>
                    </div>
                   </div>
                  </div>


                  <div class="col-md-4">
                   <div class="form-group">
                   <label>Total a ser Pago</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-usd"></i>
                       </span>
                       <input type="text" class="form-control" name="total" value="<?php  echo $product['sale_price']; ?>">
                       <span class="input-group-addon">.00</span>
                    </div>
                   </div>
               </div>
               <div class="col-md-4">
                   <div class="form-group">
                   <label>Total Bruto</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-usd"></i>
                       </span>
                       <input type="text" class="form-control" name="ftotal" value="0">
                       <span class="input-group-addon">.00</span>
                    </div>
                   </div>
                   </div>
              </div>
              <button type="submit" name="add_sale" class="btn btn-success">Lançar Pedido</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
<script>
  function total(){
    $('#product_info input, select').change(function(e)  {
        var d = 15;
        var x1 = $('#op1').val();
        var x2 = $('#op2').val();
        var px = $('#forma2 option:selected').val();
        var txt = $('#forma option:selected').val();
            var price = +$('#forma option:selected').val() || 0;
            var qty   = +$('input[name=quantity]').val() || 0;
           
           // console.log(px);
            //console.log(x2);
            if(price == x1 || price == x2){
                var total = (qty * price) + 15;
                var ftotal = (qty * price) + 15;
                if(price == x2){
                  total = ((qty * price) + 15) / px;
                  
                }
            }else{
                var total = (qty * price) + 20;
            }
           
           
                $('input[name=total]').val(total.toFixed(2));
                $('input[name=subtotal]').val(txt);
                $('input[name=ftotal]').val(ftotal.toFixed(2));

        
                
              
    });
  }

  total();


</script>