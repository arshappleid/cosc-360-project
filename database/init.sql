    CREATE DATABASE your_database;
    USE your_database;

    CREATE TABLE Users (
        User_ID INT AUTO_INCREMENT PRIMARY KEY,
        First_Name VARCHAR(50) NOT NULL,
        Last_Name VARCHAR(50) NOT NULL,
        Email VARCHAR(100) NOT NULL UNIQUE,
        MD5_Password CHAR(32) NOT NULL,
        User_Image BLOB
    );

    CREATE TABLE Threads (
        Thread_ID INT AUTO_INCREMENT PRIMARY KEY,
        Thread_Str VARCHAR(255),
        Tag VARCHAR(50),
        Date_Created DATETIME,
        upvotes INT DEFAULT 0,
        User_ID INT,
        FOREIGN KEY (User_ID) REFERENCES Users(User_ID)
    );
    CREATE TABLE Admins (
        Admin_ID INT AUTO_INCREMENT PRIMARY KEY,
        First_Name VARCHAR(50) NOT NULL,
        Last_Name VARCHAR(50) NOT NULL,
        Email VARCHAR(100) NOT NULL UNIQUE,
        MD5_Password CHAR(32) NOT NULL
    );

    CREATE TABLE Comments (
        Comment_ID INT AUTO_INCREMENT PRIMARY KEY,
        Date_Time_Created TIMESTAMP,
        Comment_Str TEXT,
        User_ID INT,
        Admin_ID INT,
        Thread_ID INT,
        FOREIGN KEY (User_ID) REFERENCES Users(User_ID),
        FOREIGN KEY (Admin_ID) REFERENCES Admins(Admin_ID),
        FOREIGN KEY (Thread_ID) REFERENCES Threads(Thread_ID)
    );


    
    --- Test DATA
    -- Threads
    INSERT INTO Threads (Thread_Str, Tag, Date_Created, User_ID) VALUES 
    ('This is a test thread 2', 'Test', CURDATE(), (SELECT User_ID FROM Users WHERE Email = 'alice_smith@example.com')),
    ('This is a test thread 3', 'Test', CURDATE(), (SELECT User_ID FROM Users WHERE Email = 'bob_johnson@example.com')),
    ('This is a test thread 4', 'Test', CURDATE(), (SELECT User_ID FROM Users WHERE Email = 'charlie_williams@example.com')),
    ('This is a test thread 5', 'Test', CURDATE(), (SELECT User_ID FROM Users WHERE Email = 'david_brown@example.com')),
    ('This is a test thread 6', 'Test', CURDATE(), (SELECT User_ID FROM Users WHERE Email = 'eve_jones@example.com')),
    ('This is a test thread 7', 'Test', CURDATE(), (SELECT User_ID FROM Users WHERE Email = 'frank_miller@example.com'));

    -- Comments
    INSERT INTO Comments (Comment_Str, User_ID, Thread_ID) VALUES 
    ('This is a test comment 2', (SELECT User_ID FROM Users WHERE Email = 'alice_smith@example.com'), 
        (SELECT Thread_ID FROM Threads WHERE Thread_Str = 'This is a test thread 2')),
    ('This is a test comment 3', (SELECT User_ID FROM Users WHERE Email = 'bob_johnson@example.com'), 
        (SELECT Thread_ID FROM Threads WHERE Thread_Str = 'This is a test thread 3')),
    ('This is a test comment 4', (SELECT User_ID FROM Users WHERE Email = 'charlie_williams@example.com'), 
        (SELECT Thread_ID FROM Threads WHERE Thread_Str = 'This is a test thread 4')),
    ('This is a test comment 5', (SELECT User_ID FROM Users WHERE Email = 'david_brown@example.com'), 
        (SELECT Thread_ID FROM Threads WHERE Thread_Str = 'This is a test thread 5'));




