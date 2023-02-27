<?php
  session_start();





if(!empty($_SESSION['user']) && !empty($_SESSION['user']['permission']) && $_SESSION['user']['permission'] == 1){ 
  
  include 'db.php';
  
  $stmt = $conn->prepare("SELECT * FROM sub_items");

  $stmt->execute();

  $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if($_SERVER['REQUEST_METHOD'] == "GET" && !empty($_GET['id']) && is_numeric($_GET['id'])){

    $stmt = $conn->prepare("DELETE FROM sub_items WHERE id = ?");

    $stmt->execute(array($_GET['id']));

    header("Refresh:0; url=".$_SERVER['PHP_SELF']);


  }


  if(!empty($_SERVER["REQUEST_METHOD"]) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    

    $requires = ['product', 'price', 'type'];


    foreach($requires as $require)
      if(!isset($_POST[$require]))
        return $showFailed = true;
        
    
    
    $stmt2 = $conn->prepare("INSERT INTO sub_items(type, product, price) VALUES (:typ, :prod, :price)");

    try{
      
      $stmt2->execute(array(
        "typ" => $_POST['type'],
        "prod" => $_POST['product'],
        "price" => $_POST['price']

      ));

    header("location: ".$_SERVER['PHP_SELF']);
      

    }catch(PDOException $e){
  
      $showFailed = true;


    }
        

  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <!-- Main CSS -->
    <link rel="stylesheet" href="resources/css/settings.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="resources/libs/bootstrap/bootstrap.min.css" />
    <!-- fontAwesome -->
    <link rel="stylesheet" href="resources/libs/fontawesome/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings</title>
  </head>
  <body>
  <?php include 'navbar.php'?>

    <h1 class="m-4 mb-5">Sett<span>ing</span>s</h1>
    <div class="container">


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

      <form class="form" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <label class="label mt-2" for="product">Product</label>
        <input
          id="product"
          class="form-control mt-2"
          type="text"
          value=""
          name="product"
          placeholder="Product"
        />
        <!-- ____________________________________________________________________ -->
        <label class="label mt-2" for="price">Price </label>
        <input
          id="price"
          class="form-control mt-2"
          type="text"
          value=""
          name="price"
          placeholder="Price"
        />
        <!-- ____________________________________________________________________ -->
        <div class="submeted">
          <select id="stuts" name="type">
            <option value="storage">Storage</option>
            <option value="ram">Ram</option>
            <option value="cpu">Cpu</option>
            <option value="gpu">Gpu</option>
            <option value="other">Other</option>
          </select>
          <!-- onclick=" addProduct() " -->
          <button
            type="submit"
            class="btn btn-primary m-3 ms-5 submit"
          >
            Submit
          </button>
        </div>
      </form>
    </div>
      <div class="container">
        <div class="col-12 mt-3">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
            <?php
            

            if(!count($items))
              echo '<tr><td colspan="4">No Items found</td></tr>';
            foreach($items as $item){?>
            <tr>
              <td class="text-uppercase"><?php echo $item['type']?></td>
              <td class="text-uppercase"><?php echo $item['product']?></td>
              <td><?php echo $item['price']?></td>
              <td>
                <a
                  href="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $item['id'] ?>"
                  style="color: white; cursor: pointer; text-decoration: none"
                  >
                <button type="button" class="btn btn-danger ">
                    Delete
                  </button>
                </a>
              </td>
            </tr>

            <?php }?>
          </tbody>
          </table>
        </div>
      </div>
    </div>

    <script src="resources/libs/jquery/jQuery.min.js"></script>
    <script src="resources/libs/bootstrap/bootstrap.min.js"></script>
    <script src="resources/libs/fontawesome/all.min.js"></script>
    <script src="resources/js/settings.js"></script>
  </body>
</html>
<?php
}else{
    header("Location: /shop_cms");
}