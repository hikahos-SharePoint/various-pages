# various-pages
   * export-users.html - the page will display the SharePoint site users in a tabular view; it has functionality to export the users list to a csv file (use in SharePoint)
   * import-users.php - the page will read the csv file created by 'export-users' page and display the users in a tabular view; it has functionality to insert the user records into a MySQL database (run in PHP server)
   * export-list.html - same as 'export-users', but using a custom list as data source
   * import-list.php - same as 'import-users', but using the csv file created by 'export-list' page

   - various PHP files for database operations:
      * dbConnect.php - contains service account credentials for the MySQL database
      * getUserInfo.php - gets info about the logged in user using SSL certificate
      * sendEmail.php - sends email using PHP mail function
      * getItem.php - selects a single record
      * getItems.php - selects multiple records
      * insertItem.php - inserts a single record
      * updateItem.php - updates one or more records
