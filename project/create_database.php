<?PHP

// connect to blackboard rest api
$clientURL = "http://bb.dataii.com:8080";

require_once('classes/Rest.class.php');
require_once('classes/Token.class.php');

$rest = new Rest($clientURL);
$token = new Token();

$token = $rest->authorize();
$access_token = $token->access_token;

// get user data from blackboard rest api
$users = $rest->readAllUsers($access_token);
$u=$users->results;

// get course data from blackboard rest api
$courses = $rest->readAllCourses($access_token);
$c=$courses->results;


// connect to mysql database
$l=mysqli_connect("localhost:6306","student12","pass12","student12");

// delete students table if one has already been created
$query = "DROP TABLE Students";
$r = mysqli_query($l,$query);

// recreate students table
$query = "CREATE TABLE Students (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(30) NOT NULL,
    given_name VARCHAR(30) NOT NULL,
    family_name VARCHAR(30) NOT NULL,
    password VARCHAR(8)
    )";
$r = mysqli_query($l,$query);

// insert blackboard student data into table
foreach($u as $row) {

    // check if user is a student
    $institution_role_id = $row->institutionRoleIds[0];
    if (strcmp($institution_role_id, "STUDENT") == 0) {

        // get student fields
        $user_name = $row->userName;
        $given_name = $row->name->given;
        $family_name = $row->name->family;

        // insert fields into database
        $query = "INSERT INTO Students (user_name, given_name, family_name) values ('$user_name', '$given_name', '$family_name')";
        $r = mysqli_query($l,$query);
    }
}

// delete courses table if one has already been created
$query = "DROP TABLE Courses";
$r = mysqli_query($l,$query);

// recreate students table
$query = "CREATE TABLE Courses (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(50) NOT NULL
    )";
$r = mysqli_query($l,$query);

// insert blackboard course data into table
foreach($c as $row) {

    // get course fields
    $course_name = $row->name;

    echo $course_name."<br>";

    // insert fields into database
    $query = "INSERT INTO Courses (course_name) values ('$course_name')";
    $r = mysqli_query($l,$query);
}

?>