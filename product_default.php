<?php
  $page_title = 'Lista de produtos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);

  $products = join_product_table('150');
  
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

        <div class="col-md-6">
            <form method="post" action="search_default.php" autocomplete="off" id="sug-forms">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button  type="submit" name="product" class="btn btn-primary">Buscar</button>
                    </span>
                    <input type="text" id="sug_inputs" class="form-control" name="nome"  placeholder="Buscar produto">
                </div>
                <div id="results" class="list-group"></div>
                </div>

            </form>
         </div>

         <div class="pull-right">
           <a href="#" class="btn btn-info">Novo produto</a>
           <a href="generator.php" class="btn btn-default glyphicon glyphicon-print" id="imprimir"></a>
         </div>
        </div>

        <div class="panel-body">
          <table class="table table-bordered" id="product_infos">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Imagen</th>
                <th> Nome </th>
                <th class="text-center" style="width: 10%;"> Modelo </th>
                <th class="text-center" style="width: 10%;"> Estoque </th>
                <th class="text-center"> Dinheiro / Trans </th>
                <th class="text-center"> Crédito / Débito </th>
                <th class="text-center" style="width: 10%;"> Status </th>
                <th class="text-center" style="width: 100px;"> Ações </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product): ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($product['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['product_model']); ?></td>
                <td class="text-center"> <?php if($product['quantity'] > 10): echo remove_junk($product['quantity']); else: ?> <a href="" class="btn btn-danger btn-xs"  title="Estoque Baixo" data-toggle="tooltip">Baixo <?php echo remove_junk($product['quantity']); ?></a><?php endif; ?></td>
                <td class="text-center"> <?php echo number_format($product['sale_price'], 2,",","."); ?></td>
                <td class="text-center"> <?php echo number_format($product['sale_price'] + ($product['sale_price'] * 15) / 100, 2,",","."); ?></td>
                <td class="text-center"> <button <?php if($product['status_id'] == 1): ?>class="btn btn-success btn-xs" <?php else:  ?>class="btn btn-danger btn-xs"<?php  endif; ?>><?php if($product['status_id'] == 1): echo "Ativo"; else: echo "Inativo"; endif; ?></button></td>
                <td class="text-center">
                  <div class="btn-group">
                      <a href="#" class="btn btn-info btn-xs"  title="Sem Permissão" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-ban-circle"></span>
                    </a>
                     <a href="#" class="btn btn-danger btn-xs"  title="Sem Permissão" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-ban-circle"></span>
                    </a>
         
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
