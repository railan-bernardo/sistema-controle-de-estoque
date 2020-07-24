<?php

  $page_title = 'Lista de compras';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
$sales = find_all_sales();
$pedidos = find_all_pedidos();
$products = join_client_table('150');
$product = join_product_table('350');
$pedidosdate = find_all_pedidos();

$ids = find_by_id('client',(int)$_GET['id']);
//listar todos os clientes
foreach($products as $id){}
//litar todos os pedidos
foreach($pedidos as $pedido){}

?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row" >
    <div class="col-md-12">
      <div class="panel panel-default" style="position: relative; z-index: 99;">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Todas as compras do cliente</span>
          </strong>
          <div class="pull-right">
            <button type="button" class="btn btn-danger prime">Cancelar Pedido</button>
            <a href="sales.php" class="btn btn-info">Listar todas as vendas</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">Adicionar Item</button>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Produto </th>
                <th> Modelo </th>
                <th class="text-center" style="width: 15%;"> Quantidade</th>
                <th class="text-center" style="width: 15%;">Dinheiro</th>
                <th class="text-center" style="width: 15%;"> Crédito</th>
                <th class="text-center" style="width: 15%;"> Ações</th>
             </tr>
            </thead>
           <tbody class="parentprice">

           <?php  foreach ($sales as $sale): $date = date('d/m/Y', strtotime($sale['date'])); $pdate = date('d/m/Y',strtotime($pedido['data']));?>
           <?php if($sale['cliente'] === $ids['id']):?>
            <?php
             
                if($_GET['currentdate'] === $sale['date']):
 
            ?>
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td><?php echo remove_junk($sale['name']); ?></td>
               <td><?php echo remove_junk($sale['model']); ?></td>
               <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
              <td class="text-center"><?php  echo number_format($sale['price'], 2, ',','.') ?></td>
              <td class="text-center"><?php echo number_format($sale['credito'], 2,',','.'); ?></td>
              <td class="text-center " style="display: none;"><?php  echo number_format($sale['price'], 2, ',','.') ?></td>
              <td class="text-center " style="display: none;"><?php echo number_format($sale['credito'], 2,',','.'); ?></td>
              <td style="display:none;"><b>Cliente</b></td>
              <td style="display:none;" class="clientename"><?php echo remove_junk($sale['client_name']); ?></td>
              <td colspan="1" style="display:none;"><b>Vendedora</b></td>
              <td style="display:none;"  class="venda"><?php echo remove_junk($sale['user_name']); ?></td>
              <td style="display:none;"  class="vs"><?php echo remove_junk($sale['vendedora']); ?></td>
              <td colspan="1" style="display:none;"><b>Pagamento</b></td>
              <td class="text-center sta" style="display:none;"><?php if($sale['statu'] == 1): echo "<a href=\"edit_sale.php?id=$sale[id]\" class=\"btn btn-info btn-xs\">Pendente</a>";else: echo "<a href=\"edit_sale.php?id=$sale[id]\" class=\"btn btn-success btn-xs\">Comfirmado</a>"; endif; ?></td>
              <td class="text-center">
                  <div class="btn-group">
                     <a href="list_product.php?id=<?php echo (int)$ids['id'].'&date='.$_GET['date'].'&currentdate='.$_GET['currentdate'].'&delete='.$sale['id'].'&item='.$sale['product_id'] ?>" class="btn btn-danger btn-xs"  title="Excluir" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-trash"></span>
                     </a>
                 
                  </div>
               </td>
             </tr>
                <?php endif; endif; ?>
            
             <?php   endforeach;?>
           </tbody>

         </table>
         <div class="col-md-12 text-right" style="padding: 0;">
            <div class="panel-heading" style="display: flex; position: relative; padding: 0;">
            <h5><b>Cliente: </b> &nbsp;&nbsp;<span class="clint"><?php echo remove_junk($sale['client_name']); ?></span></h4>&nbsp;&nbsp;&nbsp;&nbsp;
            <h5><b>Vendedora: </b> &nbsp;&nbsp;<span class="vendas"><?php echo remove_junk($sale['user_name']); ?></span></h4>&nbsp;&nbsp;&nbsp;&nbsp;
            <h5><b>Telefone: </b> &nbsp;&nbsp;<span class="vendas"><?php echo remove_junk($ids['phone']); ?></span></h4>     
            <span style="display:none"  class="vest">5</span>    
            </div>
            
            <h2><b>Total</b></h2>
            <?php
            foreach($sales as $mu):
           
              if($_GET['currentdate'] === $mu['date']):
                 
                  //recupera id do cliente
                  $is = $mu['date'];
                
                 $total = soma('price', $is);
                // preço em dinheiro;
                 foreach($total as $t){}
                 $totalcredito = soma('credito', $is);
                  //preço no crédito
                 foreach($totalcredito as $c){}
              endif; 
              endforeach;
            ?>
            <span style="display: block;"><b>A vista R$: </b><b class=" text-danger"> <?php  echo number_format($t['soma'], 2, ',','.'); ?></b></span>
            <span style="display: block;"><b>Cartão R$: </b><b class=" text-danger"> <?php  echo number_format($c['soma'], 2,',','.'); ?></b></span>
              <?php ?>
         </div>
         <a href="report_sales_client.php?id=<?php echo (int)$ids['id'].'&date='.$_GET['date'];?>" class="btn btn-default glyphicon glyphicon-print" id="imprimir" style="z-index: 999;"></a>
        </div>
      </div>
    </div>
  </div>

  <!-- line -->

    <div class="row" style="position: absolute; top:0 ; z-index: -3;">
    <div class="col-md-12" style="position: relative;">
      <div class="panel panel-default" style="border: 1px solid #fff; border-color: none;">
        <div class="panel-heading clearfix" style="opacity: 0;">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Todas as compras do cliente</span>
          </strong>
          <div class="pull-right" style="opacity: 0;">
            <a href="sales.php" class="btn btn-info">Listar todas as vendas</a>
            <?php echo display_msg($msg); ?>
          </div>
        </div>
 
       
          <table class="table table-bordered"style=" border: 1px solid #fff;">
            <thead style="opacity: 0;">
              <tr>
                <th class="text-center" style="width: 50px; border: 1px solid #fff;">#</th>
                <th style="border: 1px solid #fff;"> Produto </th>
                <th style="border: 1px solid #fff;"> Modelo </th>
                <th class="text-center" style="width: 15%; border: 1px solid #fff;"> Quantidade</th>
                <th class="text-center" style="width: 15%; border: 1px solid #fff;"> Valor</th>
             </tr>
            </thead>
           <tbody class="parentprice">
            <?php 

            ?>
           <?php  foreach ($sales as $sale): $date = date('d/m/Y', strtotime($sale['date'])); $pdate = date('d/m/Y',strtotime($pedido['data']));?>
           <?php if($sale['cliente'] === $ids['id']):?>
            <?php
             
                if($_GET['currentdate'] === $sale['date']):
                  
              //cancelar pedido
              if(isset($_POST['cancelar'])){
                $qty = $_POST['qty'];
                $cancel = $_POST['cancel'];
               foreach($product as $item){
                if($item['id'] === $sale['product_id']){
            

                     $sql = "UPDATE products SET quantity=$item[quantity] +'$sale[qty]' WHERE id = '$item[id]'";
                     $results = $db->query($sql);
                     $session->msg('d',"Pedido Cancelado.");
                 }

              }
             

                if($_GET['currentdate'] === $sale['date']){
                  if($_GET['id'] === $sale['cliente']){
                  $query = "UPDATE  ordercarts SET cancel = '{$cancel}' WHERE id = '$_GET[pedido]'";
                  $result = $db->query($query);

                  echo "<meta http-equiv=\"refresh\" content=\"1; URL='sales.php' \"/>";
                }
              }
               
   
              
             
           }
          

            ?>
             <form action="" method="post">
             <tr style="opacity: 0;">
               <td class="text-center" style="border: 1px solid #fff;"><?php echo count_id();?></td>
               
               <td style="border: 1px solid #fff;"><?php echo remove_junk($sale['name']); ?></td>
               <td style="border: 1px solid #fff;"><?php echo remove_junk($sale['model']); ?></td>
               <td class="text-center" style="border: 1px solid #fff;"><input class="form-control" type="text" name="qty" value="<?php echo (int)$sale['qty']; ?>"></td>
               <td class="text-center preco" style="display:none;"><?php if($sale['payment'] == 1): echo number_format($sale['subtotal_dinheiro'], 2, ',','.');else: echo number_format($sale['subtotal_credit'], 2,',','.'); endif; ?></td>
              <td style="border: 1px solid #fff;" class="text-center"><?php if($sale['payment'] == 1): echo number_format($sale['price'], 2, ',','.');else: echo number_format($sale['credito'], 2,',','.'); endif; ?></td>
              <td style="display:none; border: 1px solid #fff;"><b>Cliente</b></td>
              <td style="display:none; border: 1px solid #fff;" class="clientename"><?php echo remove_junk($sale['client_name']); ?></td>
              <td colspan="1" style="display:none; border: 1px solid #fff;"><b>Vendedora</b></td>
              <td style="display:none; border: 1px solid #fff;"  class="venda"><?php echo remove_junk($sale['user_name']); ?></td>
             
              <td colspan="1" style="display:none; border: 1px solid #fff;"><b>Pagamento</b></td>
              <td class="text-center sta" style="display:none; border: 1px solid #fff;"><?php if($sale['statu'] == 1): echo "<a href=\"edit_sale.php?id=$sale[id]\" class=\"btn btn-info btn-xs\">Pendente</a>";else: echo "<a href=\"edit_sale.php?id=$sale[id]\" class=\"btn btn-success btn-xs\">Comfirmado</a>"; endif; ?></td>
              <td style="opacity: 0; border: 1px solid #fff;"><input type="hidden" name="cancel" value="1"></td>
             </tr>
                <?php endif; endif; ?>
            
             <?php 
             
               endforeach;
               //adicionar novo item no pedido
               $ptime = date('d/m/Y', strtotime($_GET['currentdate']));
               if($ids['id']):
                  if($_GET['date'] === $ptime){
                    if(isset($_POST['add_sale'])){
                      $req_fields = array('s_id','quantity','total','data');
                      validate_fields($req_fields);
                          if(empty($errors)){
                            $p_id      = $db->escape((int)$_POST['s_id']);
                            $s_name     = $db->escape($_POST['nome']);
                            $s_model     = $db->escape($_POST['model']);
                            $s_payment     = $db->escape($_POST['payment']);
                            $s_qty     = $db->escape($_POST['quantity']);
                            $s_price     = $db->escape($_POST['preco']);
                            $s_credit     = $db->escape($_POST['credito']);
                            $s_total     = $db->escape($_POST['total']);
                            $s_ctotal     = $db->escape($_POST['totalc']);
                            $s_st     = $db->escape($_POST['statu']);
                            $s_client     = $db->escape($_POST['client']);
                            $s_vd     = $db->escape($_POST['vends']);
                            $date      = $db->escape($_POST['data']);
                            $s_date    = make_date();
                  
                            $sql  = "INSERT INTO sales (";
                            $sql .= " product_id,qty,model,subtotal_credit,subtotal_dinheiro,cliente,vendedora,nome,payment,date,price,credito,statu";
                            $sql .= ") VALUES (";
                            $sql .= "'{$p_id}','{$s_qty}','{$s_model}','{$s_credit}','{$s_price}','{$s_client}','{$s_vd}','{$s_name}','{$s_payment}','{$date}','{$s_total}','{$s_ctotal}','{$s_st}'";
                            $sql .= ")";
                           // var_dump($sql);
                                  if($db->query($sql)){
                                    update_product_qty($s_qty,$p_id);
                                   
                                    $session->msg('s',"Item Adicionado no Pedido ");
                                     echo "<meta http-equiv=\"refresh\" content=\"1; URL='$_SERVER[REQUEST_URI]' \"/>";
                                  } else {
                                    $session->msg('d','Não foi possivel adicionar item ao Pedido.');
                                  echo "<meta http-equiv=\"refresh\" content=\"1; URL='$_SERVER[REQUEST_URI]' \"/>";
                                  }
                          } else {
                             $session->msg("d", $errors);
                             echo "<meta http-equiv=\"refresh\" content=\"1; URL='$_SERVER[REQUEST_URI]' \"/>";
                          }
          
          
                    }
                  }
               endif;
              //deleta produto do pedido
                      if(isset($_GET['delete'])){

                          foreach($sales as $del):
                            foreach($product as $itemProduct){
                            if($itemProduct['id'] === $_GET['item'] && $del['id'] === $_GET['delete']):
                              $prosql = "UPDATE products SET quantity=$itemProduct[quantity] +'$del[qty]' WHERE id = '$del[product_id]'";
                              $db->query($prosql);
                              endif;
                           }//endforeach
                           $qs = "DELETE FROM sales WHERE id = '$_GET[delete]'";
                            $db->query($qs); 
                          endforeach;
                         
                          $url = str_replace('&delete='.$_GET['delete'].'&item='.$_GET['item'],"", $_SERVER['REQUEST_URI']);
                  
                          echo "<meta http-equiv=\"refresh\" content=\"1; URL='$url' \"/>";
                          $session->msg('s', "Item excluido");
                      
                        }        
             ?>
           </tbody>

         </table>
         <button type="submit" name="cancelar" class="btn btn-danger cancelarp" style="position: absolute; bottom: 0px; opacity: 0;  left: 80px;">Cancelar Pedido</button>
         </form>
         <div class="col-md-12 text-right" style="opacity: 0;">
            <div class="panel-heading" style="display: flex;">
            <h5><b>Cliente</b> &nbsp;&nbsp;<span class="clint"><?php echo remove_junk($sale['client_name']); ?></span></h4>
            <h5><b>Vendedora</b> &nbsp;&nbsp;<span class="vendas"><?php echo remove_junk($sale['user_name']); ?></span></h4> 
            </div>
                   
            <h2 style="display: block;"><b>Total</b></h2>
            <span style="display: block;"><b class="stotal">R$ <?php if($sale['payment'] == 1): echo number_format($sale['subtotal_dinheiro'], 2, ',','.');else: echo number_format($sale['subtotal_credit'], 2,',','.'); endif; ?></b></span>
         </div>
    
        </div>
      </div>
      </div>
      <?php

?>
  <!-- modal incluir pedido -->

              <div class="modal fade in" id="modal-default" style="display: none;">
              <div class="row">
              <div class="col-md-12">
                    <div class="modal-dialog" style="width: 85%;">
                          <div class="modal-content" style="border: none; border-top-left-radius: 6px !importante;border-top-right-radius: 6px !importante; border-radius: 0px;">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Incluir novo item no Pedido</h4>
                              </div>
                              <div class="modal-body">

                              <?php echo display_msg($msg); ?>
                                  <form method="post" action="ajax_inc.php" autocomplete="off" id="sug-formes">
                                      <div class="form-group">
                                        <div class="input-group">
                                          <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary">Buscar</button>
                                          </span>
                                          <input type="text" id="sug_inputes" class="form-control" name="title"  placeholder="Procurar pelo nome">
                                      </div>
                                      <div id="resultes" class="list-groupes"></div>
                                      </div>

                                  </form>
                                </div>
                              </div>
                              <div class="row">

                                <div class="col-md-12">
                                  <div class="panel panel-default" style=" border-radius: 0px; border: none; border-botton-left-radius: 6px !importante;border-botton-right-radius: 6px !importante;">
                                    <div class="panel-heading clearfix" style="border: none;">
                                      <strong>
                                        <span class="glyphicon glyphicon-th"></span>
                                        <span>Incluir ao Pedido</span>
                                    </strong>
                                    </div>
                                    <div class="panel-body">
                                    <form action="" method="post">
                                      <table class="table table-bordered">
                                        <thead>
                                          <th> Produto </th>
                                          <th> Modelo </th>
                                          <th> Pagamento </th>
                                          <th>Quantidade</th>
                                          <th>Preço / avista </th>
                                          <th>Preço / crédito </th>
                                          <th> A Vista </th>
                                          <th> No Cartão </th>
                                          <th> Ações</th>
                                        </thead>
                                          <tbody  id="product_informe">
                                              
                                            </tbody>
                                      </table>
                                     
                                      <input type="hidden" name="data" class="form-control" value="<?php echo $_GET['currentdate']; ?>">
                                      <input type="hidden" name="client" class="form-control" value="<?php echo $ids['id']; ?>">
                                      <input type="hidden" name="vends" class="form-control" value="<?php echo $sale['vendedora']; ?>">
                                      <input type="hidden" name="statu" class="form-control" value="1">
                                    </form>
                                    </div>
                                  </div>
                  
                              </div>
            
                      </div>
                      <!-- /.modal-content -->
                      </div>           
                    <!-- /.modal-dialog -->
            </div>
            </div>
            </div>
              <!-- end modal -->

<script>
    var cl = document.querySelector('.clientename')
    var vd = document.querySelector('.venda')
    var vs = document.querySelector('.vs')
    var sta = document.querySelector('.sta')

    var clt = document.querySelector('.clint')
    var vds = document.querySelector('.vendas')
    var v = document.querySelector('.vest')

   // var pg = document.querySelector('.pago')
   // var preco = document.querySelector('.preco')
   // var credito = document.querySelector('.credito')
   // var pricetotal = document.querySelector('.pricetotal')
   // var st = document.querySelector('.stotal')
  //  var stcredit = document.querySelector('.stotalcred')

    clt.innerText = cl.innerText
    vds.innerText = vd.innerText
    v.innerText = vs.innerText

   // pg.innerHTML  = sta.innerHTML
  //  st.innerText =  preco.innerText;
  //  stcredit.innerText  =  credito.innerText;

  //  pedido cancelado
  var cancelar = document.querySelector('.cancelarp')
  var prime = document.querySelector('.prime')

  prime.addEventListener('click', e =>{
    cancelar.click()
  })
  </script>
<?php include_once('layouts/footer.php'); ?>
