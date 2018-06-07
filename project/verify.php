<?PHP

// connect to mysql database
$l=mysqli_connect("localhost:6306","student12","pass12","student12");

// select entire students table
$query = "SELECT * FROM Students WHERE user_name LIKE '".$_POST["username"]."'";
//echo $query;

//executing query
$r = mysqli_query($l,$query);
$row = mysqli_fetch_array($r);

?>

<html>
    <head>
        <title>Signing In</title>
    </head>
    <body>
        <?PHP
        session_start();
        //print_r($_POST);

        // check correct password
        if($_POST["password"] == $row["password"]) {
            echo "<center><h1>Welcome, " . $row["given_name"] . " " . $row["family_name"] . "!<h1></center>";
            echo "<center><a href=\"https://edriclin1.ddns.net:9012/project/account.php\">Go to your account.</a></center>";
            $_SESSION['auth'] = $_POST['username'];
        } else {
            echo "<center><h1>Oops! You entered an invalid username and password.</h1></center>";
            echo "<center><a href=\"https://edriclin1.ddns.net:9012/project/login.php\">Return to the sign in page.</a></center>";
            //logout
            $_SESSION['auth'] = "";
        }
        ?>
    </body>
</html>