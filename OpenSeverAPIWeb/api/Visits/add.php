<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    $_s_date = $_POST['_s_date'];
    $_po_date = $_POST['_po_date'];
    $_purpose = $_POST['_purpose'];
    $_Division = $_POST['_Division'];
    $_fio = $_POST['_fio'];
    $_f_name = $_POST['_f_name'];
    $_n_name = $_POST['_n_name'];
    $_o_name = $_POST['_o_name'];
    $_tel = $_POST['_tel'];
    $_email = $_POST['_email'];
    $_organization = $_POST['_organization'];
    $_node = $_POST['_node'];
    $_date_age = $_POST['_date_age'];
    $_ser_passport = $_POST['_ser_passport'];
    $_num_passport = $_POST['_num_passport'];

    $sql = "INSERT INTO Public_Visits (i_name, f_name, o_name, phone, email, organization, note, date_age, ser_passport, num_passport, date_start, date_stop, purpose, staff_ID, division, status, miss)
    values('{$_n_name}','{$_f_name}','{$_o_name}','{$_tel}','{$_email}','{$_organization}','{$_node}','{$_date_age}','{$_ser_passport}','{$_num_passport}','{$_s_date}','{$_po_date}','{$_purpose}','{$_fio}','{$_Division}', 0, 0)";

        sqlsrv_query( $conn, $sql);
?>