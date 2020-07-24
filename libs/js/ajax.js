
function suggetiones() {

    $('#sug_inputes').keyup(function(e) {
  
        var formData = {
            'product_name' : $('input[name=title]').val()
        };
  
        if(formData['product_name'].length >= 1){
  
          // process the form
          $.ajax({
              type        : 'POST',
              url         : 'ajax_inc.php',
              data        : formData,
              dataType    : 'json',
              encode      : true
          })
              .done(function(data) {
                  //console.log(data);
                  $('#resultes').html(data).fadeIn();
                  $('#resultes li').click(function() {
  
                    $('#sug_inputes').val($(this).text());
                    $('#resultes').fadeOut(500);
  
                  });
  
                  $("#sug_inputes").blur(function(){
                    $("#resultes").fadeOut(500);
                  });
  
              });
  
        } else {
  
          $("#resultes").hide();
  
        };
  
        e.preventDefault();
    });
  
  }
  $('#sug-formes').submit(function(e) {
     var formData = {
         'p_name' : $('input[name=title]').val()
        
     };
       // process the form
       $.ajax({
           type        : 'POST',
           url         : 'ajax_inc.php',
           data        : formData,
           dataType    : 'json',
           encode      : true
       })
           .done(function(data) {
               //console.log(data);
               $('#product_informe').html(data).show();
               totals();
               $('.datePicker').datepicker('update', new Date());
  
           }).fail(function() {
               $('#product_informe').html(data).show();
           });
     e.preventDefault();
  });
  function totals(){
   $('#product_informe input').change(function(e)  {
  

           var x1 = +$('input[name=preco]').val() || 0;
           var x2 = +$('input[name=credito]').val() || 0;
           var qty   = +$('input[name=quantity]').val() || 0;
           var total = qty * x1;
           var totalcred = qty * x2;
           var percent = 15;
           var credit = totalcred + (x2 * percent)  / 100;
           console.log(credit)
           $('input[name=totalc]').val(totalcred.toFixed(2));
               
            $('input[name=total]').val(total.toFixed(2));
           

          
          // $('input[name=total]').val(total.toFixed(2));
   });
   var x1 = +$('input[name=preco]').val() || 0;
   var x2 = +$('input[name=credito]').val() || 0;
   var qty   = +$('input[name=quantity]').val() || 0;
   var total = qty * x1;
   var totalcred = qty * x2;
   var percent = 15;
   var credit = totalcred + (x2 * percent)  / 100;
   console.log(credit)
   $('input[name=totalc]').val(totalcred.toFixed(2));
       
    $('input[name=total]').val(total.toFixed(2));
   $('input[name=totalc]').val(totalcred.toFixed(2));
               
   $('input[name=total]').val(total.toFixed(2));
  }
  
  
  $(document).ready(function() {
      var res = $('.vest').text()
      
    $('input[name=vends]').val(res)

   //suggetion for finding product names
   suggetiones();
   // Callculate total ammont
   totals();
  
   $('.datepicker')
       .datepicker({
           format: 'yyyy-mm-dd',
           todayHighlight: true,
           autoclose: true
       });
  });
  
  
  
  