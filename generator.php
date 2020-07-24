<?php
$page_title = 'Relatório de vendas';
//$results = '';

  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$products = join_product_table('300');
?>
<!doctype html>
<html lang="pt-BR">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Conferência de Estoque</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
   <style>
   @media print {
     html,body{
        font-size: 9.5pt;
        margin: 0;
        padding: 0;
     }.page-break {
       page-break-before:always;
       width: auto;
       margin: auto;
      }
    }
    .page-break{
      width: 980px;
      margin: 0 auto;
    }
     .sale-head{
       margin: 40px 0;
       text-align: center;
     }.sale-head h1,.sale-head strong{
       padding: 10px 20px;
       display: block;
     }.sale-head h1{
       margin: 0;
       border-bottom: 1px solid #212121;
     }.table>thead:first-child>tr:first-child>th{
       border-top: 1px solid #000;
      }
      table thead tr th {
       text-align: center;
       border: 1px solid #ededed;
     }table tbody tr td{
       vertical-align: middle;
     }.sale-head,table.table thead tr th,table tbody tr td,table tfoot tr td{
       border: 1px solid #212121;
       white-space: nowrap;
     }.sale-head h1,table thead tr th,table tfoot tr td{
       background-color: #f8f8f8;
     }tfoot{
       color:#000;
       text-transform: uppercase;
       font-weight: 500;
     }
   </style>
</head>
<body>
  <?php if($products): ?>
    <div class="page-break">
    <div class="panel panel-default">
    <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="product.php" class="btn btn-primary glyphicon glyphicon-arrow-left voltar"></a>
           <a href="#" class="btn btn-default glyphicon glyphicon-print" id="imprimir"></a>
         </div>
        </div>
        <div class="panel-body">
        <div class="panel-heading">
          <strong>     
            <span>Lista de estoque para Conferência</span>
         </strong>
        </div>
      <table class="table table-bordered">
        <thead>
          <tr>
          <th class="text-center" style="width: 50px;">#</th>
              <th class="text-center">Nome</th>
              <th class="text-center">Modelo</th>
              <th class="text-center">Marca</th>
              <th class="text-center">Estoque</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($products as $result): ?>
           <tr>
           <td class="text-center"><?php echo count_id();?></td>
              <td class="text-center">
                <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
              </td>
              <td class="text-center"><?php echo remove_junk($result['product_model']);?></td>
              <td class="text-center"><?php echo remove_junk($result['product_marca']);?></td>
              <td class="text-center"><?php echo remove_junk($result['quantity']);?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      </div>
      </div>
    </div>
  <?php
    else:
        $session->msg("d", "Não foi encontrado Produto em estoque. ");
        redirect('sales_report.php', false);
     endif;
  ?>
</body>
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
            window.location.href = 'http://estoque.cacursos.com.br/generator.php'
		    	}, 1000);
		    }
	}
  }

  prints();
  </script>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
