<html>

<head>
    <title>Hello , All Related Data</title>
    <meta charset="utf8_decode">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['show'])) {
            echo "<h1>show all data" . $_POST['selectedId'] . "</h1>";

            echo '
        <div class="data">
        <h2>============================================</h2>
    
        <h2>============All Student  Related Data=============</h2>
    
        <table>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>id</th>
            <th>name</th>
            <th>course</th>    
            <th>department</th>
          </tr> 



          ' , getData($_POST['selectedId']) , '
          
        </table>
    
     
      </div>
        ';
        } else {
            echo "u can't enter here";
        }

        //-----------------------------------phone field

        //-----------------------------------email field



    } //------------------------------------if not came from post method






    function getData($id)
    {


        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "faculty";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT students.* , courses.* FROM `students` INNER JOIN courses ON students.name 
      = courses.student_name AND students.id = $id;");
            $stmt->execute();

            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();


            foreach ($result as $row) {
                $id = $row['name'];
                echo "<tr class='tableRow'>" .
                    "<td>" . $row['id'] . "</td>" . "<td>" . $row['name'] . "</td>" . "<td>" . $row['phone'] . "</td>" .
                    "<td>" . $row['email'] . "</td>" . "<td>" . $row['id'] . "</td>"
                    . "<td>" . $row['student_name'] . "</td>"
                    . "<td>" . $row['course'] . "</td>" . "</td>" . "<td>" . $row['department'] . "</td>"

                    . "</tr>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
    }


    ?>



</body>

</html>