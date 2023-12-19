<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if(isset($_GET['id'])){
        
        $tid = $_GET['id'];
        $sql = "SELECT * FROM Public_Visits WHERE id = {$tid}";
        sqlsrv_query( $conn, $sql);
        $stmt = sqlsrv_query( $conn, $sql,);
    
        $arr = [];
    
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $arr[] = $row;
        }

        echo json_encode($arr);
    }else if(isset($_GET['status'])){
        
        $tid = $_GET['status'];

        if(isset($_GET['miss'])){
        
            $tmiss = $_GET['miss'];
            $sql = "SELECT * FROM Public_Visits WHERE status = {$tid} and miss = {$tmiss}";
            sqlsrv_query( $conn, $sql);
            $stmt = sqlsrv_query( $conn, $sql,);
        
            $arr = [];
        
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
                $arr[] = $row;
            }
    
            echo json_encode($arr);
        }else{
            $sql = "SELECT * FROM Public_Visits WHERE status = {$tid}";
            sqlsrv_query( $conn, $sql);
            $stmt = sqlsrv_query( $conn, $sql,);
        
            $arr = [];
        
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
                $arr[] = $row;
            }

            echo json_encode($arr);
        }
    }else{

        $sql = "SELECT * FROM Public_Visits";
        sqlsrv_query( $conn, $sql);
        $stmt = sqlsrv_query( $conn, $sql,);
    
        $arr = [];
    
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $arr[] = $row;
        }
    
    
        echo json_encode($arr);
    }
?>