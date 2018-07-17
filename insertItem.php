<?php
    include 'dbConnect.php';
    $conn = OpenCon();
    $object = array();
    foreach ($_POST['tableInsert'] as $x => $x_value) {
        if ($x == "tableName") {
            $tableName = $x_value;
        } else {
            $object[$x] = "'" . $x_value . "'";
        }
    }
    $keys = array_keys($object);
    $keyString = implode(",",$keys);
    $values = array_values($object);
    $valueString = implode(",",$values);
    $sql = "INSERT INTO $tableName ($keyString) VALUES ($valueString)";
    // echo '<script>console.log(' . $sql . ');</script>';
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo json_encode()$last_id;
    } else {
        echo 'failure';
    }
    CloseCon($conn);
?>