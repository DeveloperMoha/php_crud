

<html>

<head>
  <title>Hello , Delete Form</title>
  <meta charset="utf8_decode">
  <link rel="stylesheet" href="style.css" />
</head>

<body>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<h1>welcome ".$_POST['id'] ."</h1>";

        if (isset($_POST['update'])) {
            echo "<h1>welcome Update ".$_POST['id'] ."</h1>";
        }
        elseif (isset($_POST['delete'])) {
            echo "<h1>welcome Delete".$_POST['id'] ."</h1>";
        }
    }else{
        echo "<h1>sorry deletttte</h1>";
    }
?>
</body>

</html>