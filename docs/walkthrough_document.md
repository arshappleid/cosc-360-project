### Grocery Tracker 

#### How to Test Out the application.

1. Navigate to ```localhost/client/admin_login.php``` , and login in using ``test@gmail.com`` and ``password`` for the password. 
2. Which will take you to the home page of the website. Most of the implemented functionality is at this page.
   - Test out the search for product , by entering the name for the product , and then clicking on search. You can even filter your search based off a store, and then only search for products within that store.
   - You can also checkout the latest weather, in some of the famous cities of Canada , utilizing the [Free Weather API](https://open-meteo.com/) . Functionality implemented fetches the latest responses every 15 minutes, and then stores them in the database. Therefore new results are only fetched every 15 minutes, so that we can reduce requests to the API , to save on costs.
   - You can also upvote a product , and by default Product with the highest upvotes will show at the top. And if 2 products have the same votes, then the item that was added the latest will be shown at the top.
   - Since you are logged in as an admin , You can also add new comments , or delete other users comments.
   - Click on the ```Manage Users``` button to manage all the users that can access the 
