<script src="<?php echo site_url('assets/js/book.js'); ?>"></script>
<div class="page-head">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="text-center page-title"> Add new book </h1>
        </div>
    </div>    
</div>
<div class="page-body">
  <body class="text-center">
      <form class="form-addbook" id="formAddBook" action="newbook" method="post">
        <p>
          <label for="title" class="primary-text">Title</label><br>
          <input type="text" id="title" class="text-center" required autofocus>
        </p>      
        <p>
          <label for="author" class="sr-only">Author</label><br>
          <input type="text" id="author" class="text-center" require>
        </p>
        <p>
          <label for="quantity" class="sr-only">Quantity</label><br>
          <input type="text" id="quantity" class="text-center" value='1' required>
        </p>
        <p>
          <button class="orange-button" type="submit">Add</button>
        </p>
      </form>
  </body>
</div> 



<script type="text/javascript">
  $("#formAddBook").submit(function(event)
  {
      event.preventDefault();
      Book.addnew();
      return false;
  });
</script>