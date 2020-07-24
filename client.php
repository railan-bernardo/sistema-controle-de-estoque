<?php
  $page_title = 'Lista de Clientes';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  $nivel = page_require_level(3);
  $products = join_client_table('150');
  
  if(isset($_POST['product'])){

    $pnome = $_POST['nome'];

    $sql = "SELECT * FROM products WHERE name LIKE '%$pnome%'";
    $stmt = mysqli_query($con, $sql);

  }
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
  
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">


         <div class="pull-right">
           <a href="add_client.php" class="btn btn-info">Novo Cliente</a>
         </div>
        </div>

        <div class="panel-body">
          <table class="table table-bordered" id="product_infos">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Nome </th>
                <th class="text-center" style="width: 10%;"> Cidade </th>
                <th class="text-center" style="width: 10%;"> UF </th>
                <th class="text-center"> Phone </th>
                <th class="text-center"> Endereço </th>
                <th class="text-center" style="width: 10%;">Aniversário </th>
                <th class="text-center" style="width: 100px;"> Ações </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product): ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                
                <td> <?php echo remove_junk($product['client_name']); ?></td>
                <td class="text-left"> <?php echo remove_junk($product['city']); ?></td>
                <td class="text-center"> <?php  echo remove_junk($product['uf']);  ?></td>
                <td class="text-center"> <?php echo remove_junk($product['phone']); ?></td>
                <td class="text-left"> <?php echo remove_junk($product['adress']); ?></td>
                <td class="text-center"><?php echo remove_junk($product['birthday']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                  <?php if($nivel <= 1): ?>
                    <a href="edit_client.php?id=<?php echo $product['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                     <a href="delete_client.php?id=<?php  echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Excluir" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  <?php else: ?>
                    <a href="#" class="btn btn-info btn-xs"  title="Sem Permissão" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-ban-circle"></span>
                    </a>
                     <a href="#" class="btn btn-danger btn-xs"  title="Sem Permissão" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-ban-circle"></span>
                    </a>
                  <?php endif; ?>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php include_once('layouts/footer.php'); ?>
