<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if(isset($_GET['id'])){
        
        $tid = $_GET['id'];
        $sql = "SELECT * FROM Users WHERE id = {$tid}";
        sqlsrv_query( $conn, $sql);
        $stmt = sqlsrv_query( $conn, $sql);
    
        $arr = [];
    
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $arr[] = $row;
        }

        echo json_encode($arr);

    }else if(isset($_GET['UCookie'])){
        
        $tid = $_GET['UCookie'];

        $sql = "SELECT * FROM Users WHERE UCookie = '{$tid}'";
        sqlsrv_query( $conn, $sql);
        $stmt = sqlsrv_query( $conn, $sql);
        
        $arr = [];
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $arr[] = $row;
        }

        echo json_encode($arr);
    }else{

        $sql = "SELECT * FROM Users";
        sqlsrv_query( $conn, $sql);
        $stmt = sqlsrv_query( $conn, $sql);
    
        $arr = [];
    
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $arr[] = $row;
        }
    
    
        echo json_encode($arr);
    }
?>