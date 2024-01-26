CREATE DATABASE market_database;

USE market_database;

CREATE TABLE USERS (
    USER_ID INT AUTO_INCREMENT PRIMARY KEY, First_Name VARCHAR(50) NOT NULL, Last_Name VARCHAR(50) NOT NULL, Email VARCHAR(100) NOT NULL UNIQUE, MD5_Password CHAR(32) NOT NULL, User_Image BLOB
);

CREATE TABLE Admins (
    Admin_ID INT AUTO_INCREMENT PRIMARY KEY, First_Name VARCHAR(50) NOT NULL, Last_Name VARCHAR(50) NOT NULL, Email VARCHAR(100) NOT NULL UNIQUE, MD5_Password CHAR(32) NOT NULL,
);

CREATE TABLE Comments{ 
    COMMENT_ID INT AUTO_INCREMENT PRIMARY KEY, 
    COMMENT_TEXT TEXT NOT NULL, 
    ITEM_ID INT NOT NULL,
    USER_ID INT NOT NULL , 
    DATE_TIME_ADDED DATETIME NOT NULL


    Foreign Key (USER_ID) REFERENCES USERS(USERS_ID),
    FOREIGN KEY (ITEM_ID) REFERENCES ITEMS(ITEM_ID)
} 


CREATE TABLE ITEMS (
    ITEM_ID INT AUTO_INCREMENT PRIMARY KEY, ITEM_NAME VARCHAR(100) NOT NULL, ITEM_DESCRIPTION TEXT NOT NULL, EXTERNAL_LINK VARCHAR(255), ITEM_IMAGE BLOB
);

CREATE TABLE Item_Price_Entry (
    Item_Entry INT AUTO_INCREMENT PRIMARY KEY, ITEM_ID INT NOT NULL, Item_Price FLOAT(4, 2) NOT NULL, Time_Updated DATETIME NOT NULL, FOREIGN KEY (ITEM_ID) REFERENCES ITEMS (ITEM_ID)
);

-- Test Data
INSERT INTO
    ITEMS (
        Item_Name, Item_Description, External_Link, Item_Image
    )
VALUES (
        'Blue Widget', 'A blue widget used for construction.', 'http://example.com/bluewidget', NULL
    ),
    (
        'Red Gadget', 'A red gadget for household use.', 'http://example.com/redgadget', NULL
    ),
    (
        'Green Machine', 'A green machine for gardening.', 'http://example.com/greenmachine', NULL
    ),
    (
        'Yellow Tool', 'A yellow tool for repair works.', 'http://example.com/yellowtool', NULL
    ),
    (
        'Purple Device', 'A purple device for computing.', 'http://example.com/purpledevice', NULL
    );

INSERT INTO
    Item_Price_Entry (
        Item_ID, Item_Price, Time_Updated
    )
VALUES (1, 10.99, NOW()),
    (1, 11.49, NOW()),
    (2, 8.99, NOW()),
    (2, 9.49, NOW()),
    (3, 15.99, NOW()),
    (3, 16.49, NOW()),
    (4, 5.99, NOW()),
    (4, 6.49, NOW()),
    (5, 20.99, NOW()),
    (5, 21.49, NOW());