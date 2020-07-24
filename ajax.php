<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php
 // Auto suggetion
    $html = '';
   if(isset($_POST['product_name']) && strlen($_POST['product_name']))
   {
     $products = find_product_by_title($_POST['product_name']);
     if($products){
        foreach ($products as $product):
           $html .= "<li class=\"list-group-item\">";
           $html .= $product['name'];
           $html .= "</li>";
         endforeach;
      } else {

        $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
        $html .= 'Não encontrado';
        $html .= "</li>";

      }

      echo json_encode($html);
   }
 ?>
 <?php
//  $html  .= "<input type=\"text\" class=\"form-control\" name=\"price\" value=\"{$result['sale_price']}\">";
 // find all product
  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $product_title = remove_junk($db->escape($_POST['p_name']));
    if($results = find_all_product_info_by_title($product_title)){
        foreach ($results as $result) {

          $html .= "<tr>";
          $html .= "<td id=\"s_name\">".$result['name']."</td>";
          $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$result['id']}\">";
          $html .= "<td id=\"s_model\">".$result['product_model']."</td>";
          // $html  .= "<td>";
          // $html  .= "<select name=\"price\" class=\"form-control\" id=\"forma\">";
          // $html  .= "<option selected id=\"opt1\" value=\"{$result['sale_price']}\">Dinheiro ou Transferência</option>";
          // $html  .= "<option  id=\"opt2\" value=\"{$result['deb_credit']}\">Crédito ou Débito</option>";
          // $html  .= "</select>";
          // $html  .= "</td>";
          // $html .= "<td id=\"s_qty\">";
          // $html .= "<input type=\"text\" class=\"form-control\" name=\"quantity\" value=\"{$result['quantity']}\">";
          // $html  .= "</td>";
          $html  .= "<td>".number_format($result['sale_price'], 2, ",",".")."</td>";
          $html  .= "<td>".number_format($result['sale_price'] + ($result['sale_price'] * 15) / 100, 2, ",",".")."</td>";
          // $html   .= "<td>";
          // $html  .= "<input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\">";
          // $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<a href=\"carrinho/carrinho.php?acao=add&id=$result[id]\"  class=\"btn btn-info\" id=\"add\"><i class=\"glyphicon glyphicon-shopping-cart\"></i></a>";
          $html  .= "</td>";
          $html  .= "</tr>";

        }
    } else {
        $html ='<tr><td>O produto não está registrado no banco de dados</td></tr>';
    }

    echo json_encode($html);
  }
 ?>
