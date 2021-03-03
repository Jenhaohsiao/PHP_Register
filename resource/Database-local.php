<?php

try {
    $date = new DateTime();
} catch (Exception $e) {
    echo $e->getMessage();
    exit(1);
}

echo $date->format('Y-m-d h:m:s');
?>
</br>
<?php
echo "Try to connnect DB by PDO"; 
?>
</br>
<?php
$host = 'localhost';
$database = 'Register';

$dsn = 'mysql:host=localhost;dbname=Register';
$user = 'root';
$passwd = '';
 
    try{
        $db  = new PDO($dsn, $user, $passwd);
        $db-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connnected to DB successfuly";   
    }catch (PDOException $ex){
        echo "Connnected to DB failed ".$ex->getMessage();   
    }

?>

</br>
<?php


// // another one
// echo "Try to connnect another DB"; 
// $host = 'localhost';
// //改成你登入phpmyadmin帳號
// $user = 'abunda12_phpLearn';
// //改成你登入phpmyadmin密碼
// $passwd = '';
// //資料庫名稱
// $database = 'abunda12_phpLearn_Register';
// //實例化mysqli(資料庫路徑, 登入帳號, 登入密碼, 資料庫)
// $connect = new mysqli($host, $user, $passwd, $database);
 
// if ($connect->connect_error) {
//     die("連線失敗: " . $connect->connect_error);
// }
// echo "連線成功";

?>