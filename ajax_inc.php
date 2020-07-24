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
        
          $cd = $result['sale_price'] + ($result['sale_price'] * 15) / 100;
          $p  = $result['sale_price'];
          $html .= "<tr>";
          $html .= "<td id=\"s_name\"><input type=\"text\" name=\"nome\" value=\"{$result['name']}\" class=\"form-control\"></td>";
          $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$result['id']}\">";
          $html .= "<td id=\"s_model\"><input type=\"text\" name=\"model\" class=\"form-control\" value=\"{$result['product_model']}\"></td>";
          $html  .= "<td>";
          $html  .= "<select name=\"payment\" class=\"form-control\" id=\"forma\">";
          $html  .= "<option selected id=\"opt1\" value=\"1\">Dinheiro ou Transferência</option>";
          $html  .= "<option  id=\"opt2\" value=\"2\">Crédito ou Débito</option>";
          $html  .= "</select>";
          $html  .= "</td>";
          $html .= "<td id=\"s_qty\">";
          $html .= "<input type=\"text\" class=\"form-control\" name=\"quantity\" value=\"{$result['quantity']}\">";
          $html  .= "</td>";
          $html  .= "<td><input type=\"text\" name=\"preco\" value=\"{$p}\" class=\"form-control\"></td>";
          $html  .= "<td><input type=\"text\" name=\"credito\" value=\"{$cd}\" class=\"form-control\"></td>";
           $html  .= "<td><input type=\"text\" name=\"total\" value=\"{$result['sale_price']}\" class=\"form-control\"></td>";
           $html  .= "<td><input type=\"text\" name=\"totalc\" value=\"{$cd}\" class=\"form-control\"></td>";
          // $html   .= "<td>";
          // $html  .= "<input type=\"text\" class=\"form-control datePicker\" name=\"date\" value=\"\">";
          // $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<button type=\"submit\" name=\"add_sale\"  class=\"btn btn-success\" id=\"add\"><i class=\"glyphicon glyphicon-shopping-cart\"></i></button>";
          $html  .= "</td>";
          $html  .= "</tr>";

        }
    } else {
        $html ='<tr><td>O produto não está registrado no banco de dados</td></tr>';
    }

    echo json_encode($html);
  }
 ?>
