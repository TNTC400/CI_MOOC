<script src="<?php echo site_url('assets/js/logout.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/book.js'); ?>"></script>

<div class="page-head">
    <div class="row">
        <div class="col-sm-12 logout-div">
            <h3 class="font-weight-normal">Hello <?php echo $this->session->userdata('username') ?></h3>
            <form class="form-logout" id="formLogout" action="userlogout" method="post">
                <button class="primary-button" type="submit">Logout</button>
            </form>
        </div>
        <div class="col-sm-12">
            <h1 class="text-center page-title"> Books </h1>
        </div>
    </div>    
</div>

<div>
    <ul class="nav nav-tabs nav-tabs-custom">
        <li class="nav nav-item">
            <a class="nav-link active" href="<?php echo base_url('home') ?>"> Home </a>
        </li>
        <li class="nav nav-item" >
            <a class="nav-link" href="<?php echo base_url('requestmanage') ?>"> Requests </a>
        </li>
    </ul>
</div>

<div class="page-body">
    <div id="bookTable">
        <table class="table">
            <tr>
                <th class="col-sm-4"> Title </th>
                <th class="col-sm-2"> Quantity </th>
                <th class="col-sm-2"> Available </th>
                <th class="col-sm-2">  </th>
            </tr>
            <!-- data here -->
            <?php foreach($books as $book): ?>
            <tr>
                <td><a href="<?php echo base_url('bookdetail/'.$book->id) ?>"><?php echo $book->name?></td>
                <td><?php echo $book->quantity?></td>
                <td><?php echo $book->number_available?></td>
                <td> <a href="<?php echo base_url('addbook/'.$book->id) ?>"  class="btn btn-lg btn-success btn-block" >Add</a>
                <a href="<?php echo base_url('deletebook/'.$book->id) ?>" class="btn btn-lg btn-danger btn-block" type="submit">Delete</a> </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    
    <div class="text-center" id = "pagination_link"></div>

    <div>
        <div class="row">
            <div class="text-center">
                <form class="form-addbook" id="formAddBook" action="addbook" method="post">
                    <button class="orange-button" type="submit">Add new book</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $("#formLogout").submit(function(event)
    {
        event.preventDefault();
        Logout.logout();
        return false;
    });
</script>