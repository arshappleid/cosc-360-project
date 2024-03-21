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

### Important Session Variables used :

These variables are accessed using ``$_SESSION['VARNAME']``

1. USER_EMAIL - If Set , the email of the logged in user.
2. ADMIN_EMAIL - If Set , the email of the logged in admin.
3. MESSAGE - If Set , Any usefull message returned by the Server.
