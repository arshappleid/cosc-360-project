    CREATE DATABASE market_database;
    USE market_database;

    CREATE TABLE Users (
        User_ID INT AUTO_INCREMENT PRIMARY KEY,
        First_Name VARCHAR(50) NOT NULL,
        Last_Name VARCHAR(50) NOT NULL,
        Email VARCHAR(100) NOT NULL UNIQUE,
        MD5_Password CHAR(32) NOT NULL,
        User_Image BLOB
    );

    CREATE TABLE Admins (
        Admin_ID INT AUTO_INCREMENT PRIMARY KEY,
        First_Name VARCHAR(50) NOT NULL,
        Last_Name VARCHAR(50) NOT NULL,
        Email VARCHAR(100) NOT NULL UNIQUE,
        MD5_Password CHAR(32) NOT NULL,
    );

   




