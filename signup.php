<?php

include_once "./resource/Database-local.php";
include_once "./resource/utiltites.php";

    // var_dump($_POST);

     
    if(isset($_POST['email'])){

        // iniitiialize ann array to store any error message from the form
        $form_errors = array();

        // Form validation
        $required_fields = array('email','username','password');

      
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

        // Fields that requiires checking for minimun length;
        $fields_to_check_length = array('username' => 4, 'password'=>6);
        
        // call the function to check minimun
        $form_errors = array_merge($form_errors, check_min_length( $fields_to_check_length));

        // call the function to check email
        $form_errors = array_merge($form_errors, check_email( $_POST));

        // check if error array iis empty, if Yes process form data and insert record
        if(empty($form_errors)){

 
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            try{
            $sqlInsert = "INSERT INTO users (username, email, password, join_date) 
                        VALUES(:username,:email, :password, now())";

            $statement =$db-> prepare($sqlInsert);
            $statement->execute(array(':username'=> $username, ':email'=> $email, ':password'=>$hashed_password));

                if($statement->rowCount() == 1){
                    $result =  "<p style='padding:20px; border:1px solid gray; color:green;'>Registeration Successful </p>";
                }

            }catch (PDOException $ex){
                echo "Connnected to DB failed ".$ex->getMessage();
                
                $result =  "<p style='padding:20px;  border:1px solid gray; color:red;'> An error occurred".$ex->getMessage()."</p>";
            }

        }else{
            if(count($form_errors) == 1){

                $result =  "<p style='color:red;'> There was 1 error in the form <p>";
              

            }else{

                $result = "<p style=' color:red;'> There were " .count($form_errors). " errors in the form <p>";
                
            }
        }


    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>
</head>

<body>

    <h2>User Authentication System</h2>
    <hr>
    <h3>Registration Form</h3>

    <?php

        if(isset($result)){
            echo $result;
        }
    ?>

    <?php

    if(!empty($form_errors)){
        echo show_errors($form_errors);
    }
    ?>

    <form method="post" action="">
        <table>
            <tr>
                <td>Email:</td>
                <td><input type="text" value="" name="email"></td>
            </tr>
            <tr>
                <td>Username:</td>
                <td><input type="text" value="" name="username"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" value="" name="password"></td>
            </tr>
            <tr>
                <td></td>
                <td><input style="float: right" type="submit" value="Signin"></td>
            </tr>
        </table>
    </form>

    <p> <a href="index.php">Back</a></P>



</body>

</html>