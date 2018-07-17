<?php
    include 'dbConnect.php';
    $conn = OpenCon();
    $id = $_GET['ID'];
    $fieldName = $_GET['fieldName'];
    $fieldValue = $_GET['fieldValue'];
    $tableName = $_GET['tableName'];
    
    if ($fieldName && $fieldValue) {
        $sql = "SELECT * FROM $tableName WHERE $fieldName = '$fieldValue'";
    } elseif ($fieldName && !$fieldValue) {
        $sql = "SELECT $fieldName FROM $tableName";
    } elseif (!$fieldName && !$fieldValue && $id) {
        $sql = "SELECT * FROM $tableName WHERE ID = $id";
    }
    
    // echo '<script>console.log(' . $sql . ');</script>';
    if ($result = $conn->query($sql)) {
        $outp = $result->fetch_assoc();
        echo json_encode($outp);
    } else {
        echo json_encode("no results");
    }
    CloseCon($conn);
?>