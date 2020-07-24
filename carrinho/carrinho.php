<?php 
	session_start();
	require_once "functions/product.php";
	require_once "functions/cart.php";

	$pdoConnection = require_once "connection.php";

	if(isset($_GET['acao']) && in_array($_GET['acao'], array('add', 'del', 'up'))) {
		
		if($_GET['acao'] == 'add' && isset($_GET['id']) && preg_match("/^[0-9]+$/", $_GET['id'])){ 
			addCart($_GET['id'], 1);			
		}

		if($_GET['acao'] == 'del' && isset($_GET['id']) && preg_match("/^[0-9]+$/", $_GET['id'])){ 
			deleteCart($_GET['id']);
		}

		if($_GET['acao'] == 'up'){ 
			if(isset($_POST['quantity']) && is_array($_POST['quantity'])){ 
				foreach($_POST['quantity'] as $id => $qtd){
						updateCart($id, $qtd);
				}
			}
		} 

		header('location: carrinho.php');
	}

	$resultsCarts = getContentCart($pdoConnection);
	$totalCarts  = getTotalCart($pdoConnection);
	$totalP  = getTotalCartTotal($pdoConnection);

	$_SESSION['dados'] = array();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Carrinho</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
	<link rel="stylesheet" href="libs/css/main.css">
</head>
<body>

  <div class="container">
  <div class="row">
  
  <div class="col-md-12">
  <h2> <i class="glyphicon glyphicon-shopping-cart"></i>Carrinho de Compras</h2>
	<a href="/add_sale.php" class="btn btn-info" style="margin-bottom: 15px;">Continuar Comprando</a>
  </div>
 <div class="col-md-12">
   <div class="panel panel-default">
	 <div class="panel-heading clearfix" style="border-bottom: 0 solid #fff;">

	  <div class="pull-right">
		<a href="/add_sale.php" class="btn btn-primary">Voltar</a>
		
	  </div>
	 </div>
				<!-- end header -->
		<div class="panel-body" style="position: relative">
		<?php if($resultsCarts) : ?>
			<form action="carrinho.php?acao=up" method="post" class="form">
			
			<table class="table table-bordered" style="border: 1px solid #fff;">
				<thead>
					<tr style="opacity: 1;">
						<th class="text-center" style="border: 1px solid #fff;">Produto</th>
						<th class="text-center" style="border: 1px solid #fff;">Modelo</th>
						<th class="text-center" style="border: 1px solid #fff;">Quantidade</th>
						<th class="text-center" style="border: 1px solid #fff;">Preço Dinheiro</th>
						<th class="text-center" style="border: 1px solid #fff;">Preço Crédito</th>
						<th class="text-center" style="border: 1px solid #fff;">Subtotal Dinheiro</th>
						<th class="text-center" style="border: 1px solid #fff;">Subtotal Crédito</th>
						<th class="text-center" style="border: 1px solid #fff;">Status</th>
						<th class="text-center">Açães</th>

					 </tr>
				</thead>
				<tbody id="product_info">
				  <?php foreach($resultsCarts as $result) : ?>

					<tr>
												
						<td class="text-center"><input type="text" name="nome" value="<?php echo $result['name']?>" class="form-control"></td>
						<td class="text-center"><input  type="text" name="modelo" value="<?php echo $result['model'] ?>" class="form-control"></td>
						<td class="text-center" style="position: relative;z-index: 99;">
							<input type="text" name="quantity[<?php echo $result['id']?>]" value="<?php echo $result['quantity']?>" style="width: 131px; position: relative;" class="form-control"/>							
						</td>
						<td class="text-center"><input type="text" name="subtotal" value="<?php echo number_format($result['price'], 2, ',', '.')?>" class="form-control price"></td>
						<td class="text-center"><input type="text" name="credito" value="<?php echo number_format($result['credito'], 2, ',', '.')?>" class="form-control"></td>
						<td class="text-center"><input type="text" value="<?php echo number_format($result['subtotal'], 2, ',', '.')?>" class="form-control"></td>
						<td class="text-center"><input type="text" value="<?php echo number_format($result['credit'], 2, ',', '.')?>" class="form-control"></td>

						<td class="text-center"><a href="carrinho.php?acao=del&id=<?php //echo $result['id']?>" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a></td>
						<td class="text-center" style="opacity: 1;"><input type="text" name="qty" value="<?php echo $result['quantity']?>" class="form-control"></td> 
					</tr>
				<?php endforeach;?>
				
				<?php
					$clint = getClient($pdoConnection);
					$consult = getConsultor($pdoConnection);
					
				?>


				</td>
				 </tr>
				</tbody>
				
			</table>

		
			<button class="btn btn-primary" type="submit" style="position: relative;margin-top: 52px; z-index: 99;">Atualizar Carrinho</button>
			
			</form>

		<form action="finalizar.php" method="post" style="opacity: 1; position: absolute; top: 35px;z-index: 3; background: #fff;">
			
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="text-center">Produto</th>
						<th class="text-center">Modelo</th>
						<th class="text-center">Quantidade</th>
						<th class="text-center">Preço Dinheiro</th>
						<th class="text-center">Preço Crédito</th>
						<th class="text-center">Subtotal Dinheiro</th>
						<th class="text-center">Subtotal Crédito</th>
						<th class="text-center">Status</th>
						<th class="text-center">Ações</th>

					 </tr>
				</thead>
				<tbody id="product_info">
				  <?php foreach($resultsCarts as $result) : ?>
						<?php
									array_push($_SESSION['dados'], 
									array(
									   'product_id'=>$result['id'],
									   'qty'=>$result['quantity'],
									   'estoque'=>$result['estoque'],
									   'model'=>$result['model'],
									   'subtotal_credit'=>$totalP,
									   'subtotal_dinheiro'=>$totalCarts,
									   'nome'=>$result['name'],
									   'price'=>$result['price'],
									   'credito'=>$result['credito'],
									   'totald'=>$result['subtotal'],
									   'totalc'=>$result['credit'],
									   )
								   );	
						?>
					<tr>
					
				
						<td class="text-center"><input type="text" name="nome" value="<?php echo $result['name']?>" class="form-control"></td>
						<td class="text-center"><input  type="text" name="modelo" value="<?php echo $result['model'] ?>" class="form-control"></td>
						<td class="text-center">
							<input type="text" name="quantity[<?php echo $result['id']?>]" value="<?php echo $result['quantity']?>" size="1" class="form-control"/>							
						</td>
						<td class="text-center"><input type="text" name="subtotal" value="<?php echo number_format($result['price'], 2, ',', '.')?>" class="form-control"></td>
						<td class="text-center"><input type="text" name="credito" value="<?php echo number_format($result['credito'], 2, '.', '.')?>" class="form-control"></td>
						<td class="text-center"><input type="text" value="<?php echo number_format($result['subtotal'], 2, ',', '.')?>" class="form-control"></td>
						<td class="text-center"><input type="text" value="<?php echo number_format($result['credit'], 2, '.', '.')?>" class="form-control totals"></td>
						<td class="text-center"><input type="hidden" name="statu" value="1" class="form-control"></td>
						<td class="text-center"><a href="carrinho.php?acao=del&id=<?php echo $result['id']?>" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a></td>
						<td class="text-center" style="opacity: 1;"><input type="hidden" name="qty" value="<?php echo $result['quantity']?>" class="form-control"></td> 
					</tr>
				<?php endforeach; ?>
				 <tr>
				 <td class="text-center">
				 <select name="client" class="form-control value">
						<option disabled selected>-- Cliente --</option>
						<?php 
						foreach($clint as $dados){
							echo "<option value=\"$dados[id]\">$dados[client_name]</option>";
						}
						
						?>
					</select>
				 </td>
				<td class="text-center">
				<select name="vendedora" class="form-control value">
				<option disabled selected >-- Vendedora --</option>
						<?php 
						foreach($consult as $ct){
							echo "<option value=\"$ct[id]\">$ct[user_name]</option>";
						}
						
						?>
					</select>
				</td>
				<td class="text-center">
							<select name="payment" class="form-control" id="forma">
							<option  id="option" value="1">Dinheiro ou Transferência</option>
							<option id="optionva"  value="2">Débito ou Crédito</option>
							</select>
				</td>
				<td colspan="1" class="text-right"><b>Total Dinheiro: </b></td>
				 	<td class="text-center"><input type="text" name="total" value="<?php echo number_format($totalCarts, 2, ',', '.')?>" class="form-control total"></td>	
				 </tr>
				</tbody>
				
			</table>

			<button type="submit" name="finalizar" class="btn btn-success" style="position: relative; top: 0; left: 150px;">Finalizar</button>
			</form>
	<?php endif?>
		</div>
	</div>
	</div>
	</div>
</body>

  <script>


		var dinheiro = document.querySelector('#option')
		var credito = document.querySelector('#optionva')
		
		var forma = document.querySelector('#forma')
		//var forma2 = document.querySelector('#forma2')
		var total = document.querySelector('.total');

		var opt1 = document.querySelector('#opt1')
		var opt2 = document.querySelector('#opt2')
		var sal = document.querySelector('.price')
		//var totals = document.querySelector('.totals')
	

		var percent = 15

		forma.addEventListener('change', e =>{
			var v = e.srcElement.value;

			var result = total.value;	
				
				if(dinheiro.selected){
					window.location.href = "https://estoque.cacursos.com.br/carrinho/carrinho.php"
				}

				if(credito.selected){
			
					var va = parseFloat(result) + (parseFloat(result) * parseInt(percent)) / parseInt(100)
					total.value = parseFloat(va).toFixed(2)

					var s =total.value
				console.log(va)
					
				}

		})

// var fm = document.querySelector('.vl');
// var fms = document.querySelector('.value');

// 		fm.addEventListener('change', e =>{
// 			console.log(e.srcElement.innerText)
// 		})

  </script>

</html>