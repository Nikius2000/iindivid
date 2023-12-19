<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if(isset($_GET['email']) || isset($_GET['password'])){
        
        $temail = $_GET['email'];
        $tpassword = $_GET['password'];

        $sql = "SELECT * FROM Users WHERE email = '{$temail}'";
        sqlsrv_query( $conn, $sql);
        $stmt = sqlsrv_query( $conn, $sql);
    
        $arr = [];
    
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $arr[] = $row;
        }

        if($arr){
            echo json_encode(0);
        }else{
            $gen = generateRandomString();
            $sql_add = "INSERT INTO Users (login, email, password, UCookie) VALUES ('{$temail}', '{$temail}', '{$tpassword}', '{$gen}')";
            sqlsrv_query( $conn, $sql_add);

            echo json_encode(1);
        }

    }

    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>