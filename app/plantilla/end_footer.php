  <script type="text/javascript">  <?php $this->getReady(); ?></script>
  <script src="<?php echo ASSETS ?>/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?php echo ASSETS ?>/jQueryUI/jquery-ui.js"></script>
  <script src="<?php echo ASSETS ?>/bootstrap/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/pc-bootstrap4-datetimepicker@4.17.50/build/js/bootstrap-datetimepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue-bootstrap-datetimepicker@5"></script>
  <script src="<?php echo JS ?>/moment-with-locales.min.js"></script>

  <script type="text/javascript" src="<?php echo JS ?>/utils.js"></script>
  <script src="<?php echo JS ?>/vue/libs/vue.min.js"></script>
  <script src="<?php echo JS ?>/axios.min.js"></script>
  <script src="<?php echo JS ?>/vue/libs/vuerouter.min.js"></script>
  <script src="<?php echo JS ?>/emojis.min.js"></script>
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
