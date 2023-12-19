<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if(isset($_GET['login']) && isset($_GET['password'])){
        
        $tlogin = $_GET['login'];
        $tpassword = $_GET['password'];
        
        $sql = "SELECT * FROM Staff WHERE login = {$tlogin} and password = {$tpassword}";

        $stmt = sqlsrv_query( $conn, $sql);

        if($stmt){
            $arr = [sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)];

            if($arr[0]){
                if($arr[0]['department'] == "Охрана"){
                    echo json_encode(1);
                }else{
                    echo json_encode(-1);
                }
            }else{
                echo json_encode(-1);
            }

        }else{
            echo json_encode(-1);
        }

    }else{
        echo json_encode(-1);
    }
?>