<script src="<?php echo site_url('assets/js/logout.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/request.js'); ?>"></script>

<div class="page-head">
    <div class="row">
        <div class="col-sm-12 logout-div">
            <h3 class="font-weight-normal">Hello <?php echo $this->session->userdata('username') ?></h3>
            <form class="form-logout" id="formLogout" action="userlogout" method="post">
                <button class="primary-button" type="submit">Logout</button>
            </form>
        </div>
        <div class="col-sm-12">
            <h1 class="text-center page-title"> Requests </h1>
        </div>
    </div>    
</div>

<div class="row">
    <div class="col-sm-10">
        <ul class="nav nav-tabs nav-tabs-custom">
            <li class="nav nav-item">
                <a class="nav-link" href="<?php echo base_url('home') ?>"> Home </a>
            </li>
            <li class="nav nav-item">
                <a class="nav-link active" href="<?php echo base_url('requestmanage') ?>"> Requests </a>
            </li>
        </ul>
    </div>
    <div class="col-sm-2">
        <!-- Search -->
        <input type="text" placeholder="Search..." class="textbox-search" id="textSearch">
        <button id="buttonSearch" class="search-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
        </button>
    </div>
</div>

<div class="page-body">
    <div id="tableRequests">
        <table class="table">
            <tr>
                <th class="col-sm-2 text-center"> User </th>
                <th class="col-sm-5 text-center"> Requested book </th>
                <th class="col-sm-1 text-center"> Request date </th>
                <th class="col-sm-1 text-center"> Accept </th>
            </tr>
            <!-- data here -->
            <?php foreach($requests as $request): ?>
            <tr>
                <td class="text-center"><?php echo $request->username?></td>
                <td class="text-center"><?php echo $request->booktitle?></td>
                <td class="text-center"><?php echo $request->request_date?></td>
                <td class="text-center"> <button class="btn btn-lg btn-primary btn-block button-accept" value=<?php echo $request->id ?>> 
                    <?php if($request->status == 0): echo "Accept"  ?>
                    <?php else: echo "Return";  ?>
                    <?php endif; ?>
                </button></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<script type="text/javascript">
    $("#formLogout").submit(function(event)
    {
        event.preventDefault();
        Logout.logout();
        return false;
    });

    $(document).on("click", ".button-accept",function(event) {        
        value = $(this).attr('value');
        event.preventDefault();
        if($(this).text().trim() === "Accept")
        {
            Request.acceptRequest(value);
        }
        else
        {
            Request.bookReturn(value);
        }
        return false;
    });

    $("#buttonSearch").click(function(event)
    {
        value = $("#textSearch").val();
        event.preventDefault();
        Request.search(value);
        return false;
    });
</script>