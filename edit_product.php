<?php
  $page_title = 'Editar produto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php


$product = find_by_id('products',(int)$_GET['id']);

$products = join_product_table('1');
$all_categories = find_all('categories');
$all_status = find_all('status');
$all_photo = find_all('media');
if(!$product){
  $session->msg("d","ID do produto ausente.");
  redirect('product.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-title','product-marca', 'product-model', 'description', 'product-categorie','product-quantity', 'saleing-price','status');
    validate_fields($req_fields);

   if(empty($errors)){
       $p_name  = remove_junk($db->escape($_POST['product-title']));
       $p_cat   = (int)$_POST['product-categorie'];
       $p_desc = remove_junk($db->escape($_POST['description']));
      // $p_credit  = remove_junk($db->escape($_POST['credit-deb']));
       $p_marca  = remove_junk($db->escape($_POST['product-marca']));
       $p_model  = remove_junk($db->escape($_POST['product-model']));
       $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
       //$p_buy   = remove_junk($db->escape($_POST['buying-price']));
       $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
       $p_status = remove_junk($db->escape($_POST['status']));
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
       $query   = "UPDATE products SET";
       $query  .=" name ='{$p_name}', quantity ='{$p_qty}', description ='$p_desc', product_marca = '{$p_marca}', product_model = '{$p_model}',";
       $query  .=" sale_price ='{$p_sale}', status_id = '$p_status', categorie_id ='{$p_cat}',media_id='{$media_id}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"O produto foi atualizado.");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Não foi posivel fazer á atualização.');
                 redirect('edit_product.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
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
            <span>Editar produto</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
              <div class="form-group">
              <label>Nome</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                  <label>Categoria</label>
                    <select class="form-control" name="product-categorie">
                    <option value="">Seleciona uma categoría</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-6">
                  <label>Foto</label>
                    <select class="form-control" name="product-photo">
                      <option value=""> Sem imagem</option>
                      <?php  foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id'];?>" <?php if($product['media_id'] === $photo['id']): echo "selected"; endif; ?> >
                        <?php echo $photo['file_name'];?></option>

                      <?php endforeach; ?>
                    </select>
                    <?php
                        foreach ($products as $pro):
                           if($product['media_id'] === $photo['id']): var_dump($photo['id']); endif;
                        endforeach;
                    ?>
                  <?php if($product['media_id'] === $photo['id']): var_dump($photo['id']);?>
                  
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $photo['file_name']; ?>" alt="">
                <?php endif; ?>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                  <label>Marca</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-th-large"></i>
                     </span>
                     <input type="text" class="form-control" name="product-marca" value="<?php echo remove_junk($product['product_marca']);?>">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <label>Modelo</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-th-large"></i>
                     </span>
                     <input type="text" class="form-control" name="product-model" value="<?php echo remove_junk($product['product_model']);?>">
                  </div>
                  </div>
                </div>
              </div>


              <div class="form-group">
              <div class="col-md-6">
              <label>Descrição (opcional)</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="description" value="<?php echo remove_junk($product['description']); ?>">
               </div>
              </div>

              <div class="col-md-6">
                     <label>Status</label>
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-th-large"></i>
                        </span>
                        <select class="form-control" name="status">
                        <?php  foreach ($all_status as $st): ?>
                          <option value="<?php echo (int)$st['id']; ?>" <?php if($product['status_id'] === $st['id']): echo "selected"; endif; ?> >
                            <?php if($st['statu'] == 1): echo 'Ativo'; else: echo 'Inativo'; endif; ?></option>
                        <?php endforeach; ?>
                           
                        </select>
                      </div>
                  </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Quantidade</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>">
                   </div>
                  </div>
                 </div>
                 <!-- <div class="col-md-4">
                  <div class="form-group">
                  <label>Crédito / Débito</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="text" class="form-control" name="credit-deb" value="<?php echo remove_junk($product['deb_credit']);?>">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
                 </div> -->
                  <div class="col-md-4">
                   <div class="form-group">
                   <label>Dinheiro / Transferência</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-usd"></i>
                       </span>
                       <input type="text" class="form-control" name="saleing-price" value="<?php echo remove_junk($product['sale_price']);?>">
                       <span class="input-group-addon">.00</span>
                    </div>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="product" class="btn btn-danger">Atualizar</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
