<?php
    include 'dbConnect.php';
    $conn = OpenCon();
    $columns = $_GET['columns'];
    $tableName = $_GET['tableName'];
    $fieldName = $_GET['fieldName'];
    $fieldNameSort = $_GET['fieldNameSort'];
    
    if (isset($fieldNameSort)) {
        $sql = "SELECT " . $columns . " FROM " . $tableName . " ORDER BY " . $fieldNameSort;
    } elseif ($fieldName == "NA") {
        $sql = "SELECT " . $columns . " FROM " . $tableName;
    } else {
        $sql = "SELECT " . $columns . " FROM " . $tableName . " WHERE " . $fieldName . " = " . $fieldValue;
    }
    // echo '<script>console.log(' . $sql . ');</script>';
    if ($result = $conn->query($sql)) {
        $outp = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($outp);
    } else {
        echo json_encode("failure: " . $sql);
    }
    CloseCon($conn);
?>