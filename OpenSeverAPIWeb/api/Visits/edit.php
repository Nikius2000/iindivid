<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if(isset($_GET['id']) && isset($_GET['status'])){

        $t_id = $_GET['id'];
        $t_status = $_GET['status'];

        $sql = "UPDATE Public_Visits SET status = {$t_status} WHERE id = {$t_id}";
        $stmt = sqlsrv_query( $conn, $sql );

        echo json_encode("OK");
    }else{
        echo json_encode("error");
    }
?>