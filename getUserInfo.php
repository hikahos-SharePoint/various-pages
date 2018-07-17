<?php
    // include file containing db connection properties
    include 'dbConnect.php';
    
    // get the user's info from the ssl cert
    if (isset($_SERVER['HTTPS'])) {
        // create an array from the user name
        $arrName = explode(' ', $_SERVER['SSL_CLIENT_S_DN_CN']);
        // create a PHP object 'user' and its properties
        $user->FirstName = $arrName[1];
        $user->LastName = $arrName[0];
        $user->FullName = $arrName[1] . ' ' . $arrName[0];
        $user->UName = $arrName[2];
        $user-UserID = substr($_SERVER['SSL_CLIENT_SAN_Email_0'],0,strpos($_SERVER['SSL_CLIENT_SAN_Email_0'],'@'));
        $user->WorkEmail = $_SEVER['SSL_CLIENT_SAN_Email_0'];
    }
    
    // get the rest of the user's info from the Users table
    $conn = OpenCon();
    
    $userID = "'" . $user->userID . "'";
    $tableName = "Users";
    $sql = "SELECT Department, WorkPhone FROM $tableName WHERE UserID = $userID";
    // run query
    if ($result = $conn->query($sql)) {
        $outp = $result->fetch_assoc();
        // add department and workphone to the user object
        $user->Department = $outp["Department"];
        $user->WorkPhone = $outp["WorkPhone"];
    } else {
        echo 'no results';
    }
    CloseCon($conn);
    
    // convert PHP object 'user' to JSON object
    $userJSON = json_encode($user);
    echo $userJSON;
    // echo '<script>console.log(' . $userJSON . ');</script>';
?>