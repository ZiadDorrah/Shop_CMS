
<?php

  session_start();

  if(!empty($_SESSION['user']) && !empty($_SESSION['user']['permission']) && $_SESSION['user']['permission'] == 1){ 
      
  
        if(!empty($_SERVER["REQUEST_METHOD"]) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $requires = ['type', 'name', 'price', 'min_price','quantity', 'status', 'code'];

        $lapRequires = ['cpu', 'gpu', 'ram', 'storage'];

        // var_dump(in_array('name', $_POST));
        foreach($requires as $require)
          if(!isset($_POST[$require]))
            print_r($_POST);
            // return header("location: index.php");
            // echo 'AA';
            // print_r($_POST);
            
        if($_POST['type'] == 'laptop')
          foreach($lapRequires as $require)
            if(!isset($_POST[$require]))
            return header("location: index.php");



          include 'db.php';

         



          $stmt = $conn->prepare("INSERT INTO items(type, name, price, min_price, quantity, status, hint, code) VALUE (:typ, :name, :price, :min, :qun, :stu, :hint,:code)");
        
          try{
            $stmt->execute(array(
              "typ" => $_POST['type'],
              "name"  => $_POST['name'],
              'price' => $_POST['price'],
              "min"   => $_POST['min_price'],
              "qun"   => $_POST['quantity'],
              "stu"   => $_POST['status'],
              "hint"  => $_POST['hint'],
              "code"  => $_POST['code']
            ));
            

            header("Refresh: 1, url=".$_SERVER["PHP_SELF"]);


          }catch(PDOException $e){

            return $showFailed = true;
          }

        
          
          if($_POST['type'] == 'Laptop'){

            $id = $conn->lastInsertId();
            $arr = array(
              "item_id" => $id,
              'brand' => $_POST['brand'],
              'model' => $_POST['model'],
              'cpu'   => $_POST['cpu'],
              'gpu'   => $_POST['gpu'],
              'ram'   => $_POST['ram'],
              'storage'   => $_POST['storage'],
              'screen'   => $_POST['screen']
            );

        
            $stmt2 = $conn->prepare("INSERT INTO item_details(item_id, brand, model, cpu, gpu, ram, storage, screen) VALUE (:item_id, :brand, :model, :cpu, :gpu, :ram, :storage, :screen)");
  

            try{
              $stmt2->execute($arr);
             

            }catch(PDOException $e){

              return $showFailed = true;
            }
  
            }
     


          if($stmt->rowCount())
            $showSuccess = true;

            

        // $stmt = $conn->prepare("")

      }  

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
      <h1>Add Product :-</h1>
      <hr />
      <form class="row g-3 needs-validation" novalidate method="post">
        <div class="col-md-6 position-relative">
          <label for="validationTooltip01" class="form-label"
            >Product Name :-</label
          >
          <input
            type="text"
            class="form-control"
            id="validationTooltip01"
            value=""
            name="name"
            required
          />
          <div class="invalid-tooltip">Please enter the name!</div>
        </div>
        <div class="col-md-6 position-relative">
          <label for="validationTooltip04" class="form-label"
            >Product Category :-</label
          >
          <select class="form-select" name="type" id="validationTooltip04" required>
            <option selected disabled value="">Choose Category</option>
            <option vale="laptop">Laptop</option>
            <option value="accessory">Accessories</option>
          </select>
          <div class="invalid-tooltip">Please select a valid Category!</div>
        </div>
        <h5 style="margin-top: 25px">status :-</h5>
        <div class="row">
          <div class="form-check ms-5">
            <input
              type="radio"
              class="form-check-input"
              id="validationFormCheck2"
              name="status"
              value="new"
              required
            />
            <label class="form-check-label" for="validationFormCheck2"
              >New</label
            >
          </div>
          <div class="form-check mb-3 ms-5">
            <input
              type="radio"
              class="form-check-input"
              id="validationFormCheck3"
              name="status"
              value="old"
              required
            />
            <label class="form-check-label" for="validationFormCheck3"
              >Old</label
            >
            <!-- <div class="invalid-tooltip">More example invalid feedback text</div> -->
          </div>
        </div>
        <div style="margin-top: 0px" class="col-md-4 position-relative">
          <label for="price" class="form-label"
            >original price :-</label
          >
          <div class="input-group mb-3">
            <input
              type="number"
              class="form-control"
              name="price"
              id="price"
              aria-label="Amount (to the nearest dollar)"
              required
            />
            <div class="invalid-tooltip">Please add number!</div>
          </div>
        </div>
        <div style="margin-top: 0px" class="col-md-4 position-relative">
          <label for="min_price" class="form-label"
            >Min Price :-</label
          >
          <div class="input-group mb-3">
            <input
              type="number"
              class="form-control"
              id="min_price"
              name="min_price"
              aria-label="Amount (to the nearest dollar)"
              required
            />
            <div class="invalid-tooltip">Please add number!</div>
          </div>
        </div>

        <div style="margin-top: 0px" class="col-md-2 position-relative">
          <label for="quantity" class="form-label"
            >Quantity :-</label
          >
          <div class="input-group mb-3">
            <input
              type="number"
              class="form-control"
              id="quantity"
              aria-label="Amount (to the nearest dollar)"
              required
              name="quantity"
            />
            <div class="invalid-tooltip">Please add number!</div>
          </div>
        </div>
          <label for="code" class="form-label"
            >Code :-</label
          >
          <div class="input-group mb-3 d-inline">
            <input
              type="number"
              class="form-control"
              id="code"
              aria-label="Amount (to the nearest dollar)"
              required
              style="width:140px !important"
              name="code"
            />
            <div class="invalid-tooltip">Please add number!</div>
          </div>
        <div style="margin-top: 10px" id="itemDetails" class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"
            >Laptop Details :-</label
          >
          <input type="text" placeholder="Brand" name="brand" class="mt-3 form-control">
          <input type="text" placeholder="Model" name="model" class="mt-2 form-control">
          <input type="text" placeholder="CPU" name="cpu" class="mt-2 form-control">
          <input type="text" placeholder="GPU" name="gpu" class="mt-2 form-control">
          <input type="text" placeholder="Ram" name="ram" class="mt-2 form-control">
          <input type="text" placeholder="Storage" name="storage" class="mt-2 form-control">
          <input type="text" placeholder="Screen" name="screen" class="mt-2 form-control">
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
          ></textarea>
        </div>
        <div class="col-12">
          <button class="btn btn-primary mb-5" type="submit">Add</button>
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