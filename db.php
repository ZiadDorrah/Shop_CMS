<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=shop_cms", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }

      if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['submit']) && $_POST['submit'] == 'Log out'){


        unset($_SESSION['user']);
        session_destroy();
    
        header("Location: index.php");
    }

?>