<?php
  $page_title = 'Editar Cliente';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);

  $cep = getCep('75083-049');
  $validar = validaCPF('04598141172');

  $product = find_by_id('client',(int)$_GET['id']);
  $products = join_client_table('1');
  if(!$product){
    $session->msg("d","ID do cliente ausente.");
    redirect('client.php');
  }
?>
<?php
 if(isset($_POST['edit_client'])){
   $req_fields = array('name','estate', 'city', 'phone');
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['name']));
     $p_estate  = remove_junk($db->escape($_POST['estate']));
     $p_city  = remove_junk($db->escape($_POST['city']));
     $p_phone  = remove_junk($db->escape($_POST['phone']));
     $p_cpf   = remove_junk($db->escape($_POST['cpf']));
     $p_data   = remove_junk($db->escape($_POST['data']));
     $p_adress  = remove_junk($db->escape($_POST['adress']));
     
   
     $query  = "UPDATE client SET";
     $query .=" client_name = '{$p_name}',city = '{$p_city}',uf = '{$p_estate}',phone = '{$p_phone}',cpf = '{$p_cpf}',adress = '{$p_adress}',birthday = '{$p_data}'";
     $query .=" WHERE id = $product[id]";
     $result = $db->query($query);
     if($result && $db->affected_rows() === 1){
       $session->msg('s',"O cliente foi atualizado.");
       redirect('client.php', false);
     } else {
       $session->msg('d',' Não foi posivel fazer á atualização.');
       redirect('edit_client.php?id='.$product['id'], false);
     }


   } else{
     $session->msg("d", $errors);
     redirect('edit_client.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg);      if(isset($_POST['cep'])): $sp = $_POST['ceps']; $ncep = getCep($sp); endif; ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Editar Cliente</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
         <form method="post" action="edit_client.php?id=<?php echo (int)$product['id'] ?>" class="clearfix">
         <div class="form-group">
              <label>CEP</label>
                <div class="input-group">
                
                  <span class="input-group-btn">
                  <button type="submit" name="cep" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
                  </span>
                 
                  <input type="text" class="form-control" name="ceps" placeholder="Cep">
               </div>
              </div>
              
         </form>
          <form method="post" action="edit_client.php?id=<?php echo (int)$product['id'] ?>" class="clearfix">
              <div class="form-group">
              <label>Nome</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="name" placeholder="Nome" value="<?php echo remove_junk($product['client_name']);?>">
               </div>
              </div>
             
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                  <label>Estado</label>
                       <input type="text" name="estate" class="form-control" value="<?php if(isset($ncep['uf'])): echo $ncep['uf']; else: echo  remove_junk($product['uf']); endif; ?>">
                       
                  </div>
                  <div class="col-md-6">
                  <label>Cidade</label>
                    <input type="text" class="form-control" name="city" value="<?php if(isset($ncep['localidade'])): echo $ncep['localidade']; else: echo  remove_junk($product['city']); endif; ?>">
                    </select>
                  </div>
                </div>
              </div>


              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                  <label>Telefone</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-phone"></i>
                     </span>
                     <input type="tel" name="phone" class="form-control" data-inputmask="'mask': '(99) 99999-9999'" data-mask="" value="<?php echo remove_junk($product['phone']);?>">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <label>Cpf</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-th-large"></i>
                     </span>
                     <input type="text" class="form-control" name="cpf" placeholder="000000000-00" value="<?php echo remove_junk($product['cpf']);?>">
                  </div>
                  </div>

                </div>
              </div>




              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                 <label>Data de Nacimento</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-calendar"></i>
                     </span>
                     <input type="date" class="form-control" name="data" value="<?php echo remove_junk($product['birthday']);?>">
                  </div>
                 </div>
                 <div class="col-md-6">
                     <label>Endereço</label>
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-th-large"></i>
                        </span>
                            <input type="text" class="form-control" name="adress" placeholder="EX: Rua A" value="<?php echo remove_junk($product['adress']);?>"/>
                      </div>
                  </div>
              </div>
              <button type="submit" name="edit_client" class="btn btn-primary" style="margin-top: 15px;">Atualizar</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
