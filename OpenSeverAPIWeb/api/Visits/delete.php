<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if(isset($_GET['id'])){
        
        $t_id = $_GET['id'];
        
        $sql = "DELETE FROM Public_Visits WHERE id = {$t_id};";

        $stmt = sqlsrv_query( $conn, $sql);

        if($stmt){
            $arr = [sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)];

            if($arr[0]){
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
?>