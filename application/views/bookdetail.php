<script src="<?php echo site_url('assets/js/logout.js'); ?>"></script>

<div>
    <div class="row">
        <div class="col-sm-10">
            <h1 class="text-center"> <?php echo '$bookname'; ?> </h1>
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
    <?php echo 'book description here...'?>
</div>

<div>
    <form class="form-request" id="formRequest" action="<?php echo 'request/'.$bookid ?>" method="post">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Click to request this book</button>
        <p></p>
    </form>
</div>
<script type="text/javascript">
    $("#formLogout").submit(function(event)
    {
        event.preventDefault();
        Logout.logout();
        return false;
    });
</script>