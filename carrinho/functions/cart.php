<?php 

if(!isset($_SESSION['carrinho'])) {
	$_SESSION['carrinho'] = array();
}

function addCart($id, $quantity) {
	if(!isset($_SESSION['carrinho'][$id])){ 
		$_SESSION['carrinho'][$id] = $quantity; 
	}
}
function finzalizarCart($id){
	$_SESSION['dados'][$id];
}

function deleteCart($id) {
	if(isset($_SESSION['carrinho'][$id])){ 
		unset($_SESSION['carrinho'][$id]); 
	} 
}

function updateCart($id, $quantity) {
	if(isset($_SESSION['carrinho'][$id])){ 
		if($quantity > 0) {
			$_SESSION['carrinho'][$id] = $quantity;
		} else {
		 	deleteCart($id);
		}
	}
}

function getContentCart($pdo) {
	
	$results = array();
	
	if($_SESSION['carrinho']) {
		
		$cart = $_SESSION['carrinho'];
		$products =  getProductsByIds($pdo, implode(',', array_keys($cart)));
		$percent = 15;
		foreach($products as $product) {

			$results[] = array(
							  'id' => $product['id'],
							  'name' => $product['name'],
							  'model'=> $product['product_model'],
							  'price' => $product['sale_price'],
							  'credito' => $product['sale_price'] + ($product['sale_price'] * $percent) / 100,
							  'quantity' => $cart[$product['id']],
							  'estoque'  => $product['quantity'],
							  'subtotal' => $cart[$product['id']] * $product['sale_price'],
							  'credit' => $cart[$product['id']] * ($product['sale_price'] + ($product['sale_price'] * $percent) / 100),
						);
		}
	}
	
	return $results;
}

function getTotalCart($pdo) {
	
	$total = 0;

	foreach(getContentCart($pdo) as $product) {
		$total += $product['subtotal'];
	} 
	return $total;
}

function getTotalCartTotal($pdo) {
	
	$total = 0;

	foreach(getContentCart($pdo) as $product) {
		
		//$res = ($product['subtotal'] + ($product['subtotal'] * $percent) / 100);

		$total +=  $product['credit'];
	} 
	return $total;
}