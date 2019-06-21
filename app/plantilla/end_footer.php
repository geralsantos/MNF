  <script type="text/javascript">  <?php $this->getReady(); ?></script>
  <script src="<?php echo ASSETS ?>/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?php echo ASSETS ?>/jQueryUI/jquery-ui.js"></script>
  <script src="<?php echo ASSETS ?>/bootstrap/js/popper.min.js"></script>
  <script src="<?php echo ASSETS ?>/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo JS ?>/moment-with-locales.min.js"></script>
  <script src="<?php echo ASSETS ?>/js/bootstrap-datetimepicker.min.js"></script>
  <script src="<?php echo ASSETS ?>/js/jquery.dataTables.min.js"></script>

  <script src="<?php echo ASSETS ?>/js/dataTables.bootstrap4.min.js"></script>
  <script src="//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"></script>


  <script src="<?php echo JS ?>/vue/libs/vue.min.js"></script>
  <script src="<?php echo JS ?>/axios.min.js"></script>
  <script src="<?php echo JS ?>/vue/libs/vuerouter.min.js"></script>
  <script src="<?php echo JS ?>/peruvian.js"></script> 
   
  <?php
    if (isset($_SESSION["usuario"])){
     ?>
  <script type="text/javascript" src="<?php echo JS . '/../dist/main.js'; ?>"></script>

     <?php
    }else {
      ?>
  <script src="<?php echo JS ?>/vue/libs/vuetify.min.js"></script>
      <script type="text/javascript" src="<?php echo JS ?>/vue/app_login.js"></script>
         <?php
    }
  ?>

</body>

</html>
