<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Update List</title>
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
        <h3 id="tableHeader">Custom List</h3>
        <input id="buttonUpdate" type="button" value="Import to MySQL">
        <div id="tableData"></div>
        
        <script src="jquery"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var data = {};
                $.get("../files/customList.csv", function(csvString) {
                    var items = csvString.split("\n"),
                        count = 0,
                        html = "";
                    html += "<table><thead><tr>";
                    html += "<th>ID</th>";
                    html += "<th>Created</th>";
                    html += "<th>CreatedBy</th>";
                    html += "<th>Modified</th>";
                    html += "<th>ModifiedBy</th><tbody>";
                    
                    $.each(items, function(item) {
                        if (this.trim().length > 0) {
                            var thisItem = this.split("%%");
                            var thisID = validateValue(thisItem[0],"ID:"),
                                thisCreated = validateValue(thisItem[1],"Created:"),
                                thisCreatedBy = validateValue(thisItem[2],"CreatedBy:"),
                                thisModified = validateValue(thisItem[3],"Modified:"),
                                thisModifiedBy = validateValue(thisItem[4],"ModifiedBy:");
                            // display data on page in tabular form
                            html += "<tr>";
                            html += "<td>" + thisID + "</td>";
                            html += "<td>" + thisCreated + "</td>";
                            html += "<td>" + thisCreatedBy + "</td>";
                            html += "<td>" + thisModified + "</td>";
                            html += "<td>" + thisModifiedBy + "</td>";
                            html += "</tr>";
                            // populate data object with key value pairs
                            var obj = {
                                ID:thisID,
                                Created:thisCreated,
                                CreatedBy:thisCreatedBy,
                                Modified:thisModified,
                                ModifiedBy:thisModifiedBy
                            };
                            data[item] = obj;
                            // increment counter
                            count++;
                        }
                    });
                    html += "</tbody></table>"; 
                    $("#tableData").append(html);
                    $("#tableHeader").text("Custom List (Count: " + count.toString() + ")");
                });
                // insert records in MySQL
                $("#buttonUpdate").on("click", function() {
                    $(this).attr("value","Updating db-table...");
                    var tableName = "db-table";
                    // get list of all ID's
                    var arrID = [];
                    var listID = {
                        columns:"ID",
                        fieldName:"NA",
                        tableName:tableName
                    }
                    $.ajax({
                        async:false,
                        data:listID,
                        url:"../dal/getItems.php",
                        method:"GET",
                        success: function(data) {
                            var arrData = data.split(",");
                            $.each(arrData, function(key,value) {
                                var newValue = value.substr(value.indexOf(":") + 2);
                                newValue = newValue.substr(0,newValue.indexOf("\""));
                                arrID.push(newValue);
                            });
                        },
                        error: function(data) {
                            // console.log(data);
                        }
                    });
                    $.when(
                        $.each(data,function(item) {
                            var insertItem = {
                                ID:data[item].ID,
                                Created:data[item].Created,
                                CreatedBy:data[item].CreatedBy,
                                Modified:data[item].Modified,
                                ModifiedBy:data[item].ModifiedBy,
                                tableName:tableName
                            }
                            // insert new record, if not existing
                            if (arrID.indexOf(data[item].ID) === -1) {
                                console.log(data[item].ID);
                                $.ajax({
                                    data:insertItem,
                                    url:"../dal/insertItem.php",
                                    method:"POST",
                                    success: function(data) {
                                        // console.log(JSON.parse(data));
                                    },
                                    error: function(data) {
                                        console.log(data);
                                    }
                                });
                            }
                        })
                    ).done(function() {
                        alert("db-table update completed");
                        console.log("MySQL database updated with new items");
                    });
                    $(this).attr("value","Import to MySQL");
                });
                
                // validating values
                function validateValue(value,str) {
                    return value !== undefined ? value.replace(str,"") : "";
                }
            });
        </script>
    </body>
</html>