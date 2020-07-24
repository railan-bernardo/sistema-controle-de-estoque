<?php
  $page_title = 'Lista de vendas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$sales = find_all_pedidos();
$products = join_client_table('150');

foreach($products as $cl){

}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Todas as Vendas</span>
          </strong>
          <div class="pull-right">
            <a href="add_sale.php" class="btn btn-info">Nova Venda</a>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Cliente </th>
                <!-- <th> Vendedora </th> -->
                <th> Produto </th>
                <!-- <th> Modelo </th> -->
                <!-- <th class="text-center" style="width: 15%;"> Quantidade</th> -->
                <th class="text-center" style="width: 15%;"> Status</th>
                <th class="text-center" style="width: 15%;"> Data</th>
                <th class="text-center" style="width: 15%;"> Total </th>
                <th class="text-center" style="width: 100px;"> Ações </th>
             </tr>
            </thead>
           <tbody>
           <?php  foreach ($sales as $sale):?>
         
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td><?php echo remove_junk($sale['client_name']); ?></td>
               <td><?php echo remove_junk($sale['name']); ?></td>
                <td class="text-center"><?php if($sale['statuss'] == 1): echo "<a href=\"#\" class=\"btn btn-info btn-xs\">Pendente</a>";else: echo "<span class=\"btn btn-success btn-xs\">Comfirmado</span>"; endif; ?></td>
               <td class="text-center"><?php echo date('d/m/Y', strtotime($sale['data'])); ?></td>
               <td class="text-center"><?php if($sale['payments'] == 1): echo number_format($sale['subtotal_dinheiros'], 2, ',','.');else: echo number_format($sale['subtotal_credits'], 2,',','.'); endif; ?></td>
               <td class="text-center">
                  <div class="btn-group">

                    <a href="list_product.php?id=<?php echo (int)$sale['clientes'].'&date='.date('d/m/Y',strtotime($sale['data']));?>" class="btn btn-warning btn-xs"  title="Vizualizar" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-eye-open"></span>
                     </a>
                     <a href="#" class="btn btn-danger btn-xs"  title="Sem Permissão" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-ban-circle"></span>
                     </a>
       
                  </div>
               </td>
              
             </tr>

             <tr>
             <?php endforeach; ?>
             
           </tbody>
          
         </table>
         
        </div>
      </div>
    </div>
  </div>
<?php include_once('layouts/footer.php'); ?>
