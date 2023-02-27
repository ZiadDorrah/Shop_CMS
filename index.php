<?php 
session_start();

if(!empty($_SERVER["REQUEST_METHOD"]) && $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) {
    
  
  include './db.php';

       
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");

    $stmt->execute(array($_POST['username'], sha1($_POST['password'])));

    if($stmt->rowCount()){

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        unset($user['password']);
        
        $_SESSION['user'] = $user;
    }


}

if(empty($_SESSION['user'])){ ?>
    <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <!-- Main CSS -->
    <link rel="stylesheet" href="resources/css/main.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="resources/libs/bootstrap/bootstrap.min.css" />
    <!-- fontAwesome -->
    <link rel="stylesheet" href="resources/libs/fontawesome/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AMR DORRAH</title>
  </head>
  <body>
    <div class="container-md">
      <div>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" style="max-width: 500px; margin: 0 auto" method="post">
          <h1 style="text-align: center; margin-top: 150px">LOG IN</h1>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label"
              >Username</label
            >
            <input
              type="text"
              class="form-control"
              id="exampleFormControlInput1"
              placeholder="Username"
              name="username"
            />
          </div>
          <div class="row mb-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label"
                >Password</label
              >
              <input type="password" class="form-control" id="login-password" name="password" />
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
      </div>
    </div>
    <script src="resources/libs/jquery/jQuery.min.js"></script>
    <script src="resources/libs/bootstrap/bootstrap.min.js"></script>
    <script src="resources/libs/fontawesome/all.min.js"></script>
    <script src="resources/js/main.js"></script>
  </body>
</html>

<?php }else{
    header("Location: products.php");
}

?>