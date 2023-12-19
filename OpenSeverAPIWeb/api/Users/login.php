<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if(isset($_GET['check'])){
        
        $tid = $_GET['check'];
        $sql = "SELECT * FROM Users WHERE UCookie = '{$tid}'";
        sqlsrv_query( $conn, $sql);
        $stmt = sqlsrv_query( $conn, $sql);
    
        $arr = [];
    
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $arr[] = $row;
        }

        if($arr > 0){
            echo json_encode($arr[0]['UCookie']);
        }else{
            echo json_encode(-1);
        }

    }else if (isset($_GET['email']) && isset($_GET['password'])){

        $temail = $_GET['email'];
        $tpassword = $_GET['password'];

        $sql = "SELECT * FROM Users WHERE email = '{$temail}' and password = '{$tpassword}'";
        sqlsrv_query( $conn, $sql);
        $stmt = sqlsrv_query( $conn, $sql);
    
        $arr = [];
    
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $arr[] = $row;
        }

        if($arr){
            echo json_encode($arr[0]['UCookie']);
        }else{
            echo json_encode(0);
        }

    }
?>