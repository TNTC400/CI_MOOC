<!DOCTYPE html>
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<link href=<?php echo base_url('assets\css\common.css') ?> rel="stylesheet">
<script src="<?php echo site_url('assets/js/login.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/logout.js'); ?>"></script>
</head>

    <?php $this->load->view($content) ?>

</html>