CREATE DATABASE market_database;

USE market_database;

CREATE TABLE
    USERS (
        USER_ID INT AUTO_INCREMENT PRIMARY KEY,
        First_Name VARCHAR(50) NOT NULL,
        Last_Name VARCHAR(50) NOT NULL,
        Email VARCHAR(100) NOT NULL UNIQUE,
        MD5_Password CHAR(32) NOT NULL,
        DISPLAY_IMAGE BLOB,
        BANNED_STATUS BOOLEAN DEFAULT FALSE
    );

CREATE TABLE
    Admins (
        Admin_ID INT AUTO_INCREMENT PRIMARY KEY,
        First_Name VARCHAR(50) NOT NULL,
        Last_Name VARCHAR(50) NOT NULL,
        Email VARCHAR(100) NOT NULL UNIQUE,
        MD5_Password CHAR(32) NOT NULL,
        DISPLAY_IMAGE BLOB
    );

CREATE TABLE
    ITEMS (
        ITEM_ID INT AUTO_INCREMENT PRIMARY KEY,
        ITEM_NAME VARCHAR(100) NOT NULL,
        ITEM_DESCRIPTION TEXT NOT NULL,
        UPVOTES INT DEFAULT 0,
        EXTERNAL_LINK VARCHAR(255),
        DISPLAY_IMAGE BLOB
    );

CREATE TABLE
    STORE (
        STORE_ID INT AUTO_INCREMENT PRIMARY KEY,
        STORE_NAME VARCHAR(50) NOT NULL,
        DISPLAY_IMAGE BLOB
    );

CREATE TABLE
    Item_Price_Entry (
        Item_Entry INT AUTO_INCREMENT PRIMARY KEY,
        STORE_ID INT NOT NULL,
        ITEM_ID INT NOT NULL,
        Item_Price FLOAT (6, 2) NOT NULL,
        Time_Updated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (STORE_ID) REFERENCES STORE (STORE_ID) ON DELETE CASCADE,
        FOREIGN KEY (ITEM_ID) REFERENCES ITEMS (ITEM_ID) ON DELETE CASCADE
    );

CREATE TABLE
    Comments (
        COMMENT_ID INT AUTO_INCREMENT PRIMARY KEY,
        COMMENT_TEXT TEXT NOT NULL,
        ITEM_ID INT NOT NULL,
        USER_ID INT NOT NULL,
        DATE_TIME_ADDED DATETIME NOT NULL,
        FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID) ON DELETE CASCADE,
        FOREIGN KEY (ITEM_ID) REFERENCES ITEMS (ITEM_ID) ON DELETE CASCADE
    );

CREATE TABLE
    CATEGORY_INFO (CATEGORY_NAME VARCHAR(15) PRIMARY KEY, CATEGORY_DESCRIPTION VARCHAR(255));

CREATE TABLE
    ITEM_CATEGORY (
        ITEM_ID INT,
        CATEGORY_NAME VARCHAR(15) NOT NULL,
        FOREIGN KEY (ITEM_ID) REFERENCES ITEMS (ITEM_ID),
        FOREIGN KEY (CATEGORY_NAME) REFERENCES CATEGORY_INFO (CATEGORY_NAME)
    );

CREATE TABLE
    WEATHER (
        CITY_NAME VARCHAR(255) PRIMARY KEY,
        LATITUDE FLOAT (10, 6) NOT NULL,
        LONGITUDE FLOAT (10, 6) NOT NULL,
        CURRENT_WEATHER_CELCIUS FLOAT (5, 2),
        WINDSPEED_KMH FLOAT (5, 2),
        WIND_DIRECTION FLOAT (5, 2),
        TIME_UPDATED DATETIME
    );

CREATE TABLE
    LOGIN_COUNT (
        USER_ID INT PRIMARY KEY,
        LOGIN_COUNT INT,
        MONTH TINYINT,
        YEAR INT,
        FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID) ON DELETE CASCADE
    );

-- Insert into Weather
INSERT INTO
    WEATHER (CITY_NAME, LATITUDE, LONGITUDE)
VALUES
    ('Toronto', 43.651070, -79.347015),
    ('Montreal', 45.508888, -73.561668),
    ('Vancouver', 49.282730, -123.120735),
    ('Calgary', 51.044733, -114.071883),
    ('Edmonton', 53.546124, -113.493823),
    ('Ottawa', 45.421530, -75.697193),
    ('Winnipeg', 49.895077, -97.138451),
    ('Quebec City', 46.813878, -71.207981),
    ('Hamilton', 43.255721, -79.871102),
    ('Kelowna', 49.887952, -119.496011);

-- Insert into users
INSERT INTO
    USERS (EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD)
VALUES
    ('test@gmail.com', 'Test', 'User', '5f4dcc3b5aa765d61d8327deb882cf99');

INSERT INTO
    USERS (EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD)
VALUES
    ('test2@gmail.com', 'Test', 'User', '5f4dcc3b5aa765d61d8327deb882cf99');

INSERT INTO
    USERS (EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD)
VALUES
    ('test3@gmail.com', 'Test', 'User', '5f4dcc3b5aa765d61d8327deb882cf99');

INSERT INTO
    USERS (EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD)
VALUES
    ('test4@gmail.com', 'Test', 'User', '5f4dcc3b5aa765d61d8327deb882cf99');

INSERT INTO
    USERS (EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD)
VALUES
    ('user@gmail.com', 'Test', 'User', '5f4dcc3b5aa765d61d8327deb882cf99');

INSERT INTO
    Admins (EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD)
VALUES
    ('test@gmail.com', 'Test', 'User', '5f4dcc3b5aa765d61d8327deb882cf99');

INSERT INTO
    Admins (EMAIL, FIRST_NAME, LAST_NAME, MD5_PASSWORD)
VALUES
    ('admin@gmail.com', 'Test', 'User', '5f4dcc3b5aa765d61d8327deb882cf99');

-- Insert data into STORE
INSERT INTO
    STORE (STORE_NAME)
VALUES
    ('Electronics World');

INSERT INTO
    STORE (STORE_NAME)
VALUES
    ('Gadget Galaxy');

INSERT INTO
    STORE (STORE_NAME)
VALUES
    ('Tech Hub');

-- Insert data into ITEMS
INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    (
        'Smartphone',
        'Latest model smartphone with advanced features',
        'http://example.com/smartphone',
        NULL
    );

INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    (
        'Laptop',
        'High-performance laptop suitable for gaming and professional work',
        'http://example.com/laptop',
        NULL
    );

INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    (
        'Smartwatch',
        'Water-resistant smartwatch with health tracking',
        'http://example.com/smartwatch',
        NULL
    );

INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    ('iPhone', 'This time its a pro', 'http://example.com/smartphone', NULL);

INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    (
        'Bluetooth Headphones',
        'Noise-cancelling Bluetooth headphones with long battery life',
        'http://example.com/bluetoothheadphones',
        NULL
    );

INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    (
        'Portable Speaker',
        'Compact and portable speaker with exceptional sound quality',
        'http://example.com/portablespeaker',
        NULL
    );

INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    (
        'E-Reader',
        'Lightweight e-reader with a paper-like display for avid readers',
        'http://example.com/ereader',
        NULL
    );

INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    (
        'Gaming Console',
        'Next-generation gaming console with 4K resolution support',
        'http://example.com/gamingconsole',
        NULL
    );

INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    (
        'Action Camera',
        'Compact, durable action camera for capturing your adventures',
        'http://example.com/actioncamera',
        NULL
    );

INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    (
        'Wireless Charging Pad',
        'Sleek wireless charging pad compatible with all Qi-enabled devices',
        'http://example.com/wirelesschargingpad',
        NULL
    );

INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    (
        'Tablet',
        'Powerful tablet ideal for both work and play',
        'http://example.com/tablet',
        NULL
    );

INSERT INTO
    ITEMS (ITEM_NAME, ITEM_DESCRIPTION, EXTERNAL_LINK, DISPLAY_IMAGE)
VALUES
    (
        'Fitness Tracker',
        'Stay active with this slim and stylish fitness tracker',
        'http://example.com/fitnesstracker',
        NULL
    );

INSERT INTO
    CATEGORY_INFO (CATEGORY_NAME, CATEGORY_DESCRIPTION)
VALUES
    ("Electronics", "Tech to make your life better");

INSERT INTO
    ITEM_CATEGORY (CATEGORY_NAME, ITEM_ID)
VALUES
    ('Electronics', '1');

INSERT INTO
    ITEM_CATEGORY (CATEGORY_NAME, ITEM_ID)
VALUES
    ('Electronics', '2');

INSERT INTO
    ITEM_CATEGORY (CATEGORY_NAME, ITEM_ID)
VALUES
    ('Electronics', '3');

-- Insert data into Comments
INSERT INTO
    Comments (COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED)
VALUES
    ('Great product!', 1, 1, CURRENT_TIMESTAMP);

INSERT INTO
    Comments (COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED)
VALUES
    ('Had some issues with the battery.', 1, 1, CURRENT_TIMESTAMP);

INSERT INTO
    Comments (COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED)
VALUES
    ('Excellent performance.', 2, 1, CURRENT_TIMESTAMP);

INSERT INTO
    Comments (COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED)
VALUES
    ('Great performance.', 2, 2, CURRENT_TIMESTAMP);

INSERT INTO
    Comments (COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED)
VALUES
    ('Great performance.', 2, 2, CURRENT_TIMESTAMP);

INSERT INTO
    Comments (COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED)
VALUES
    ('Mediocre', 3, 1, CURRENT_TIMESTAMP);

-- Insert data into Item_Price_Entry
INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 1, 999.99, CURRENT_TIMESTAMP);

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 1, 999.99, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 1, 1004.99, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 1, 994.99, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 1, 1009.99, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 1, 989.99, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 1, 1014.99, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 1, 984.99, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 1, 1019.99, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 979.99, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 999.99, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 1004.99, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 994.99, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 1009.99, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 989.99, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 1014.99, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 984.99, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 1019.99, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 979.99, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 999.99, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 1004.99, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 994.99, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 1009.99, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 989.99, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 1014.99, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 984.99, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 1019.99, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 979.99, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 90.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 112.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 96.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 86.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 104.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 110.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 106.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 110.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 87.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 2, 96.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 2, 90.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 2, 112.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 2, 96.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 2, 86.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 2, 104.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 2, 110.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 2, 106.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 2, 110.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 2, 87.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 2, 96.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 2, 90.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 2, 112.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 2, 96.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 2, 86.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 2, 104.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 2, 110.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 2, 106.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 2, 110.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 2, 87.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 2, 96.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 408.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 391.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 434.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 452.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 367.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 344.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 341.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 451.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 387.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 3, 370.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 3, 439.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 3, 425.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 3, 407.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 3, 375.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 3, 381.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 3, 342.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 3, 387.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 3, 436.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 3, 422.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 3, 361.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 3, 435.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 3, 355.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 3, 440.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 3, 440.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 3, 441.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 3, 388.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 3, 365.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 3, 410.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 3, 442.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 3, 429.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 4, 194.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 4, 180.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 4, 228.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 4, 221.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 4, 210.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 4, 206.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 4, 222.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 4, 224.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 4, 187.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 4, 204.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 4, 218.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 4, 210.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 4, 181.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 4, 226.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 4, 214.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 4, 181.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 4, 200.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 4, 211.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 4, 193.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 4, 193.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 4, 203.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 4, 209.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 4, 188.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 4, 186.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 4, 209.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 4, 197.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 4, 197.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 4, 196.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 4, 189.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 4, 223.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 5, 1916.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 5, 1894.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 5, 1731.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 5, 1798.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 5, 2378.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 5, 2193.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 5, 1756.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 5, 2294.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 5, 1852.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 5, 1728.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 5, 1951.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 5, 1764.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 5, 1836.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 5, 2004.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 5, 1996.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 5, 1734.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 5, 2146.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 5, 1907.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 5, 2094.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 5, 2330.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 5, 2317.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 5, 1690.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 5, 1786.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 5, 2233.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 5, 2310.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 5, 1866.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 5, 1750.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 5, 2197.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 5, 2019.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 5, 1812.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 6, 728.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 6, 881.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 6, 775.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 6, 889.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 6, 849.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 6, 788.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 6, 885.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 6, 785.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 6, 849.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 6, 779.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 6, 702.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 6, 872.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 6, 830.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 6, 808.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 6, 864.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 6, 899.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 6, 817.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 6, 772.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 6, 859.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 6, 767.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 6, 758.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 6, 717.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 6, 835.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 6, 814.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 6, 771.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 6, 741.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 6, 796.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 6, 732.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 6, 759.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 6, 793.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 7, 1098.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 7, 958.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 7, 697.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 7, 966.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 7, 820.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 7, 736.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 7, 869.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 7, 892.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 7, 1101.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 7, 712.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 7, 853.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 7, 727.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 7, 1028.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 7, 737.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 7, 1148.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 7, 1031.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 7, 1125.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 7, 771.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 7, 908.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 7, 1041.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 7, 993.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 7, 753.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 7, 789.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 7, 919.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 7, 834.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 7, 1128.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 7, 962.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 7, 859.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 7, 713.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 7, 679.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 8, 60.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 8, 68.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 8, 81.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 8, 67.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 8, 79.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 8, 108.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 8, 143.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 8, 137.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 8, 104.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 8, 56.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 8, 120.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 8, 128.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 8, 134.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 8, 55.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 8, 96.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 8, 69.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 8, 128.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 8, 107.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 8, 124.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 8, 102.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 8, 96.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 8, 108.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 8, 140.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 8, 142.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 8, 135.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 8, 128.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 8, 137.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 8, 61.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 8, 130.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 8, 59.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 9, 816.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 9, 1173.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 9, 875.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 9, 1061.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 9, 891.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 9, 1099.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 9, 895.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 9, 846.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 9, 858.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 9, 826.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 9, 1184.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 9, 947.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 9, 970.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 9, 1050.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 9, 826.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 9, 1060.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 9, 961.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 9, 1063.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 9, 1060.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 9, 1011.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 9, 952.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 9, 922.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 9, 1179.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 9, 873.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 9, 825.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 9, 819.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 9, 958.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 9, 842.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 9, 947.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 9, 1024.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 10, 4741.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 10, 5307.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 10, 5201.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 10, 4725.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 10, 5314.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 10, 4691.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 10, 4908.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 10, 4870.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 10, 5147.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (1, 10, 4688.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 10, 4761.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 10, 5299.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 10, 5181.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 10, 5038.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 10, 4748.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 10, 4733.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 10, 4696.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 10, 4693.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 10, 5033.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (2, 10, 4892.00, '2024-03-27 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 10, 4822.00, '2024-04-05 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 10, 4940.00, '2024-04-04 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 10, 4970.00, '2024-04-03 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 10, 5002.00, '2024-04-02 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 10, 5123.00, '2024-04-01 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 10, 4940.00, '2024-03-31 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 10, 4987.00, '2024-03-30 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 10, 5113.00, '2024-03-29 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 10, 4833.00, '2024-03-28 17:15:19');

INSERT INTO
    Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated)
VALUES
    (3, 10, 5019.00, '2024-03-27 17:15:19');

INSERT INTO
    STORE (STORE_NAME)
VALUES
    ("Walmart");

INSERT INTO
    Comments (COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED)
VALUES
    ("What a great product", 3, 3, CURRENT_TIMESTAMP);

INSERT INTO
    Comments (COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED)
VALUES
    ("Only 1 comment for this item", 4, 3, CURRENT_TIMESTAMP);

INSERT INTO
    Comments (COMMENT_TEXT, ITEM_ID, USER_ID, DATE_TIME_ADDED)
VALUES
    ("Only 1 comment for this user", 5, 4, CURRENT_TIMESTAMP);