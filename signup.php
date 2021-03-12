<?php

include_once "./resource/Database-local.php";
    // var_dump($_POST);

     
    if(isset($_POST['email'])){

        // iniitiialize ann array to store any error message from the form
        $form_errors = array();

        // Form validation
        $required_fields = array('email','username','password');

        // Looop through the required fields array

        foreach ($required_fields as $name_of_field) {
            if(!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL){
                $form_errors[] = $name_of_field;
            }
        }

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
                    $result =  "<p style='padding:20px; color:green;'>Registeration Successful </p>";
                }

            }catch (PDOException $ex){
                echo "Connnected to DB failed ".$ex->getMessage();
                
                $result =  "<p style='padding:20px; color:red;'> An error occurred".$ex->getMessage()."</p>";
            }

        }else{
            if(count($form_errors) == 1){

                $result =  "<p style='color:red;'> There was 1 error in the form <br>";
                $result .= "<ul style='color:red;'>";
                // loop throuuth erroor array and display all items

                foreach ($form_errors as $error) {

                    $result .= "<li> {$error} </li>";
                }

                $result .= "</ul></p>";

            }else{

                $result = "<p style=' color:red;'> There were " .count($form_errors). " errors in the form <br>";
                $result .= "<ul style='color:red;'>";
                // loop throuuth erroor array and display all items

                foreach ($form_errors as $error) {

                    $result .= "<li> {$error} </li>";
                }

                $result .= "</ul></p>";

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