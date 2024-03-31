## Goat Document to Deploy the Website

1. Connect VPN using cwl for username , and cwlpassword for password.
2. Use Putty or SSH (for mac) using ```cwl@cosc360.ok.ubc.ca```  and password ```cwlpassword```
3. Add the following file to your root directory in the git repo.

### Add this as <u>index.php</u> in your project's root directory

```php
<?php header("Location: src/client/home.php");?>				## Change this to landing page
```

This will route to your initial starting page, everytime someone comes to your desired location

### Cloning Down the repo

```bash
rm -r public_html				## Need to delete this folder, but will clone repo as public_html
git clone https://github.com/url.git public_html
chmod -R 775 public_html
```

### Setting up the database connecttion , for Mysqli

```php
$connection = mysqli_connect("localhost","student_id","student_id","db_studentid");

### OR
$servername = "localhost"; 
$username = "student_id";
$password = "student_id"; 
$dbname = "db_student_id"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
```

### Access your Website using

https://cosc360.ok.ubc.ca/urcwl/

### Access the Database using

https://cosc360.ok.ubc.ca/phpmyadmin/index.php

Login using the ```student_id``` for username and ```student_id``` for password.

Rerun your init.sql file and build your tables all over again.

