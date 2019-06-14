  <script type="text/javascript">  <?php $this->getReady(); ?></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script type="text/javascript" src="<?php echo JS ?>/utils.js"></script>
  <script type="text/javascript" src="<?php echo JS ?>/variable_entorno.js"></script>

  <script src="<?php echo JS ?>/vue/libs/vue.min.js"></script>
  <script src="<?php echo JS ?>/axios.min.js"></script>
  <script src="<?php echo JS ?>/vue/libs/vuerouter.min.js"></script>
  <script src="<?php echo JS ?>/vue/libs/vuetify.min.js"></script>
  <script src="<?php echo JS ?>/emojis.min.js"></script>

  <?php 
  /*
  foreach (glob(JS_ROOT . DS . 'componentes' . DS ."*") as $filename){
    if (!strpos($filename, 'acceso')) {
      foreach (glob($filename.DS."*") as $filename_) {
      ?>
        <script type="text/javascript" src="<?php echo JS . '/componentes/'.basename($filename).'/'.basename($filename_); ?>"></script>
      <?php
      }
    }
  }*/
  ?>
  <script type="text/javascript" src="<?php echo JS ?>/vue/app_login.js"></script>

  <script type="text/javascript">
    if ("<?php echo $_SESSION["mensaje_alerta"]["tipo"] ?>"=="error") {
      swal("Error", "<?php echo $_SESSION["mensaje_alerta"]["texto"] ?>", "warning");
      <?php unset($_SESSION['mensaje_alerta']);unset($_SESSION['mensaje_alerta']) ?>
    }
  </script>
<footer>
<div class="footer-text"> <p>Copyright</p>
  </div>
</footer>
<script type="text/javascript" src="<?php echo JS . '/../dist/main.js'; ?>"></script>

</body>

</html>
