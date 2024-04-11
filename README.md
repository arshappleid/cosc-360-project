# COSC 360 Webserver Link

https://cosc360.ok.ubc.ca/qfinocch/index.php

# Project Overview and Requirements

The **GroceryPriceTracker** website will allow registered users to engage in online tracking of item prices at different stores by entering and tracking items for given times and locations. Unregistered users will be able to view general price trends in real time. The goal is to produce a service that will allow users to track item prices in real time, set alerts and comment on items.  Functionality must exist for searching/categorizing items.  Additionally, unregistered users must be able to search and view item prices but not see the details of items. Registered users should be able to leave comments/feedback. Functionality must exist for searching/categorizing items.

The website/project mostly utilized PHP, JS , HTML , and CSS to provision the website for users, and provides basic client and admin authentication. It also utilizes mysql database to store user images, as well as images for items. The website also relies on [Free Weather Api](https://open-meteo.com/) to provide latest weather for top 10 canadian cities. 

### Repo Structure

```bash
.
├── docs 									# All project documentation
│ ├── Layout.pdf 							# Scope and Charter
│ ├── security_documentation.pdf 			# Explains Security Features implemented
│ ├── tasks_completed.md					# Report of Individuals Tasks Completed
│ ├── sameple_item_records.txt 				# Sample .txt upload for Bulk Add Item Feature
│ └── ...
├── database 								# Database init.sql, ER-Diagram
├── src (All of our codebase)
│	├── client/ 							# All Client Side Code
│ 	│	├── css/ 							# All External Stylesheets
│ 	│	├── scripts/						# All External JS files
│ 	│	├── ... 							# Remaining html / php files
│ 	├── server/								# All Server side code
│  	│   ├── functions/ 						# All SQL based functions to perform queries
│   │   │ 	│── db_connection.php			# Database connection file
│	│	│	└── ...							
│	│	└── ...								# Remaining PHP code to act as API endpoints
│ 	└── tests/								# All Unit Tests
└── README.md


```

## Getting Started with Developement

1. Run the following command for development environment : ``docker compose up -d``.
   - Run ``bash open_pm_tabs.sh`` if you have a bash shell running.
2. Make sure all containors are healthy.
   - If not , re run the above command again.
3. Viewing the tables on ``localhost:5055`` , under databases select market_database.
   - You should be able to see all the tables here, and also execute additional SQL scripts.
4. Navigate to ``http://localhost:8080/client/login.php`` to access the home page.

### Important Session Variables used :

These variables are accessed using ``$_SESSION['VARNAME']``

1. USER_EMAIL - If Set , the email of the logged in user.
2. ADMIN_EMAIL - If Set , the email of the logged in admin.
3. MESSAGE - If Set , Any usefull message returned by the Server.

### Running Unit Tests

In the Docker Shell , run ``phpunit tests/*`` , Which will run all the tests in the tests folder. To run individual test files, navigate to ```.github/workflows/docker_build.yml``` file , and look up the individual commands for each 

### How to write Unit Tests

1. Make Sure all the tests are kept in the folder ``src/tests/*``
2. Ensure all the functions required for Testing , are part of a class

   ```php
   <?php
   class Class_Name{
   	static function functionName($param){}
   }
   
   ```
3. Import the class in a test File , that has the same name for the testClass
4. Write the tests in the `<u>`same exact notation given below `</u>`, sample test given for file ``User_management_Test.php``

   ```php
   <?php
   use PHPUnit\Framework\TestCase;
   require_once __DIR__ . '/../server/functions/User_management.php';
   class User_management_Test extends TestCase{
   	/** @test */
   	public function validateUserLogin_ValidLogin(){
   		$this->assertEquals(User_management::validateUserLogin("test@gmail.com", MD5("password")), "VALID_LOGIN");
   	}
   
   	/** @test */
   	public function validateUserLogin_InValidLogin(){
   		$this->assertEquals(User_management::validateUserLogin("test2@gmail.com", MD5("password1")), "INVALID_LOGIN");
   	}
   }
   ```
5. In the Docker Shell , run ``phpunit tests/*`` , Which will run all the tests in the tests folder.

### Testing out Bulk Upload

1. Select a sample file from ``docs/sample_item_records.txt``
2. Click on Submit

### Some Automated Code Formatting

#### Auto Fixing Sytax mistakes : indenting , white spaces

```bash
phpcbf --standard=PSR12 --exclude=PSR1.Methods.CamelCapsMethodName,Generic.Files.LineLength,Generic.WhiteSpace.DisallowTabIndent ./
```

#### Generating Logs:

```bash
phpcs --standard=PSR12 --exclude=PSR1.Methods.CamelCapsMethodName,Generic.Files.LineLength,Generic.WhiteSpace.DisallowTabIndent --error-severity=1 --report-full=./logs/phpcs.log ./
```

This will store all the logs in ``src/logs`` folder, and also a folder like this already exists.
