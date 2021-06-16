<script src="<?php echo site_url('assets/js/logout.js'); ?>"></script>

<div>
    <div class="row">
        <div class="col-sm-10">
            <h1 class="text-center"> Requests </h1>
        </div>
        <div class="col-sm-2">
            <h1 class="h3 mb-3 font-weight-normal">Hello <?php echo $this->session->userdata('username') ?></h1>
            <form class="form-logout" id="formLogout" action="userlogout" method="post">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Logout</button>
                <p></p>
            </form>
        </div>
    </div>    
</div>

<div>
    <ul class="nav nav-tabs">
        <li class="nav nav-item">
            <a class="nav-link" href="<?php echo base_url('home') ?>"> Home </a>
        </li>
        <li class="nav nav-item">
            <a class="nav-link active" href="<?php echo base_url('requestmanage') ?>"> Requests </a>
        </li>
        <li class="nav nav-item">
            <a class="nav-link" href="<?php echo base_url('borrowstatus') ?>"> On borrowing </a>
        </li>
    </ul>
</div>

<div>
    <table class="table table-borderless table-primary">
        <tr>
            <th class="col-sm-1 text-center"> No. </th>
            <th class="col-sm-2 text-center"> User </th>
            <th class="col-sm-5 text-center"> Requested book </th>
            <th class="col-sm-1 text-center"> Request date </th>
            <th class="col-sm-1 text-center"> Accept </th>
            <th class="col-sm-2 text-center"> Note </th>
        </tr>
        <!-- data here -->
    </table>

</div>
<script type="text/javascript">
    $("#formLogout").submit(function(event)
    {
        event.preventDefault();
        Logout.logout();
        return false;
    });
</script>