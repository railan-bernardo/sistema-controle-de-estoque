<?php
session_start();
$pdoConnection = require_once "connection.php";

require_once "functions/product.php";
require_once "functions/cart.php";
		// name,modelo,marca,quantity, subtotal,credito, vendedora, client, price, total, credit
		$resultsCarts = getContentCart($pdoConnection);
		$totalCarts  = getTotalCart($pdoConnection);
		$totalP  = getTotalCartTotal($pdoConnection);
	
		if(isset($_POST['finalizar'])){
			$s_client    = $_POST['client'];
			$s_vend     = $_POST['vendedora'];
			$s_pai     = $_POST['payment'];
			$statu		= $_POST['statu'];
			

			foreach($_SESSION['dados'] as $product):
			
                $insert = $pdoConnection->prepare("INSERT INTO sales (product_id,qty,model,subtotal_credit,subtotal_dinheiro,cliente,vendedora,nome,payment,price,credito,statu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
				$insert->bindParam(1, $product['product_id']);
				$insert->bindParam(2, $product['qty']);
				$insert->bindParam(3, $product['model']);
				$insert->bindParam(4, $product['subtotal_credit']);
				$insert->bindParam(5, $product['subtotal_dinheiro']);
				$insert->bindParam(6, $s_client);
				$insert->bindParam(7, $s_vend);
				$insert->bindParam(8, $product['nome']);
				$insert->bindParam(9, $s_pai);
				$insert->bindParam(10, $product['totald']);
				$insert->bindParam(11, $product['totalc']);
				$insert->bindParam(12, $statu);
			
				
				if($product['estoque'] > 1 || $product['estoque'] >= $product['qty']){
					if($insert->execute()){
					$sql = "UPDATE products SET quantity=$product[estoque] -'$product[qty]' WHERE id = '$product[product_id]'";
					$results = $pdoConnection->prepare($sql);
					$results->execute();


					}
			
				}
			
			
				endforeach;

				if($product['estoque'] > 1 || $product['estoque'] >= $product['qty']){
				echo "
				<div class=\"container\" style=\"margin-top: 25px;\">
				<div class=\"container-fluid\">
				<div class=\"row\">
				<div class=\"col-md-12\">
				<div class=\"panel panel-default\">
				
				<div class=\"alert alert-success\">Compra finalizada com Sucesso!
				<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
				</div>
				
				</div>
				</div>
				</div>
				</div>
				</div>
				</div>
				";
				}else{
					echo "
					<div class=\"container\" style=\"margin-top: 25px;\">
					<div class=\"container-fluid\">
					<div class=\"row\">
					<div class=\"col-md-12\">
					<div class=\"panel panel-default\">
					
					<div class=\"alert alert-danger\">Não existe a quantidade em estoque!
					<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
					</div>
					
					</div>
					</div>
					</div>
					</div>
					</div>
					</div>
					";
				}

					$sql = $pdoConnection->prepare("INSERT INTO ordercarts (product_ids,qtys,models,subtotal_credits,subtotal_dinheiros,clientes,vendedoras,nomes,payments,prices,creditos,statuss) VALUES ('$product[product_id]','$product[qty]','$product[model]','$product[subtotal_credit]','$product[subtotal_dinheiro]','$s_client',' $s_vend','$product[nome]','$s_pai','$product[totald]','$product[totalc]','$statu')");
					$sql->execute();

				header('Location: /sales.php');
		}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Pedidos</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
	<link rel="stylesheet" href="libs/css/main.css">
</head>
<body>
<div class="container">
  <div class="container-fluid">
  <div class="row">
  
 <div class="col-md-12">
   <div class="panel panel-default">
	 <div class="panel-heading clearfix">

	  <div  class="col-md-5">
	  <b>Data: </b>
	  <span class="text-center"><?php date_default_timezone_set('America/Sao_Paulo'); echo date('d-m-Y'); ?></span>
	  </div>				
	 </div>
				<!-- end header -->
		<div class="panel-body">
		<table class="table table-bordered" style="">
				<thead>
					<tr>
						<th class="text-center">Produto</th>
						<th class="text-center">Modelo</th>
						<th class="text-center">Quantidade</th>
						<th class="text-center">Preço Dinheiro</th>
						<th class="text-center">Preço Crédito</th>


					 </tr>
				</thead>
				<tbody id="product_info">
				  
				<?php foreach($resultsCarts as $result) : ?>
			

						<?php
									array_push($_SESSION['dados'], 
									array(
									   'product_id'=>$result['id'],
									   'qty'=>$result['quantity'],
									   'model'=>$result['model'],
									   'subtotal_credit'=>$totalP,
									   'subtotal_dinheiro'=>$totalCarts,
									   'nome'=>$result['name'],
									   )
								   );	
						?>
					<tr>
					
					<td class="text-center"><?php echo $result['name']?></td>
					<td class="text-center"><?php echo $result['model'] ?></td>
					<td class="text-center"><?php echo $result['quantity']?></td>

						<td class="text-center"><?php echo number_format($result['price'], 2, ',', '.')?></td>
						<td class="text-center"><?php echo number_format($result['credito'], 2, ',', '.')?></td>
						
						
					</tr>
				<?php endforeach;?>
				 <tr>
				
				<td colspan="1" class="text-right"><b>Total Dineiro: </b></td>
				 	<td class="text-center total"><?php echo number_format($totalCarts, 2, ',', '.')?></td>
					 <td colspan="1" class="text-right"><b>Total Crédito: </b></td>
					 <td class="text-center"><?php echo number_format($totalP, 2, ',', '.')?></td>
	
				 </tr>
				</tbody>
				
			</table>
			</div>
	</div>
	</div>
	</div>

	</html>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
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
					window.location.href = 'https://estoque.cacursos.com.br/carrinho/finalizar.php'
		    	}, 1000);
		    }
	}
  }

  prints();
	</script>
</body>