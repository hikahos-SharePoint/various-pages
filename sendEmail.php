<?php
    include 'dbConnect.php';
    $conn = OpenCon();
    
    $id = $_GET['ID'];
    $tableName = $_GET['tableName'];
    $sql = "SELECT * FROM $tableName WHERE Title = '$id' ORDER BY ID DESC LIMIT 1";
    // echo '<script>console.log(' . $sql . ');</script>;
    // run query
    if ($result = $conn->query($sql)) {
        $outp = $result->fetch_assoc();
        
        $headers = "";
        // $headers .= "MIME-Version 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: PHP Mail\r\n";
        
        $mail = mail(
            str_replace(';',',',$outp["To"]) . ", " . str_replace(';',',',$outp["Cc"]),
            $outp["Subject"],
            $outp["Body"],
            $headers
        );
        
        if ($mail) {
            echo "email sent";
        } else {
            echo "email failed";
        }
    } else {
        echo "no results";
    }
    
    CloseCon($conn);
?>