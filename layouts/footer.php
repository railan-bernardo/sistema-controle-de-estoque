     </div>
    </div>
    <script type="text/javascript" src="libs/js/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="libs/js/jquery.inputmask.js"></script>
  <script type="text/javascript" src="libs/js/jquery.inputmask.extensions.js"></script>
  <script type="text/javascript" src="libs/js/jquery.inputmask.phone.extensions.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

  <script type="text/javascript" src="libs/js/functions.js"></script> 
  <script type="text/javascript" src="libs/js/func.js"></script>
  <script type="text/javascript" src="libs/js/ajax.js"></script>
   <!--<script type="text/javascript" src="libs/js/add-cart.js"></script>  -->
  <script>
  $(function () {
    

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()


  })
</script>
  </body>
</html>

<?php if(isset($db)) { $db->db_disconnect(); } ?>
