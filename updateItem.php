<?php
    include 'dbConnect.php';
    $conn = OpenCon();
    $tableName = $_POST['tableName'];
    $id = $_POST['ID'];
    $update = "";
    $i = 0;
    foreach ($_POST['tableUpdate'] as $key => $value) {
        $update .= $key . " = '" . $value . "'," . ($i == count($_POST['tableUpdate']) ? ", " : "");
        $i++;
    }
    $update = str_replace('"',"'", $update);
    $update = rtrim($update,", "); // remove comma and space
    echo $update;
    $sql = "UPDATE " . $tblName . " SET " . $update . " WHERE ID = " . $id;
    echo $sql;
    if ($conn->query($sql) === TRUE) {
        echo json_encode("update successful");
    } else {
        echo json_encode("failed to update");
    }
    CloseCon($conn);
?>