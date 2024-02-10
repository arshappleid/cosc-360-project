CREATE DATABASE market_database;

USE market_database;

CREATE TABLE USERS (
    USER_ID INT AUTO_INCREMENT PRIMARY KEY, First_Name VARCHAR(50) NOT NULL, Last_Name VARCHAR(50) NOT NULL, Email VARCHAR(100) NOT NULL UNIQUE, MD5_Password CHAR(32) NOT NULL, User_Image BLOB
);

CREATE TABLE Admins (
    Admin_ID INT AUTO_INCREMENT PRIMARY KEY, First_Name VARCHAR(50) NOT NULL, Last_Name VARCHAR(50) NOT NULL, Email VARCHAR(100) NOT NULL UNIQUE, MD5_Password CHAR(32) NOT NULL
);

CREATE TABLE ITEMS (
    ITEM_ID INT AUTO_INCREMENT PRIMARY KEY, ITEM_NAME VARCHAR(100) NOT NULL, ITEM_DESCRIPTION TEXT NOT NULL, EXTERNAL_LINK VARCHAR(255), ITEM_IMAGE BLOB
);

CREATE TABLE STORE (
    STORE_ID INT AUTO_INCREMENT PRIMARY KEY, STORE_NAME VARCHAR(50) NOT NULL
);

CREATE TABLE Item_Price_Entry (
    Item_Entry INT AUTO_INCREMENT PRIMARY KEY, STORE_ID INT NOT NULL, ITEM_ID INT NOT NULL, Item_Price FLOAT(4, 2) NOT NULL, Time_Updated DATETIME NOT NULL, FOREIGN KEY (STORE_ID) REFERENCES STORE (STORE_ID), FOREIGN KEY (ITEM_ID) REFERENCES ITEMS (ITEM_ID)
);

CREATE TABLE Comments (
    COMMENT_ID INT AUTO_INCREMENT PRIMARY KEY, COMMENT_TEXT TEXT NOT NULL, ITEM_ID INT NOT NULL, USER_ID INT NOT NULL, DATE_TIME_ADDED DATETIME NOT NULL, FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID), FOREIGN KEY (ITEM_ID) REFERENCES ITEMS (ITEM_ID)
);

-- Insert into users
INSERT INTO
    USERS (
        EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD
    )
VALUES (
        'test@gmail.com', 'Test', 'User', '5f4dcc3b5aa765d61d8327deb882cf99'
    );

INSERT INTO
    Admins (
        EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD
    )
VALUES (
        'test@gmail.com', 'Test', 'User', '5f4dcc3b5aa765d61d8327deb882cf99'
    );
-- Insert data into STORE
INSERT INTO STORE (STORE_NAME) VALUES ('Electronics World');

INSERT INTO STORE (STORE_NAME) VALUES ('Gadget Galaxy');

INSERT INTO STORE (STORE_NAME) VALUES ('Tech Hub');

-- Insert data into ITEMS
INSERT INTO
    ITEMS (
        ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, ITEM_IMAGE
    )
VALUES (
        'Smartphone', 'Latest model smartphone with advanced features', 'http://example.com/smartphone', NULL
    );

INSERT INTO
    ITEMS (
        ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, ITEM_IMAGE
    )
VALUES (
        'Laptop', 'High-performance laptop suitable for gaming and professional work', 'http://example.com/laptop', NULL
    );

INSERT INTO
    ITEMS (
        ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, ITEM_IMAGE
    )
VALUES (
        'Smartwatch', 'Water-resistant smartwatch with health tracking', 'http://example.com/smartwatch', NULL
    );

-- Insert data into Comments
INSERT INTO
    Comments (
        COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED
    )
VALUES (
        'Great product!', 1, 1, '2024-01-01 10:00:00'
    );

INSERT INTO
    Comments (
        COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED
    )
VALUES (
        'Had some issues with the battery.', 1, 2, '2024-01-02 11:00:00'
    );

INSERT INTO
    Comments (
        COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED
    )
VALUES (
        'Excellent performance.', 2, 3, '2024-01-03 09:30:00'
    );

-- Insert data into Item_Price_Entry
INSERT INTO
    Item_Price_Entry (
        STORE_ID, ITEM_ID, Item_Price, Time_Updated
    )
VALUES (
        1, 1, 999.99, '2024-01-01 00:00:00'
    );

INSERT INTO
    Item_Price_Entry (
        STORE_ID, ITEM_ID, Item_Price, Time_Updated
    )
VALUES (
        2, 1, 1020.50, '2024-01-02 00:00:00'
    );

INSERT INTO
    Item_Price_Entry (
        STORE_ID, ITEM_ID, Item_Price, Time_Updated
    )
VALUES (
        1, 2, 1500.00, '2024-01-03 00:00:00'
    );