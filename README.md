# cosc-360-project

COSC 360 Project

## Getting Started with Developement

1. Run the following command for development environment : ``docker compose up -d``.
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

### Declaring variables

``thisIsMyName ## Camel Cased only``

### Connecting to Database
$db_server = "mysql-server";
$db_user = "root";
$db_pass = "secret";
$db_name = "market_database";

try{
    $con = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
}catch (mysqli_sql_exception $e){
    echo "error" . $e->getMessage();
}


## Database Info

```
password:secret
database: market_database
server:mysql-server
```
