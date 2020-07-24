<?php
$page_title = 'Relatório de Vendas';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
  if(isset($_POST['submit'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);

    if(empty($errors)):
      $start_date   = remove_junk($db->escape($_POST['start-date']));
      $end_date     = remove_junk($db->escape($_POST['end-date']));
      $results      = find_sale_by_dates($start_date,$end_date);
    else:
      $session->msg("d", $errors);
      redirect('sales_report.php', false);
    endif;

  } else {
    $session->msg("d", "Selecione a Data");
    redirect('sales_report.php', false);
  }
?>
<!doctype html>
<html lang="en-US">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Relatório de Vendas</title>
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
  <?php if($results): ?>
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
            <span>Relatório de Vendas</span>
         </strong>
        </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th class="text-center">Data</th>
              <th class="text-center">Nome</th>
              <th class="text-center">Preço D / T</th>
              <th class="text-center">Quantidade</th>
              <th class="text-center">Valor</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($results as $result): ?>
           <tr>
              <td class="text-center"><?php echo date('d/m/Y', strtotime($result['date']));?></td>
              <td class="desc text-center">
                <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
              </td>
              <td class="text-center"><?php echo number_format($result['sale_price'], 2, ',','.');?></td>
              <td class="text-center"><?php echo number_format($result['total_sales'], 2, ',','.');?></td>
              <td class="text-center"><?php echo number_format($result['total_saleing_price'], 2, ',','.');?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
         <tr class="text-right">
           <td colspan="2"></td>
           <td colspan="1"> <b>Total</b> </td>
           <td> <b> R$
           <?php echo number_format(@total_price($results)[0], 2,',','.');?>
           </b>
          </td>
         </tr>
        </tfoot>
      </table>
    </div>
  <?php
    else:
        $session->msg("d", "Não foi encontrado vendas. ");
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
            window.location.href = 'https://estoque.cacursos.com.br/sale_report_process.php'
		    	}, 1000);
		    }
	}
  }

  prints();
  </script>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
