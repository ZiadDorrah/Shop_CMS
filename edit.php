
<?php

  session_start();

  if(!empty($_SESSION['user']) && !empty($_SESSION['user']['permission']) && $_SESSION['user']['permission'] == 1){ 

    
    include 'db.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_GET['id']) && is_numeric($_GET['id']) && $_POST['submit'] == "delete"){


      $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");

      try{

        $stmt->execute(array($_GET['id']));
      }catch(PDOException $e){

        
        return header("Location: index.php");
      }

      return header("Location: index.php");
      

      
    }


    if(!empty($_SERVER["REQUEST_METHOD"]) && $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['submit']) && $_POST['submit'] == 'edit'){

      

        $requires = ['price', 'min_price','quantity'];

        // var_dump(in_array('name', $_POST));
        foreach($requires as $require)
          if(!isset($_POST[$require]))
            return false;
          

          $stmt = $conn->prepare("UPDATE items SET price = ?, min_price = ?, quantity = ?, hint = ? WHERE id = ?");
          
          try{
            $stmt->execute(array($_POST['price'], $_POST['min_price'], $_POST['quantity'], $_POST['hint'], $_GET['id']));
            $showSuccess = true;

            header("Refresh: 1, url=".$_SERVER["PHP_SELF"]);

          }catch(PDOException $e){
            return header("Location: index.php");
          }
          
      }  
      
    $stmt2 = $conn->prepare("SELECT * FROM items WHERE id = ?");

    $stmt2->execute(array($_GET['id']));

    if(!$stmt2->rowCount())
      return header("Location: index.php");


    $product = $stmt2->fetch(PDO::FETCH_ASSOC);
 

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
  <?php include 'navbar.php'?>
    
  <?php
  
    if(!empty($showSuccess))
      echo '<div class="alert alert-success mt-5" role="alert">
      Product Added Successfully
    </div>';
  ?>

<?php
  
  if(!empty($showFailed))
    echo '<div class="alert alert-danger" role="alert">
    Failed while adding product
  </div>';
?>

    <div class="container mt-4">
      <div class="d-flex justify-content-between">
        <h1>Edit Product :-</h1>
        <div class="">
          <form action="<?php echo $_SERVER['PHP_SELF'] . '?id='.$product['id']?>" method="post">
          
            <button class="btn btn-danger mb-5" name="submit" value="delete" type="submit">Delete</button>
        </form>
        </div>
      </div>
      <h4><?php echo $product['name']?></h4>
      <hr />
      <form class="row g-3 needs-validation" novalidate method="post">
      <div class="">
      <div style="margin-top: 0px" class="col-md-4 position-relative">
          <label for="validationTooltip01" class="form-label"
            >original price :-</label
          >
          <div class="input-group mb-3">
            <input
              type="number"
              class="form-control"
              name="price"
              id="validationTooltip01"
              aria-label="Amount (to the nearest dollar)"
              value="<?php echo $product['price']?>"
              required
            />
            <div class="invalid-tooltip">Please add number!</div>
          </div>
        </div>
        <div style="margin-top: 0px" class="col-md-4 position-relative">
          <label for="validationTooltip01" class="form-label"
            >Min Price :-</label
          >
          <div class="input-group mb-3">
            <input
              type="number"
              class="form-control"
              id="validationTooltip01"
              name="min_price"
              value="<?php echo $product['min_price']?>"
              aria-label="Amount (to the nearest dollar)"
              required
            />
            <div class="invalid-tooltip">Please add number!</div>
          </div>
        </div>
        <!-- <input type="hidden" value="<?php $product['id']?>" name=""> -->
        <div style="margin-top: 0px" class="col-md-2 position-relative">
          <label for="validationTooltip01" class="form-label"
            >Quantity :-</label
          >
          <div class="input-group mb-3">
            <input
              type="number"
              class="form-control"
              id="validationTooltip01"
              aria-label="Amount (to the nearest dollar)"
              required
              value="<?php echo $product['quantity']?>"
              name="quantity"
            />
            <div class="invalid-tooltip">Please add number!</div>
          </div>
        </div>


      </div>

        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"
            >Any comment :-</label
          >
          <textarea
            name="hint"
            class="form-control"
            id="exampleFormControlTextarea1"
            rows="3"
          ><?php echo $product['hint']?></textarea>
        </div>
        <div class="col-12">
          <button class="btn btn-primary mb-5" name="submit" value="edit" type="submit">Edit</button>
          
        </div>
      </form>
    </div>
    <!-- <footer>
                
                <div class="footer">
                    <div class="footer-content">
                        <a
                        href="https://www.facebook.com/profile.php?id=100002755160251"
                    target="_blank"
                    ><i class="fa-facebook"></i></a>
                    <a href="#" target="_blank"><i class="fa-solid fa-envelope"></i></a>
                </div>
                </div>
            </footer> -->
    <script src="resources/js/validation.js"></script>
    <script src="resources/libs/jquery/jQuery.min.js"></script>
    <script src="resources/libs/bootstrap/bootstrap.min.js"></script>
    <script src="resources/libs/fontawesome/all.min.js"></script>
    <script src="resources/js/main.js"></script>
  </body>
</html>
<?php }else{
    header("Location: /shop_cms");
}