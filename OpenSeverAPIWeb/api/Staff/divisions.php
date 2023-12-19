<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    $sql = "SELECT MIN(id) AS id, division FROM Staff GROUP BY division";
        sqlsrv_query( $conn, $sql);
        $stmt = sqlsrv_query( $conn, $sql);
    
        $arr = [];
    
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $arr[] = $row;
        }

        echo json_encode($arr);
?>