<?php
include_once ("./views/templates/header.php"); ?>
<html>
<head>
    <title>Liên hệ với chúng tôi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="./public/css/header.css" />
</head>
<body>

    <div class="container">
        <h3>Liên hệ với chúng tôi</h3>
        <form action="form-process.php" method="POST">
            <div class="form-group">
                <label for="firstname">Firstname</label>
                <input type="text" name="firstname" id="firstname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="lastname">Lastname</label>
                <input type="text" name="lastname" id="lastname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" name="phone" id="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <input type="text" name="message" id="message" class="form-control" required>
            </div>
            <div class="form-group">
        <button class="btn btn-dark btn-lg btn-block" type="submit">Submit</button>
        <button class="btn btn-dark btn-lg btn-block" type="reset">Reset</button>
    </div>
        </form>
    </div>
    
</body>

</html>
<?php
include_once ("./views/templates/footer.php"); ?>