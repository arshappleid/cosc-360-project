#### Admin Account Walkthrough

1. Navigate to `localhost/client/admin_login.php` and log in using `test@gmail.com` and `password` for the password.
2. This will take you to the homepage of the website where most of the implemented functionality is available.
   - Test out the product search by entering the name of the product, and then clicking on search. You can even filter your search based on a store, and then only search for products within that store.
   - You can also check out the latest weather in some of the famous cities of Canada, utilizing the [Free Weather API](https://open-meteo.com/). The functionality implemented fetches the latest responses every 15 minutes and then stores them in the database. Therefore, new results are only fetched every 15 minutes, so that we can reduce requests to the API to save on costs.
     - This can be tested by observing how fast the page reloads every time you look up the weather for a different new city. As to every time you change the weather back to a site that you looked up in the past.
   - You can also upvote a product, and by default, the product with the highest upvotes will show at the top. And if two products have the same votes, then the item that was added the latest will be shown at the top.
   - Since you are logged in as an admin, you can also add new comments or delete other users' comments.
   - Click on the `Manage Users` button to manage all the users that can access the website. Here once a user has been banned, he will not be allowed to access the website.
     - Ban `user@gmail.com` user, and then go to `login.php` page and try logging in using `user@gmail.com` and `password` to test this functionality out.
     - Over here you can also track how many times each user has logged in this month. This statistic will reset at the start of every month.
     - You can click the `User Details` button to view all the selected users information and all the comments they have made.
       - From the User Detail page you can go to the item they made the comment on's page.
     - At this point, you can also test out the breadcrumbs functionality to navigate back to previous pages.
     - Enter queries into the search bar to search for the first name, last name, or email of users 
     - you can also filter the users by selecting All Users, Active Users, or Inactive users from the dropdown menu and pressing Search. This filter works   along with the search bar.
     - When you press Toggle Ban it will ban or unban the user, and the User Information table on the sccreen will reflect that immediately.
     - The User Details button brings up page dedicated to each user with their information and all comments they've made, with the most recent at the top.
     - By clicking the "go to item" button, it will take you to the page for the item that will show us the price chart for the item as well as all the comments for the item.


   #### User Account Walkthrough

      1. Navigate to `localhost/client/login.php`, and log in using `user@gmail.com` and `password` for the password.
      2. The user primarily only has access to deleting their own comments and adding new ones. They can also upvote an item.
      3. Users can also navigate to their account page once logged in.
      - From there they can edit their own first and last name, password, and profile picture in the database.
      4. You can also try navigating to `localhost/client/display_users.php` from the URL search bar which is an admin website, and a user should not have access to. This will take you to the <u>bad navigation page</u>.
      5. You should also be able to add a comment , and delete your own comment.

   #### Guest User Walkthrough

   1. Guest users are allowed to view the Homepage, that gives them access to view all the prices, comments, and view all hot items at a store.
   2. At this point, you can click on the `Login` button and navigate to create a new User account.
   3. Guests can then submit their name, email, and password to create an account.
      - on succesful account creation they will be redirected to the log in page, or if an error message occurs they will be routed back to the create account page with an error.
