## Implementation Document

### Repo Structure

The code is mainly seperated into ```client``` and ```server``` side code. The client side main uses php , css to render the html pages. Whereas the server side code has pages that perform server side render, components acting as API to parse requests , a ```functions``` folder which has the important functions that execute the SQL , and get called by the API's to retrieve data from the database. We also came up with a master database method in ```functions/db_connection.php``` called ```executePreparedQuery($query,$params)``` . We called this function by all other functions to execute our SQL Queries. Since this handled preparing the connection and binding the parameters as well,  which simplified executing the remaining queries for us.

We also wrote out unit tests for almost all of our important functions in the ```src/tests/``` repo, which we automated them running through github actions as seen in ```~/.github/workflows/``` which ensured that the team was easily able to debug most of the problems if some functionality was not working. These tests can also be seen through the github actions tab.

### Authentication

For the authentication mechanism, the client side code sends MD5 hashed messages to the <u>server</u> side code. From the Client Side we made use of the [Crypto-js](https://www.npmjs.com/package/crypto-js) library , to convert the text string into Hashed Password. Which were then submitted through the form, to the server functions. 

### Authorization

To ensure that normal users cannot access admin based information , we made sure to use variables ```$_SESSION['ADMIN_EMAIL'] & $_SESSION['USER_EMAIL'] ```  that render certain information based off if they were set or not. Then once the user logs out we unset all the session variables, and delete the session.

### Adding items through file upload

The add bulk items through Admin Console , utilized javascript to parse the text file (client side) then sends multiple POST requests to the add Items function (Server side), which then adds the individual items into the database.

### Database Functions

Located in ```src/server/functions/db_connection.php``` , first parses the right Env variables to get the appropriate  then establish the connection. 

ExecutePreparedQuery Function - Expects a SQL Query , and an array of the binding params , with the first element a string of chars that represent the variable type of the corresponding (sample usage given below). We primarily made use of This function , in almost all of our other functions to query the database. Except some functions that required the usage of SQL Transacations.

```php
public static function itemExists($ITEM_ID){
		$query = "SELECT * FROM ITEMS WHERE ITEM_ID = ?;";
		try {
			$response = executePreparedQuery($query, array('i', $ITEM_ID)); /
			if ($response[0]) {
				if ($response[1] === "NO_DATA_RETURNED") {
					return "ITEM_NOT_EXISTS";
				} elseif (is_array($response[1]) && count($response[1]) >= 1) {
					return "ITEM_EXISTS";
				}
			}
		} catch (Exception $e) {
			echo "Error occurred, when using Database function to try to validate User.<br>";
			echo $e->getMessage();
		}
		return "USER_NOT_EXISTS"; 
	}
```



### Mobile User Requirements

