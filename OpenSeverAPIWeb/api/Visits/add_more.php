<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/BD.php";
?>
<?php
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    $data = $_POST['json_data'];

    $PVisits = json_decode($data, true);

    $PVisits_count = count($PVisits);

    $nn = [];
    for($i = 0; $i < $PVisits_count; $i++){

        $_s_date = $PVisits[$i]["_s_date"];
        $_po_date = $PVisits[$i]["_po_date"];
        $_purpose = $PVisits[$i]["_purpose"];
        $_Division = $PVisits[$i]["_Division"];
        $_fio = $PVisits[$i]["_fio"];
        $_f_name = $PVisits[$i]["_f_name"];
        $_n_name = $PVisits[$i]["_n_name"];
        $_o_name = $PVisits[$i]["_o_name"];
        $_tel = $PVisits[$i]["_tel"];
        $_email = $PVisits[$i]["_email"];
        $_organization = $PVisits[$i]["_organization"];
        $_node = $PVisits[$i]["_node"];
        $_date_age = $PVisits[$i]["_date_age"];
        $_ser_passport = $PVisits[$i]["_ser_passport"];
        $_num_passport = $PVisits[$i]["_num_passport"];

        $sql = "INSERT INTO Public_Visits (i_name, f_name, o_name, phone, email, organization, note, date_age, ser_passport, num_passport, date_start, date_stop, purpose, staff_ID, division, status, miss)
        values('{$_n_name}','{$_f_name}','{$_o_name}','{$_tel}','{$_email}','{$_organization}','{$_node}','{$_date_age}','{$_ser_passport}','{$_num_passport}','{$_s_date}','{$_po_date}','{$_purpose}','{$_fio}','{$_Division}', 0, 0)";
        
        sqlsrv_query( $conn, $sql);
    }
    echo json_encode("Добавлено!");
?>