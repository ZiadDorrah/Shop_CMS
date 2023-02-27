<?php
    

    $user = 0;
    


   


    if(!empty($_SESSION['user']) && $_SESSION['user']['permission'] == 1)
        $user = 1;



?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarTogglerDemo03"
          aria-controls="navbarTogglerDemo03"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Dorrah</a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href=""
                >Home</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="products.php"
                >Products</a
              >
            </li>

            <?php
                if($user){
                    echo '<li class="nav-item">
                        <a class="nav-link" href="add.php">Add</a>
                    </li>';
                    echo '<li class="nav-item">
                        <a class="nav-link" href="settings.php">Settings</a>
                    </li>';
                    echo '<li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                    </li>';
                }
            ?>
            
          </ul>

          <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                <input type="submit" name="submit" class="btn " value="Log out">
        </form>
        </div>
      </div>
</nav>