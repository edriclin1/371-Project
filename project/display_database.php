<?PHP

// connect to mysql database
$l=mysqli_connect("localhost:6306","student12","pass12","student12");

// select entire students table
$query = "SELECT * FROM Students";
echo $query;

//executing query
$r = mysqli_query($l,$query);

//working with the recordset
echo "<table border=1 cellpadding=10 >";
echo "<tr><th>ID</th><th>Username</th><th>Given Name</th><th>Family Name</th></tr>";

// display students table
while($row=mysqli_fetch_array($r)) {
    echo "<tr>";
        echo "<td>";
            echo $row['id'];
        echo "</td><td>";
            echo $row['user_name'];
        echo "</td><td>";
            echo $row['given_name'];
        echo "</td><td>";
            echo $row['family_name'];
        echo "</td>";
    echo "</tr>";
}

echo "</table>";

// select entire courses table
$query = "SELECT * FROM Courses";
echo $query;

//executing query
$r = mysqli_query($l,$query);

//working with the recordset
echo "<table border=1 cellpadding=10 >";
echo "<tr><th>ID</th><th>Course Name</th>></tr>";

// display courses table
while($row=mysqli_fetch_array($r)) {
    echo "<tr>";
        echo "<td>";
            echo $row['id'];
        echo "</td><td>";
            echo $row['course_name'];
        echo "</td>";
    echo "</tr>";
}

echo "</table>";

?>