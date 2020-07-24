<?php
  $page_title = 'Relatório de Compras';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$sales = find_all_sales();
$pedidos = find_all_pedidos();
$products = join_client_table('150');
$ids = find_by_id('client',(int)$_GET['id']);
foreach($products as $id){
 
}

foreach($pedidos as $pedido){
 
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Lista de Pedidos</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
	<link rel="stylesheet" href="libs/css/main.css">
</head>
<body>
<div class="container">
  <div class="container-fluid">
  <div class="row">
  
 <div class="col-md-12">
   <div class="panel panel-default" style="margin-top: 20px; border-color: #fff;">
	 <div class="panel-heading clearfix" style="border-bottom: 2px solid #fff;">

	  <div class="pull-right">
		<a href="/sales.php" class="btn btn-primary voltar">Voltar</a>
		<button class="btn btn-default glyphicon glyphicon-print" id="imprimir"></button>
	  </div>
	 
	  <span style="text-transform: none;"><b>Data: </b><span>
	  <span class="text-center"><?php echo $_GET['date']; ?></span>
	  				
	 </div>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">

        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Produto </th>
                <th> Modelo </th>
                <th class="text-center" style="width: 15%;"> Quantidade</th>
                <th class="text-center" style="width: 15%;"> A vista</th>
                <th class="text-center" style="width: 15%;"> Cartão</th>
             </tr>
            </thead>
           <tbody class="parentprice">

           <?php  foreach ($sales as $sale): $date = date('d/m/Y', strtotime($sale['date'])); $pdate = date('d/m/Y',strtotime($pedido['data']));?>
           <?php if($sale['cliente'] === $ids['id']):?>
            <?php
             
                if($_GET['date'] === $date):
                //recupera id do cliente
                $is = $ids['id'];

                $total = soma('price', $is);
                // preço em dinheiro;
                foreach($total as $t){}
                $totalcredito = soma('credito',$is);
                  //preço no crédito
                foreach($totalcredito as $c){}
            ?>
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td><?php echo remove_junk($sale['name']); ?></td>
               <td><?php echo remove_junk($sale['model']); ?></td>
               <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
              <td class="text-center"><?php  echo number_format($sale['price'], 2, ',','.') ?></td>
              <td class="text-center"><?php echo number_format($sale['credito'], 2,',','.'); ?></td>
              <td class="text-center preco" style="display: none;"><?php  echo number_format($t['soma'], 2, ',','.') ?></td>
              <td class="text-center credito" style="display: none;"><?php echo number_format($c['soma'], 2,',','.'); ?></td>
              <td style="display:none;"><b>Cliente</b></td>
              <td style="display:none;" class="clientename"><?php echo remove_junk($sale['client_name']); ?></td>
              <td colspan="1" style="display:none;"><b>Vendedora</b></td>
              <td style="display:none;"  class="venda"><?php echo remove_junk($sale['user_name']); ?></td>
              <td colspan="1" style="display:none;"><b>Pagamento</b></td>
              <td class="text-center sta" style="display:none;"><?php if($sale['statu'] == 1): echo "<a href=\"edit_sale.php?id=$sale[id]\" class=\"btn btn-info btn-xs\">Pendente</a>";else: echo "<a href=\"edit_sale.php?id=$sale[id]\" class=\"btn btn-success btn-xs\">Comfirmado</a>"; endif; ?></td>
             </tr>
                <?php endif; endif; ?>
            
             <?php   endforeach;?>
           </tbody>

         </table>
         <div class="col-md-12" style="padding: 0;">
            <div class="panel-heading left" style="display: flex; padding: 0;">
            <h5><b>Cliente: </b> &nbsp;&nbsp;<span class="clint"><?php echo remove_junk($sale['client_name']); ?></span></h4>&nbsp;&nbsp;&nbsp;&nbsp;
            <h5><b>Vendedora: </b> &nbsp;&nbsp;<span class="vendas"><?php echo remove_junk($sale['user_name']); ?></span></h4>&nbsp;&nbsp;&nbsp;&nbsp;
            <h5><b>Telefone: </b> &nbsp;&nbsp;<span class="vendas"><?php echo remove_junk($id['phone']); ?></span></h4>     
            </div>
          <div class="text-right" style="position: relative; top: -60px;">
            <h2><b>Total</b></h2>
            <span style="display: block;"><b>A vista R$: </b><b class="stotal text-danger"> <?php  echo number_format($t['soma'], 2, ',','.'); ?></b></span>
            <span style="display: block;"><b>Cartão R$: </b><b class="stotalcred text-danger"> <?php  echo number_format($c['soma'], 2,',','.'); ?></b></span>
         </div>
         </div>
        </div>
      </div>
    </div>
  </div>
  <script>
	    function prints(){
    window.onload = function() {
		var imprimir = document.querySelector("#imprimir");
		var volt	 = document.querySelector(".voltar");

		    imprimir.onclick = function() {
				imprimir.style.display = 'none';
				volt.style.display = "none";
		    	window.print();
                
		    	var time = window.setTimeout(function() {
					imprimir.style.display = 'block';
					volt.style.display = "block";
					window.location.href = 'https://estoque.cacursos.com.br/sales.php'
		    	}, 1000);
		    }
	}
  }

  prints();
	</script>
  <script>
    var cl = document.querySelector('.clientename')
    var vd = document.querySelector('.venda')
    var sta = document.querySelector('.sta')

    var clt = document.querySelector('.clint')
    var vds = document.querySelector('.vendas')
   // var pg = document.querySelector('.pago')
   var preco = document.querySelector('.preco')
    var credito = document.querySelector('.credito')
    var pricetotal = document.querySelector('.pricetotal')
    var st = document.querySelector('.stotal')
    var stcredit = document.querySelector('.stotalcred')

    clt.innerText = cl.innerText
    vds.innerText = vd.innerText
   // pg.innerHTML  = sta.innerHTML
   st.innerText =  preco.innerText;
   stcredit.innerText  =  credito.innerText;

  </script>

