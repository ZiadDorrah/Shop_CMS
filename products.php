
<?php

  session_start();

  if(!empty($_SESSION['user'])){ 
    
    
    $items = [];

    include 'db.php';


    

    if(isset($_GET['type']) && ($_GET['type'] == 'laptop' || $_GET['type'] == 'accessory')){
      $typeCon = "WHERE type = ?";
      $type = $_GET['type'];
    }else{
      $typeCon = "WHERE ?";
      $type = 1;
    }

    if(isset($_GET['status']) && ($_GET['status'] == 'old' || $_GET['status'] == 'new')){
      $typeStatus = "status = ?";
      $status = $_GET['status'];
    }else{
      $typeStatus = "?";
      $status = 1;
    }




    $name = null;
    if(!empty($_GET['name']) && strlen($_GET['name']) < 20 ){
      $name = filter_var($_GET['name'], FILTER_SANITIZE_STRING);
    }


    $code = null;

    if(!empty($_GET['code']) && is_numeric($_GET['code']) ){
      $codeNum = "code = ?";
      $code = $_GET['code'];
    }else{
      $codeNum = "?";
      $code = 1;
    }


    $stmt = $conn->prepare("SELECT * FROM items $typeCon AND $typeStatus AND $codeNum AND name LIKE '%$name%'");
    
    $stmt->execute(array($type, $status,$code));


    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>
  

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <!-- Main CSS -->
    <link rel="stylesheet" href="resources/css/product.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="resources/libs/bootstrap/bootstrap.min.css" />
    <!-- fontAwesome -->
    <link rel="stylesheet" href="resources/libs/fontawesome/all.min.css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AMR DORRAH</title>
  </head>
  <body>

        <!-- <td>
                <div class="ram">
                  <label class="" for="">RAM: </label>
                  <input
                    class="ms-1"
                    type="checkbox"
                    name="4"
                    id="ram-4"
                    value="4"
                  />
                  <label class="" for="ram-4">4</label>
                  <input
                    class="ms-1"
                    type="checkbox"
                    name="8"
                    id="ram-8"
                    value="8"
                    checked
                  />
                  <label class="" for="ram-8">8</label>
                  <input
                    class="ms-1"
                    type="checkbox"
                    name="16"
                    id="ram-16"
                    value="16"
                  />
                  <label class="" for="ram-16">16</label>
                  <input
                    class="ms-1"
                    type="checkbox"
                    name="32"
                    id="ram-32"
                    value="32"
                  />
                  <label class="" for="ram-32">32</label>
                </div>
                <div class="storage-ssd">
                  <label class="" for="">SSD: </label>
                  <input class="ms-2" type="checkbox" name="128" id="sdd-128" />
                  <label class="" for="sdd-128">128</label>
                  <input
                    class="ms-1"
                    type="checkbox"
                    name="256"
                    id="sdd-256"
                    checked
                  />
                  <label class="" for="sdd-256">256</label>
                  <input class="ms-1" type="checkbox" name="500" id="sdd-500" />
                  <label class="" for="sdd-500">500</label>
                  <input class="ms-1" type="checkbox" name="1T" id="sdd-1T" />
                  <label class="" for="sdd-1T">1T</label>
                </div>
                <div class="storage-hdd">
                  <label class="" for="">HDD: </label>
                  <input class="ms-1" type="checkbox" name="500" id="hdd-500" />
                  <label class="" for="hdd-500">500</label>
                  <input
                    class="ms-1"
                    type="checkbox"
                    name="1T"
                    id="hdd-1T"
                    checked
                  />
                  <label class="" for="hdd-1T">1T</label>
                  <input class="ms-1" type="checkbox" name="2T" id="hdd-2T" />
                  <label class="" for="hdd-2T">2T</label>
                </div>
              </td> -->
    <?php include 'navbar.php'?>
    <div class="container">
      <div class="container overflow-hidden">
        <div class="row gx-5 mt-3">
          <div class="col-9">
            <h3>Categories :-</h3>
          </div>
        </div>
      </div>
      <div
        class="alert alert-dark col-10 mt-2"
        style="margin-left: 30px"
        role="alert"
      >
        <li>
          Categories in Weebly allow you to organize your store so your
          customers can easily find what they're looking for. Since categories
          serve a different purpose in Square, categories cannot be synced
          between Weebly & Square.
        </li>
      </div>
      <form class="">
        <input
          class="form-control search me-2"
          name="name"
          type="search"
          placeholder="Search"
          aria-label="Search"
        />
        <input type="text" name="code" class="form-control mt-3" style="width:140px !important" placeholder="Code">
        <div class="status my-2 d-flex align-items-center">
        <input
            class="used-item"
            type="radio"
            name="status"
            value="all"
            id="all_item"
            checked
          />
          <label class="mx-2" for="all_item">All</label>
          <input
            class="new-item"
            type="radio"
            name="status"
            value="new"
            id="new_item"
            
          />
          <label class="ms-2" for="new_item">New</label>
          <input
            class="ms-3 used-item"
            type="radio"
            name="status"
            value="old"
            id="old_item"
          />
          <label class="ms-2" for="old_item">Old</label>
        </div>
        <div class="status my-2 d-flex align-items-center">
          <input
            class="used-item"
            type="radio"
            name="type"
            value="all"
            id="all_type"
            checked
          />
          <label class="mx-2" for="all_type">All</label>
          <input
            class="new-item"
            type="radio"
            name="type"
            value="laptop"
            id="laptop"
            
          />
          <label class="ms-2" for="laptop">Laptop</label>
          <input
            class="ms-3 used-item"
            type="radio"
            name="type"
            value="accessory"
            id="accessory"
          />
          <label class="ms-2" for="accessory">Accessory</label>
        </div>
        
        <div class="btn-action">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </div>
      </form>

      <div class="col-12 mt-3">
        <table class="table">
          <thead class="table-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Hint</th>
              <th scope="col">Code</th>
              <th scope="col">Quantaty</th>
              <th scope="col">Min Price</th>
              <th scope="col">Price</th>
              <th scope="col">Discription</th>
            </tr>
          </thead>
          <tbody>
            <?php
            

            if(!count($items))
              echo '<tr><td colspan="7">No Items found</td></tr>';
            foreach($items as $item){?>
            <tr>
              <th scope="row">#</th>
              <td><?php echo $item['name']?></td>
              <td><?php echo $item['hint']?></td>
              <td><?php echo $item['code']?></td>
              <td><?php echo $item['quantity']?></td>
              
              <td><?php echo $item['min_price']?></td>
              <td><?php echo $item['price']?></td>
              <td>
                <a
                  href="description.php?id=<?php echo $item['id'] ?>"
                  style="color: white; cursor: pointer; text-decoration: none"
                  >
                <button type="button" class="btn btn-info btn-sm <?php if($item['type'] !== 'laptop') echo 'd-none'?>">
                    Show
                  </button>
                </a>
                <?php
                  if($_SESSION['user']['permission'] == 1){
                ?>
                <a
                  href="edit.php?id=<?php echo $item['id'] ?>"
                  style="color: white; cursor: pointer; text-decoration: none"
                  >
                <button type="button" class="btn btn-primary btn-sm">
                    Edit
                  </button>
                </a>
                <?php }?>
              </td>
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
    header("Location: /shop_cms");
}
