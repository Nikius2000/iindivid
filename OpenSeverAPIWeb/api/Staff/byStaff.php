<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    if(isset($_GET['division'])){
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        $tdivision = $_GET['division'];
        $sql = "SELECT * FROM Staff WHERE division = '{$tdivision}'";
        sqlsrv_query( $conn, $sql);
        $stmt = sqlsrv_query( $conn, $sql);
    
        $arr = [];
    
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $arr[] = $row;
        }

        echo json_encode($arr);
    }else{
        echo json_encode("error");
    }
?>