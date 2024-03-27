CREATE DATABASE market_database;

USE market_database;

CREATE TABLE USERS (
    USER_ID INT AUTO_INCREMENT PRIMARY KEY, First_Name VARCHAR(50) NOT NULL, Last_Name VARCHAR(50) NOT NULL, Email VARCHAR(100) NOT NULL UNIQUE, MD5_Password CHAR(32) NOT NULL, DISPLAY_IMAGE BLOB, BANNED_STATUS BOOLEAN DEFAULT FALSE
);

CREATE TABLE Admins (
    Admin_ID INT AUTO_INCREMENT PRIMARY KEY, First_Name VARCHAR(50) NOT NULL, Last_Name VARCHAR(50) NOT NULL, Email VARCHAR(100) NOT NULL UNIQUE, MD5_Password CHAR(32) NOT NULL, DISPLAY_IMAGE BLOB
);

CREATE TABLE ITEMS (
    ITEM_ID INT AUTO_INCREMENT PRIMARY KEY, ITEM_NAME VARCHAR(100) NOT NULL, ITEM_DESCRIPTION TEXT NOT NULL, EXTERNAL_LINK VARCHAR(255), DISPLAY_IMAGE BLOB
);

CREATE TABLE STORE (
    STORE_ID INT AUTO_INCREMENT PRIMARY KEY, STORE_NAME VARCHAR(50) NOT NULL, DISPLAY_IMAGE BLOB
);

CREATE TABLE Item_Price_Entry (
    Item_Entry INT AUTO_INCREMENT PRIMARY KEY, STORE_ID INT NOT NULL, ITEM_ID INT NOT NULL, Item_Price FLOAT(6, 2) NOT NULL, Time_Updated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (STORE_ID) REFERENCES STORE (STORE_ID), FOREIGN KEY (ITEM_ID) REFERENCES ITEMS (ITEM_ID)
);

CREATE TABLE Comments (
    COMMENT_ID INT AUTO_INCREMENT PRIMARY KEY, COMMENT_TEXT TEXT NOT NULL, ITEM_ID INT NOT NULL, USER_ID INT NOT NULL, DATE_TIME_ADDED DATETIME NOT NULL, FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID), FOREIGN KEY (ITEM_ID) REFERENCES ITEMS (ITEM_ID)
);

CREATE TABLE ITEM_CATEGORY (
    ITEM_ID INT REFERENCES ITEMS (ITEM_ID), CATEGORY_NAME VARCHAR(15) NOT NULL
);

CREATE TABLE CATEGORY_INFO (
    CATEGORY_NAME VARCHAR(15) REFERENCES ITEM_CATEGORY (CATEGORY_NAME), CATEGORY_DESCRIPTION VARCHAR(255)
);

CREATE TABLE WEATHER (
    CITY_NAME VARCHAR(255) PRIMARY KEY, LATITUDE FLOAT(10, 6) NOT NULL, LONGITUDE FLOAT(10, 6) NOT NULL, CURRENT_WEATHER_CELCIUS FLOAT(5, 2), WINDSPEED_KMH FLOAT(5, 2), WIND_DIRECTION FLOAT(5, 2), TIME_UPDATED DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insert into Weather
INSERT INTO
    WEATHER (
        CITY_NAME, LATITUDE, LONGITUDE
    )
VALUES (
        'Toronto', 43.651070, -79.347015
    ),
    (
        'Montreal', 45.508888, -73.561668
    ),
    (
        'Vancouver', 49.282730, -123.120735
    ),
    (
        'Calgary', 51.044733, -114.071883
    ),
    (
        'Edmonton', 53.546124, -113.493823
    ),
    (
        'Ottawa', 45.421530, -75.697193
    ),
    (
        'Winnipeg', 49.895077, -97.138451
    ),
    (
        'Quebec City', 46.813878, -71.207981
    ),
    (
        'Hamilton', 43.255721, -79.871102
    ),
    (
        'Kelowna', 49.887952, -119.496011
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
    USERS (
        EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD
    )
VALUES (
        'test2@gmail.com', 'Test', 'User', '5f4dcc3b5aa765d61d8327deb882cf99'
    );

INSERT INTO
    USERS (
        EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD
    )
VALUES (
        'test3@gmail.com', 'Test', 'User', '5f4dcc3b5aa765d61d8327deb882cf99'
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
        ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE
    )
VALUES (
        'Smartphone', 'Latest model smartphone with advanced features', 'http://example.com/smartphone', NULL
    );

INSERT INTO
    ITEMS (
        ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE
    )
VALUES (
        'Laptop', 'High-performance laptop suitable for gaming and professional work', 'http://example.com/laptop', NULL
    );

INSERT INTO
    ITEMS (
        ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE
    )
VALUES (
        'Smartwatch', 'Water-resistant smartwatch with health tracking', 'http://example.com/smartwatch', NULL
    );

INSERT INTO
    ITEM_CATEGORY (CATEGORY_NAME, ITEM_ID)
VALUES ('Electronics', '1');

INSERT INTO
    ITEM_CATEGORY (CATEGORY_NAME, ITEM_ID)
VALUES ('Electronics', '2');

INSERT INTO
    ITEM_CATEGORY (CATEGORY_NAME, ITEM_ID)
VALUES ('Electronics', '3');

INSERT INTO
    CATEGORY_INFO (
        CATEGORY_NAME, CATEGORY_DESCRIPTION
    )
VALUES (
        "Electronics", "Tech to make your life better"
    );
-- Insert data into Comments
INSERT INTO
    Comments (
        COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED
    )
VALUES ('Great product!', 1, 1, NOW());

INSERT INTO
    Comments (
        COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED
    )
VALUES (
        'Had some issues with the battery.', 1, 1, NOW()
    );

INSERT INTO
    Comments (
        COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED
    )
VALUES (
        'Excellent performance.', 2, 1, NOW()
    );

INSERT INTO
    Comments (
        COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED
    )
VALUES (
        'Great performance.', 2, 2, NOW()
    );

-- Insert data into Item_Price_Entry
INSERT INTO
    Item_Price_Entry (
        STORE_ID, ITEM_ID, Item_Price, Time_Updated
    )
VALUES (1, 1, 999.99, NOW());

INSERT INTO
    Item_Price_Entry (
        STORE_ID, ITEM_ID, Item_Price, Time_Updated
    )
VALUES (2, 1, 102.50, NOW());

INSERT INTO
    Item_Price_Entry (
        STORE_ID, ITEM_ID, Item_Price, Time_Updated
    )
VALUES (1, 2, 150.00, NOW());

INSERT INTO
    Item_Price_Entry (
        STORE_ID, ITEM_ID, Item_Price, Time_Updated
    )
VALUES (4, 3, 3, 75.69, NOW());
