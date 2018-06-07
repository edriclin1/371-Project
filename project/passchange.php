<?PHP
session_start();

// connect to database
$l = mysqli_connect("localhost:6306","student12","pass12","student12");

echo "Here you can change your password. Enter your new password below";
?>

<html>
    <head>
        <title>Changing Password</title>
    </head>
    <form action="update.php" method="POST">
        Old Password: <input type=password name=oldPassword>
        <br />
        <br />
        New Password: <input type=password name=newPassword>
        <br />
        <br />
        <input type=submit name=Change>
    </form>
</html>