<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if(isset($_GET['id']) && isset($_GET['miss'])){
        
        $tid = $_GET['id'];
        $tmiss = $_GET['miss'];

        $sql = "UPDATE Public_Visits SET miss = {$tmiss} WHERE id = {$tid};";
        $stmt = sqlsrv_query( $conn, $sql,);

        echo json_encode("OK");
    }else{
        echo json_encode("error");
    }
?>