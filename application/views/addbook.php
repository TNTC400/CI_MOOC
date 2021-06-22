<script src="<?php echo site_url('assets/js/book.js'); ?>"></script>
<body class="text-center">
    <form class="form-addbook" id="formAddBook" action="newbook" method="post">
      <h1 class="h3 mb-3 font-weight-normal">Add new book</h1>
      <p>
        <label for="title" class="sr-only">Title</label><br>
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
      <!-- <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div> -->
      <p>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Add</button>
      </p>
    </form>



    <script type="text/javascript">
    $("#formAddBook").submit(function(event)
    {
        event.preventDefault();
        Book.addnew();
        return false;
    });
</script>
</body>