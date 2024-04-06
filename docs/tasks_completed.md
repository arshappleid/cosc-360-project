This document testifies, all the important tasks / milestones completed by all the members for this projects.

#### Prabhmeet Deol

- Setup Docker Containers , Testing Environment, Impot Libraries, Repo Setup.
  - Developed a Continuous Testing pipeline , to test all the unit tests on each push.

- Database Schema Design, All the SQL , and Test Data.
- Admin Login, Validation with MD5 hash Page Server Functionality and Frontend PHP , with form validation.
- Admin Account Creation Functionality.
- Home Page - 
  - Search For items Functionality, using Jquery.
  - Breadcrumbs
  - Filter items by Store Functionality.
  - Display All Items as a List , and their Comments. 
    - With Ability to add/delete them.
  - Admin Functionality to delete the comments.
  - Server code to recieve latest prices -> Generate a graph using chart JS.
  - Responsible for the main layout of the home page, and how everything is organized.
- Admin Management , list all the users, and give ability to ban them.
- 80% of the written unit tests of all the functions created , using TDD.
  - Wrote out all the functions in ```src/server/functions/*``` for basic requirements.

- Image Store Functionality in the database as a BLOB , and Image Retrieval funcationality and displaying.
- File parsing , to upload / add multiple items at once from Admin Management console to database.
- Global Function , to execute all SQL queries from one point / function in ```src/server/function/db_connection.php```
- Coordinated Deployment of the application for First Milestone, created deploy scripts and documentation.
- Documentation for the whole project repo.
- Functions to retrieve latest Weather Information , using <u>external Web Api</u> as per lecture provided instructions.
- Comments - Add , Delete Functonality. 
- User Login Tracking , For Each Month. Implemented in Admin Management . 

#### Quin Finocchio

- Website Design
- Figma Mockup
- Login Page Functionality 
- Account Creation Page Functionality
- Account Page Functionality
    - Edit user information

- Front End Framework for the entire site
- Contributed to the ```src/server/functions/*```
    - wrote more detailed functions as requirements became more apperent
    - added functions as needed
    - fixed functions as needed
- Header HTML and CSS , implemented breadcrubs into the header
- Background HTML and CSS
- Logout Functionality
- Hosted Site
- Contributed to the search bar functionality
    - Wrote the js script that loads the items initially and enabled all stores to be searched
    - Contributed to the ability to be able to search items accurately
- Backend of product page.
- Programmed the User list page
- Admin Panel Front end
- Home page frontend.
- Contributed to a lot of product.php frontend
- Most of the general styling of the website
- The HTML and CSS framework that is used on every page
- Implemented the charts in product.php
- wrote product.js
- contributed to home.js
- added a ton of test data

- A lot of detail work, getting things to work how they actually should
    * This one is quite important to me as it takes a lot of time and attention *

#### Max Bigwood
- Changed appearance of admin_login.php to match rest of pages
- added footer NAV and text to all pages 
- product.php front end - displays data for items name and price
- also displays a placeholder image for the product and a chart
- comments for the item should populate with proper css
- fixed JS on product.js to hide buttons properly 
- redid css on product.js, also altered getQUeryParam to be case insensitive
- altered some ddl to stop causing an error
- altered getUserID function as it had an error 
- fixed the addcomment functionality  
- added a new function to order comments by most recent (for product page) 
