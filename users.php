<?php

session_start();



if(!empty($_SESSION['user']) && !empty($_SESSION['user']['permission']) && $_SESSION['user']['permission'] == 1){ 

  
  
  include 'db.php';
  

  if(!empty($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id']) && is_numeric($_GET['id'])){

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");


    try{
      
      $stmt->execute(array($_GET['id']));

      header("Location: ".$_SERVER['PHP_SELF']);


    }catch(PDOException $e){
      $showFailed = true;
    }
    $stmt->execute(array($_GET['id']));



  }


  if(!empty($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    $requires = ['name','username','password','permission'];

    foreach($requires as $require)
      if(empty($_POST[$require]))
        return header('Location: index.php');




    
    $stmt = $conn->prepare("INSERT INTO users(name, username, password, permission) VALUES (:name, :user, :pass, :permission)");



    try{
      
      $stmt->execute(array(
        "name"  => $_POST['name'],
        "user"  => $_POST['username'],
        "pass"  => sha1($_POST['password']),
        "permission"  => $_POST['permission']
      ));

      $showSuccess = true;


    }catch(PDOException $e){
      $showFailed = true;
    }
        



    
    

  }
  $stmt2 = $conn->prepare("SELECT * FROM users");
  $stmt2->execute();

  $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);



?>
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
    <?php
      include 'navbar.php';
    ?>
    <div class="container mt-5">
      <div class="team d-flex justify-content-between align-items-center">
        <h1>Your Team</h1>
      </div>
      <hr />
      <div class="container" style="width: 90%">
      <?php  
if(!empty($showSuccess))
  echo '<div class="alert alert-success mt-5" role="alert">
    User Added Successfully
  </div>';
?>
<?php

if(!empty($showFailed))
  echo '<div class="alert alert-danger" role="alert">
  Failed while adding user
</div>';
?>

      <form class="form" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <label class="label mt-2" for="name">Name</label>
        <input
          id="name"
          class="form-control mt-2"
          type="text"
          value=""
          name="name"
          placeholder="Name"
        />
        <!-- ____________________________________________________________________ -->
        <label class="label mt-2" for="user">Username </label>
        <input
          id="user"
          class="form-control mt-2"
          type="text"
          value=""
          name="username"
          placeholder="Username"
        />
        <label class="label mt-2" for="password">Password </label>
        <input
          id="password"
          class="form-control mt-2"
          type="password"
          value=""
          name="password"
          placeholder="Password"
        />
        <label class="label mt-2" for="password">Permission </label>

        <select name="permission" class="form-control mt-2" id="">
          <option value="1">Admin</option>
          <option value="2" selected>User</option>
        </select>
        <!-- ____________________________________________________________________ -->

          <!-- onclick=" addProduct() " -->
          <button
            type="submit"
            class="btn btn-primary mt-4 submit"
          >
            Add member
          </button>
        </div>
      </form>

        <table class="table text-center">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Username</th>
              <th scope="col">Permission</th>
              <th scope="col">Arrival</th>
              <th scope="col">Manage</th>
            </tr>
          </thead>
          <tbody>
            <?php
            

            if(!count($users))
              echo '<tr><td colspan="7">No members found</td></tr>';
            foreach($users as $user){?>
            <tr>
              <td><?php echo $user['name']?></td>
              <td><?php echo $user['username']?></td>
              <td><?php echo $user['permission'] == 1 ? "Admin" : "User"?></td>
              
              <td><?php echo $user['created_at']?></td>
              <td><a
                  href="users.php?id=<?php echo $user['id'] ?>"
                  style="color: white; cursor: pointer; text-decoration: none"
                  >
                <button type="button" class="btn btn-danger btn-sm ">
                    Delete
                  </button>
                </a></td>
            </tr>

            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
    <script src="resources/libs/jquery/jQuery.min.js"></script>
    <script src="resources/libs/bootstrap/bootstrap.min.js"></script>
    <script src="resources/libs/fontawesome/all.min.js"></script>
    <script src="resources/js/main.js"></script>
  </body>
</html>
<?php }else{
  header("Location: index.php");

}?>