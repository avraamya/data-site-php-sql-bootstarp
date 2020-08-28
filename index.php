<?php
require_once 'crud.php';
$object = new crud();
?>
<html>
<head>
    <title>Nir & Avraham - final project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<?php include 'header.php'; ?>
<div>
<div class="container box">
    <button type="button" name="refresh" id="refresh" class="btn btn-default">
        Refresh
    </button>
    <div class="form-inline"
    <label for="search" id="search" class="font-weight-bold lead text-dark">Search: </label>
    <input type="text" name="search_text" id="search_text" placeholder="Search"
           class="form-control"/>
</div>
<div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-notify modal-info" role="document">
        <div class="modal-content text-left">
            <form method="post" id="user_form">
                <div class="modal-body">
                    <label>Enter Name</label>
                    <input type="text" name="name" id="name" class="form-control" required/>
                    <label>Enter Description</label>
                    <input type="text" name="description" id="description" class="form-control" required/>
                    <label>Enter Price</label>
                    <input type="text" name="price" id="price" class="form-control" required/>
                    <label>Select Image</label>
                    <input type="file" name="image" id="image" required/>
                    <img src="" id="my_image" class="img-responsive">
                </div>
                <div class="modal-footer" align="center">
                    <input type="hidden" name="action" id="action"/>
                    <input type="hidden" name="user_id" id="user_id"/>
                    <input type="submit" name="button_action" id="button_action" class="btn btn-success"
                           value="Insert"/>
                    <a type="button" class="btn btn-danger" id="exit" data-dismiss="modal">Exit</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="user_table" class="table-responsive">
</div>
<button type="button" class="btn btn-primary" id="adding" data-toggle="modal" data-target="#modalPush">Add</button>
</div>
<?php include 'footer.php'; ?>

</body>
</html>
<script type="text/javascript" src="script.js"></script>