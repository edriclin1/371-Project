<?PHP
session_start();

// connect to database
$l = mysqli_connect("localhost:6306","student12","pass12","student12");

?>

<html>
    <head>
        <title>Welcome User</title>
    </head>
    <body>
        // careful with the website names and accessing different pages
        <p>Welcome to BlackBoard V2! You are welcome to register for courses, check your grades, and modify your account.</p>
        <br />
        <br />
        <center><a href="https://cis371student15.ddns.net:9015/Project/project/passchange.php">Change Password</a></center>
        <br />
        <center><a href="">Register</a></center>
        <br />
        <center><a href="">Current Grades</a></center>
        <br />

    </body>
</html>