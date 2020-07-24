<?php
  $page_title = 'Lista de Produtos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  $nivel = page_require_level(1);
?>
<?php

  if(isset($_POST['product'])){
    global $db;
    $pnome = $_POST['nome'];

    $p_name = remove_junk($db->escape($pnome));
    $sql = "SELECT * FROM products WHERE name like '%$p_name%' LIMIT 5";
    $products  = find_by_sql($sql);

  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">

</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
      <div class="col-md-6">
            <?php echo display_msg($msg); ?>
            <form method="post" action="search.php" autocomplete="off" id="sug-forms">
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
           <a href="add_product.php" class="btn btn-info">Novo produto</a>
           <a href="generator.php" class="btn btn-default glyphicon glyphicon-print" id="imprimir"></a>
         </div>
      </div>
      <div class="panel-body">
        <form method="post" action="teste.php">
         <table class="table table-bordered">
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
             <tbody  id="product_info">
             <?php foreach ($products as $product): ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
       
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['media_id']; ?>" alt="">
              
                </td>
                <td> <?php echo remove_junk($product['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['product_model']); ?></td>
                <td class="text-center"> <?php if($product['quantity'] > 10): echo remove_junk($product['quantity']); else: ?> <a href="" class="btn btn-danger btn-xs"  title="Estoque Baixo" data-toggle="tooltip">Baixo <?php echo remove_junk($product['quantity']); ?></a><?php endif; ?></td>
                <td class="text-center"> <?php echo number_format($product['sale_price'], 2,",","."); ?></td>
                <td class="text-center"> <?php echo number_format($product['sale_price'] + ($product['sale_price'] * 15) / 100, 2,",","."); ?></td>
                <td class="text-center"> <button <?php if($product['status_id'] == 1): ?>class="btn btn-success btn-xs" <?php else:  ?>class="btn btn-danger btn-xs"<?php  endif; ?>><?php if($product['status_id'] == 1): echo "Ativo"; else: echo "Inativo"; endif; ?></button></td>
                <td class="text-center">
                  <div class="btn-group">

                    <a href="edit_product.php?id=<?php echo $product['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                     <a href="delete_product.php?id=<?php  echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Excluir" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>

                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
              </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
