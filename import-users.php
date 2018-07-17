<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Update Users</title>
        <style>
            #tableData table, th, td {
                border: 1px solid gray;
                border-collapse: collapse;
                padding: 2px 10px;
            }
            #tableHeader, #buttonUpdate {
                display: inline-block;
                margin: 10px;
            }
        </style>
    </head>
    <body>
        <h3 id="tableHeader">Site Users</h3>
        <input id="buttonUpdate" type="button" value="Import to MySQL">
        <div id="tableData"></div>
        
        <script src="jquery"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var data = {};
                $.get("../files/users.csv",function(csvString) {
                    var users = csvString.split("\n"),
                        count = 0,
                        html = "";
                    html += "<table><thead><tr>";
                    html += "<th>ID</th>";
                    html += "<th>UserID</th>";
                    html += "<th>LastName</th>";
                    html += "<th>FirstName</th>";
                    html += "<th>WorkEmail</th>";
                    html += "<th>WorkPhone</th>";
                    html += "<th>Department</th>";
                    html += "</tr></thead><tbody>";
                    
                    $.each(users, function(user) {
                        if (this.trim().length > 0) {
                            thisUser = this.split(",");
                            if (thisUser[4].replace("WorkEmail:","") !== "") {
                                // display data on page in tabular form
                                html += "<tr>";
                                html += "<td>" + thisUser[0].replace("ID:","") + "</td>";
                                html += "<td>" + thisUser[1].replace("UserID:","") + "</td>";
                                html += "<td>" + thisUser[2].replace("LastName:","") + "</td>";
                                html += "<td>" + thisUser[3].replace("FirstName:","") + "</td>";
                                html += "<td>" + thisUser[4].replace("WorkEmail:","") + "</td>";
                                html += "<td>" + thisUser[5].replace("WorkPhone:","") + "</td>";
                                html += "<td>" + thisUser[6].replace("Department:","") + "</td>";
                                html += "</tr>";
                                // populate data object with key value pairs
                                var obj = {
                                    ID:thisUser[0].replace("ID:",""),
                                    ID:thisUser[1].replace("UserID:",""),
                                    ID:thisUser[2].replace("LastName:",""),
                                    ID:thisUser[3].replace("FirstName:",""),
                                    ID:thisUser[4].replace("WorkEmail:",""),
                                    ID:thisUser[5].replace("WorkPhone:",""),
                                    ID:thisUser[6].replace("Department:","")
                                };
                                data[user] = obj;
                                // increment counter
                                count++;
                            }
                        }
                    });
                    
                    html += "</tbody></table>";
                    $("#tableData").append(html);
                    $("#tableHeader").text("Site Users (Count: " + count.toString() + ")");
                });
                
                // insert user records in MySQL
                $("#buttonUpdate").on("click", function() {
                    $(this).attr("value","Updating Users...");
                    var tableName = "Users";
                    // get list of all UserID's
                    var arrUserID = [];
                    var listUserID = {
                        columns:"UserID",
                        filedName:"NA",
                        tableName:tableName
                    }
                    $.ajax({
                        async:false,
                        data:listUserID,
                        url:"../dal/getItems.php",
                        method:"GET",
                        success: function(data) {
                            var arrData = data.split(",");
                            $.each(arrData, function(key,value) {
                                var newValue = value.substr(value.indexOf(":") + 2);
                                newValue = newValue.substr(0,newValue.indexOf("\""));
                                arrUserID.push(newValue);
                            });
                        },
                        error: function(data) {
                            // console.log(data);
                        }
                    });
                    $.when(
                        $.each(data,function(item) {
                            var insertUser = {
                                ID:data[item].ID,
                                UserID:data[item].UserID,
                                LastName:data[item].LastName,
                                FirstName:data[item].FirstName,
                                WorkEmail:data[item].WorkEmail,
                                WorkPhone:data[item].WorkPhone,
                                Department:data[item].Department,
                                tableName:tableName
                            };
                            // insert new user record, if not existing
                            if (arrUserID.indexOf(data[item].UserID === -1) {
                                console.log(data[item].UserID;
                                $.ajax({
                                    data:insertUser,
                                    url:"../dal/insertItem.php",
                                    method:"POST",
                                    success: function(data) {
                                      // console.log(insertUser);  
                                    },
                                    error: function(data) {
                                        console.log(data);
                                    }
                                });
                            }
                        })
                    ).done(function() {
                        alert("Users update completed");
                        console.log("MySQL database updated with new users");
                    });
                    // reset button value
                    $(this).attr("value","Import to MySQL");
                });
            });
        </script>
    </body>
</html>