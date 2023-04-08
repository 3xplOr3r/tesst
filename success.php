<script src="sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    <?php if(isset($_SESSION['status']) && $_SESSION['status'] != '') { ?>
      swal({
        title: "<?php echo $_SESSION['status']; ?>",
        text: "<?php echo $_SESSION['status_text']; ?>",
        icon: "<?php echo $_SESSION['status_code']; ?>",
        button: "Ok",
      });
      <?php unset($_SESSION['status']); ?>
    <?php } ?>
  });
</script>
