<?php
  $page_title = 'Adicionar Cliente';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);

?>
<?php
 if(isset($_POST['add_client'])){
   $req_fields = array('name','estate', 'city', 'phone');
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['name']));
     $p_estate  = remove_junk($db->escape($_POST['estate']));
     $p_city  = remove_junk($db->escape($_POST['city']));
     $p_phone  = remove_junk($db->escape($_POST['phone']));
     $p_cpf = remove_junk($db->escape($_POST['cpf']));
     $p_data   = remove_junk($db->escape($_POST['data']));
     $p_adress  = remove_junk($db->escape($_POST['adress']));
    
     
     $query  = "INSERT INTO client (";
     $query .=" client_name,city,uf,phone,cpf,adress,birthday";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_city}', '{$p_estate}', '{$p_phone}', '{$p_cpf}', '{$p_adress}', '{$p_data}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE client_name='{$p_name}'";
     if($db->query($query)){
       $session->msg('s',"Cliente adicionado com Sucesso!");
       redirect('add_client.php', false);
     } else {
       $session->msg('d','Falha ao cadastrar Cliente!');
       redirect('client.php', false);
     }
    

   } else{
     $session->msg("d", $errors);
     redirect('add_client.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); if(isset($_POST['cep'])): $sp = $_POST['ceps']; $ncep = getCep($sp); endif; ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Novo Cliente</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
         <form method="post" action="add_client.php" class="clearfix">
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
          <form method="post" action="add_client.php" class="clearfix">
              <div class="form-group">
              <label>Nome</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="name" placeholder="Nome">
               </div>
              </div>
             
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                  <label>Estado</label>
                       <input type="text" name="estate" class="form-control" value="<?php if(isset($ncep['uf'])): echo $ncep['uf']; else: echo "Estado"; endif; ?>">
                       
                  </div>
                  <div class="col-md-6">
                  <label>Cidade</label>
                    <input type="text" class="form-control" name="city" value="<?php if(isset($ncep['localidade'])): echo $ncep['localidade']; else: echo "Cidade"; endif; ?>">
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
                     <input type="tel" name="phone" class="form-control" data-inputmask="'mask': '(99) 99999-9999'" data-mask="">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <label>Cpf</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-th-large"></i>
                     </span>
                     <input type="text" class="form-control" name="cpf" placeholder="000000000-00">
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
                     <input type="date" class="form-control" name="data" >
                  </div>
                 </div>
                 <div class="col-md-6">
                     <label>Endereço</label>
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-th-large"></i>
                        </span>
                            <input type="text" class="form-control" name="adress" placeholder="EX: Rua A"/>
                      </div>
                  </div>
              </div>
              <button type="submit" name="add_client" class="btn btn-success" style="margin-top: 15px;">Salvar</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
