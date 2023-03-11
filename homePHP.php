<html>

<head>
  <title>Hello , Contact Form</title>
  <meta charset="utf8_decode">
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <?php

  $nameErr = $phoneErr = $mailErr = "*";
  $result = "";
  $name = $phone = $mail = "";
  $chkName = $chkPhone = $chkEmail = false;
  $test = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
      echo "<h1>Same page update</h1>";
    } elseif (isset($_POST['delete'])) {
      echo deleteData($_POST['deletedId']);
    }
    if (empty($_POST['username'])) {
      $nameErr = "please enter user name";
    } else {
      //-----------------------------------name field
      $name = testInput($_POST['username']);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Only letters and white space allowed";
      } else {
        $chkName = true;
      }
    }
    //-----------------------------------phone field
    if (empty($_POST['phone'])) {
      $phoneErr = "please enter phone";
    } else {

      $phone = testInput($_POST['phone']);
      if (!preg_match("/^[0-9]*$/", $phone)) {
        $phoneErr = "Only numbers";
      } else {
        $chkPhone = true;
      }
    }
    //-----------------------------------email field

    if (empty($_POST['email'])) {
      $mailErr = "please enter email";
    } else {
      $mail = testInput($_POST['email']);
      // check if e-mail address is well-formed
      if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $mailErr = "Invalid email format";
      } else {
        $chkEmail = true;
      }
    }
    //---------------------------------------check if all field done
    if ($chkName && $chkPhone && $chkEmail) {
      //-----------------------------------call insert data
      $result  = $name . $phone . $mail . "  ===   " . insertData($name, $phone, $mail);
    } else {
      $test = "all data will not exist";
    }
  } //------------------------------------if not came from post method
  else {
    $nameErr = $phoneErr = $mailErr = "*";
  }


  function testInput($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function deleteData($id)
  {


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "faculty";
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "DELETE FROM students WHERE id ='$id' ";

      // Prepare statement
      $stmt = $conn->prepare($sql);

      // execute the query
      $stmt->execute();
      return "data will delete with id : $id";
    } catch (PDOException $e) {
      return  $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
  }
  function insertData($name, $userphone, $usermail)
  {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "faculty";

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "INSERT INTO `students`(`name`, `phone`, `email`) VALUES ('$name', '$userphone', '$usermail')";
      // use exec() because no results are returned
      $conn->exec($sql);
      $name = $phone = $mail = "";

      return "New record created successfully";
    } catch (PDOException $e) {
      return $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
  }


  function getData()
  {


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "faculty";

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT * FROM `students`");
      $stmt->execute();

      // set the resulting array to associative
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();


      foreach ($result as $row) {
        $id = $row['name'];
        echo "<tr class='tableRow'>" . "<td>" . $row['id'] .
          "</td>" . "<td>" . $row['name'] . "</td>" . "<td>" . $row['phone'] .
          "</td>" . "<td>" . $row['email'] . "</td>"
          . "<td>" .
          //       "<form action='delete_data.php' method='post' > <input type='hidden' name='id' value=" . $row['id']." > 
          "<form action='update_student.php' method='post' > <input type='hidden' name='id' value=" . $row['id'] . " > 
          <input type='hidden' name='name' value=" . $row['name'] . " > 
          <input type='hidden' name='phone' value=" . $row['phone'] . " >
           <input type='hidden' name='email' value=" . $row['email'] . " > 
          <input type='submit' class='update btn' name='update' value='update_data'>"
          . "</form>" . "</td>" .
          "<td>" .
           "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' > 
          <input type='hidden' name='deletedId' value=" . $row['id'] . " > 
          <input type='submit' class='delete btn' name='delete' value='delete_data'>"
          . "</form>" . "</td>". 
          "<td>" .
          "<form action='show_all_data.php' method='post' > 
          <input type='hidden' name='selectedId' value=" . $row['id'] . " > 
          <input type='submit' class='update btn' name='show' value='show all data'>"
          . "</form>" . "</td>";
          ;
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
  }


  ?>

  <div class="insertdata">
    <form class="contact_form" method="post" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <h1>Add New Student Data</h1>
      <input class="inputfield" type="text" value="<?php echo $name; ?>" name="username" placeholder="enter user name"><span class="err"><?php echo $nameErr; ?></span> <br>
      <input class="inputfield" type="text" value="<?php echo $phone; ?>" name="phone" placeholder="enter phone"><span class="err"><?php echo $phoneErr; ?></span> <br>
      <input class="inputfield" type="mail" name="email" value="<?php echo $mail; ?>" placeholder="enter user mail"><span class="err"><?php echo $mailErr; ?></span> <br>
      <input class="btn" type="submit" value="insert">
    </form>
    <h2><?php
        //echo $result; 
        ?></h2>

  </div>
  <div class="data">
    <h2>============================================</h2>

    <h2>============All Student Data=============</h2>

    <table>
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Update</th>
        <th>Delete</th>
        <th>Show all data</th>
      </tr>
      <?php echo getData(); ?>
    </table>


    <h2>============ <?php echo $test; ?>=============</h2>

  </div>
</body>

</html>