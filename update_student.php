

<html>

<head>
  <title>Hello , Update Form</title>
  <meta charset="utf8_decode">
  <link rel="stylesheet" href="style.css" />
</head>

<body>
<?php


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
        if (isset($_POST['update'])) {
            echo "<h1>welcome Update ".$_POST['id'] ."</h1>";
        
        echo '
        
  <div class="updatedata">
  <form class="contact_form" method="post" action="'.  htmlspecialchars($_SERVER["PHP_SELF"]) .'">
    <input class="inputfield" type="text" value="'.$_POST['name'].'" name="updatedName" placeholder="enter user name"><span class="err"><?php echo $nameErr; ?></span> <br>
    <input class="inputfield" type="text" value="'.$_POST['phone'].'" name="updatedPhone" placeholder="enter phone"><span class="err"><?php echo $phoneErr; ?></span> <br>
    <input class="inputfield" type="mail" name="updatedEmail" value="'.$_POST['email'].'" placeholder="enter user mail"><span class="err"><?php echo $mailErr; ?></span> <br>
    <input  type="hidden" name="updatedId" value="'.$_POST['id'].'" >
   
    <input class="btn" type="submit" name="update_data" value="update">
  </form>
  <h2><?php
      //echo $result; 
      ?></h2>

</div>
        ';
        
        }else if (isset($_POST['update_data'])){
            echo 'update data prissed with ' ,$_POST['updatedId'],$_POST['updatedName'],$_POST['updatedPhone'],$_POST['updatedEmail'];
            updateData($_POST['updatedId'],$_POST['updatedName'],$_POST['updatedPhone'],$_POST['updatedEmail']);
        }
        
    
    }else{
        echo "<h1>sorry</h1>";
    }


    function updateData($id,$name,$phone,$email){


        
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "faculty";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    $sql = "UPDATE `students` SET `name`='$name',`phone`='$phone',`email`='$email' WHERE id ='$id' ";
  
    // Prepare statement
    $stmt = $conn->prepare($sql);
  
    // execute the query
    $stmt->execute();
  
    // echo a message to say the UPDATE succeeded
    echo $stmt->rowCount() . " records UPDATED successfully";
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  
  $conn = null;
    }
?>
</body>

</html>