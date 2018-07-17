<?php
    function OpenCon() {
        $servername = "aws-server";
        $username = "iam-user";
        $password = "password1";
        $dbname = "db-test";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_errno) {
            die("Connection failed: " . $conn->connect_errno);
            echo json_encode("failed to connect to the database");
        }
    }
    function CloseCon($conn) {
        $conn -> close();
    }
?>