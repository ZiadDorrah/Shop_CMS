
<?php

session_start();

if(!empty($_SESSION['user'])){



  if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id']) && is_numeric($_GET['id'])){

    $id = $_GET['id'];

    include 'db.php';

    $stmt = $conn->prepare("SELECT * FROM items INNER JOIN item_details ON items.id = item_details.item_id WHERE items.id = ? ");
  
    $stmt->execute(array($id));

    if(!$stmt->rowCount())
      return header('Location: index.php');
    
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT * FROM sub_items");
    
    $stmt->execute();

    $sub_items = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $stmt_cat = $conn->prepare("SELECT DISTINCT type from sub_items");

    $stmt_cat->execute();

    $categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
    

  }else{

      return header('Location: index.php');
      
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <!-- Main CSS -->
    <link rel="stylesheet" href="resources/css/discription.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="resources/libs/bootstrap/bootstrap.min.css" />
    <!-- fontAwesome -->
    <link rel="stylesheet" href="resources/libs/fontawesome/all.min.css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AMR DORRAH</title>
  </head>
  <body>
    <!-- NavBar -->
    <?php include 'navbar.php'?>
    <div class="container p-3">
      <div class="content p-3">
        <!-- Title -->
        <div class="content-title">
          <h1><?php echo $product['name']?></h1>
          <div
            class="content-title-details d-flex justify-content-between align-items-center"
          >
            <h3 class="price"><span id="min_price"><?php echo $product['min_price']?></span> - <span id="price"><?php echo $product['price']?></span></h3>
            <p class="text-black-50">
              <span>Availability: </span>
              <i class="fa-regular fa-square-check"></i>
              <span>in Stock</span>
            </p>
          </div>
          <hr />
        </div>
        <!-- Details about Category -->
        <div class="content-details mb-5">
          <h2>Brand : <span class="text-uppercase"><?php echo $product['brand']?></span></h2>
          <h2>Model : <span class="text-uppercase"><?php echo $product['model']?></span></h2>
          <h2>Seller : <span class="text-uppercase">Dorrah</span></h2>
          <h2>
            CPU :
            <span class="text-uppercase"><?php echo $product['cpu']?></span>
          </h2>
          <h2>
            GPU :
            <span class="text-uppercase"
              ><?php echo $product['gpu']?></span
            >
          </h2>
          <h2>RAM : <span class="text-uppercase"><?php echo $product['ram']?> </span></h2>
          <h2>
            Storage device : <span class="text-uppercase"><?php echo $product['storage']?> </span>
          </h2>
          <h2>Screen : <span class="text-uppercase"><?php echo $product['screen']?></span></h2>
        </div>
        <!-- Cart -->
        <!-- <div class="cart text-center">
          <button class="btn btn-danger w-50">
            <i class="fa-solid fa-cart-plus"></i>
            <span class="cart-add">Add to Cart</span>
          </button>
        </div> -->
      </div>
      <?php
      
        for($i = 0 ; $i < count($categories) ; $i++){
          
      ?>
      <div class="extra mt-2">
        <div class="extra-title"><h5 class="text-uppercase"><?php echo $categories[$i]['type']?></h5></div>
        <div class="extra-subitems d-flex">
          <?php
            foreach($sub_items as $item){
              if($item['type'] == $categories[$i]['type'])
                echo '<div class="extra-item me-3" >
                <label title="'.$item['price'].' LE">'.$item['product'].'</label>
                <input type="checkbox" class="chkbox_item" title="'.$item['price'].' LE" value="'.$item['price'].'" name="" id="">
              </div>';
          ?>
          <?php }?>
          
        </div>

      </div>

      <?php }?>
    </div>
    <footer>
      <!-- Footer -->
      <div class="footer">
        <div class="footer-content">
          <a
            href="https://www.facebook.com/profile.php?id=100002755160251"
            target="_blank"
            ><i class="fa-facebook"></i
          ></a>
          <a href="#" target="_blank"><i class="fa-solid fa-envelope"></i></a>
        </div>
      </div>
    </footer>
    <script src="resources/libs/jquery/jQuery.min.js"></script>
    <script src="resources/libs/bootstrap/bootstrap.min.js"></script>
    <script src="resources/libs/fontawesome/all.min.js"></script>
    <script src="resources/js/main.js"></script>
  </body>
</html>
<?php }else{
  header("Location: /shop_cms");
}?>