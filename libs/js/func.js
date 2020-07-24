
function suggetions() {

    $('#sug_inputs').keyup(function(e) {

        var formData = {
            'product_name' : $('input[name=nome]').val()
        };

        if(formData['product_name'].length >= 1){

          // process the form
          $.ajax({
              type        : 'POST',
              url         : 'ajax.php',
              data        : formData,
              dataType    : 'json',
              encode      : true
          })
              .done(function(data) {
                  //console.log(data);
                  $('#results').html(data).fadeIn();
                  $('#results li').click(function() {

                    $('#sug_inputs').val($(this).text());
                    $('#results').fadeOut(500);

                  });

                  $("#sug_inputs").blur(function(){
                    $("#results").fadeOut(500);
                  });

              });

        } else {

          $("#results").hide();

        };

        e.preventDefault();
    });

}



 $(document).ready(function() {

   //suggetion for finding product names
   suggetions();
   // Callculate total ammont



 });



