# cosc-360-project

COSC 360 Project

## Getting Started with Developement

1. Run the following command for development environment : ``docker compose up -d``.
   - Run ``bash open_pm_tabs.sh`` if you have a bash shell running.
2. Make sure all containors are healthy.
   - If not , re run the above command again.
3. Viewing the tables on ``localhost:5055`` , under databases select market_database.
   - You should be able to see all the tables here, and also execute additional SQL scripts.
4. Navigate to ``http://localhost:8080/client/login.php`` to access the home page.

## Coding Standard

### Declaring Functions

```javascript
function functionName(variable1 : int , variable2: string){
	return something;
}
```

### Important Session Variables used :

These variables are accessed using ``$_SESSION['VARNAME']``

1. USER_EMAIL - If Set , the email of the logged in user.
2. ADMIN_EMAIL - If Set , the email of the logged in admin.
3. MESSAGE - If Set , Any usefull message returned by the Server.

### Running Unit Tests

In the Docker Shell , run ``phpunit tests/*`` , Which will run all the tests in the tests folder.

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
