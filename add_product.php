<?php
  $page_title = 'Adicionar Produto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_status = find_all('status');
  $all_photo = find_all('media');
?>
<?php
 if(isset($_POST['add_product'])){
   $req_fields = array('product-title','product-marca', 'product-model', 'description', 'product-categorie','product-quantity', 'saleing-price', 'status');
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['product-title']));
     $p_desc  = remove_junk($db->escape($_POST['description']));
     $p_marca  = remove_junk($db->escape($_POST['product-marca']));
     $p_model  = remove_junk($db->escape($_POST['product-model']));
     $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
     $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
     $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
     $p_status = remove_junk($db->escape($_POST['status']));
     if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
       $media_id = '0';
     } else {
       $media_id = remove_junk($db->escape($_POST['product-photo']));
     }
     
     $query  = "INSERT INTO products (";
     $query .=" name,product_marca,product_model,description,quantity,sale_price,status_id,categorie_id,media_id";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_marca}', '{$p_model}', '{$p_desc}', '{$p_qty}', '{$p_sale}', '$p_status', '{$p_cat}', '{$media_id}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
     if($db->query($query)){
       $session->msg('s',"Produto adicionado com Sucesso!");
       redirect('add_product.php', false);
     } else {
       $session->msg('d','Falha ao cadastrar Produto!');
       redirect('product.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_product.php',false);
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
  <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Novo produto</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix">
              <div class="form-group">
              <label>Nome</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" placeholder="Exemplo">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                  <label>Categoria</label>
                    <select class="form-control" name="product-categorie">
                      <option value="">Selecione uma categoría</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                  <label>Foto</label>
                    <select class="form-control" name="product-photo">
                      <option value="">Selecione uma imagem</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                    </select>
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
                     <input type="text" class="form-control" name="product-marca" placeholder="ex: exemplo">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <label>Modelo</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-th-large"></i>
                     </span>
                     <input type="text" class="form-control" name="product-model" placeholder="ex: exemplo">
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
                  <input type="text" class="form-control" name="description" value="S/N" placeholder="Descrição">
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
                          <option value="<?php echo (int)$st['id']; ?>">
                            <?php if($st['statu'] == 1): echo 'Ativo'; else: echo 'Inativo'; endif; ?></option>
                        <?php endforeach; ?>
                        </select>
                      </div>
                  </div>
              </div>



              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                 <label>Quantidade</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="product-quantity" placeholder="0">
                  </div>
                 </div>

                  <div class="col-md-4">
                  <label>Dinheiro / Transferência</label>
                    <div class="input-group">
                   
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="text" class="form-control" name="saleing-price" placeholder="00,00">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
              
              <button type="submit" name="add_product" class="btn btn-success">Lançar no Sistema</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
