<?php

include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name=$_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $department=$_POST['department'];
    $degree = $_POST['degree'];
    $mobile = $_POST['mobile'];
    
    $checkQuery = "SELECT * FROM user_info WHERE user_email = '$email'";
    $result = $dbConn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Email already exists
        echo "User with this email already exists!";
    }
    else{
    
    $sql = "INSERT INTO user_info (user_id, user_name, user_email, userPassword, user_department, user_degree, user_mobile) VALUES
     ('$id','$name','$email','$pass','$department', '$degree' , '$mobile')";

    if ($dbConn->query($sql) === TRUE) {
        echo "Registration successful! You can now Login to your Account";
    } else {
        echo "Error: " . $sql . "<br>" . $dbConn->error;
    }
}
    $dbConn->close();
}

?>
