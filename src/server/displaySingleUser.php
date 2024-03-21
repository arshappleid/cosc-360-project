<?php
include './functions/user_management.php';

// Check if the EMAIL session variable is set
if (!isset($_SESSION['USER_EMAIL'])) {
    die("User email is not set in the session.");
}

$users = User_management::getAllUserData($_SESSION['USER_EMAIL']);

// Check if $users is an array to confirm it contains user data
if (is_array($users)) {
    // Since $users should have the data for a single user, no loop is needed
    echo "<table id=\"user_table\">";
    echo "<tr><th>First Name</th><td>" . htmlspecialchars($users['First_Name']) . "<button>Update</button></td></tr>";
    echo "<tr><th>Last Name</th><td>" . htmlspecialchars($users['Last_Name']) . "<button>Update</button></td></tr>";
    echo "<tr><th>Email</th><td>" . htmlspecialchars($users['Email']) . "<button>Update</button></td></tr>";
    echo '<tr><th>Profile Picture</th><td><button>Update</button><input type="file" id="profilePicture" 
            name="profilePicture" placeholder="Upload Profile Picture" accept="image/*"></td></tr>';
    echo "<tr><th>Update Password</th><td><button>Update Password</button></td></tr>";
    echo "</table>";
} else {
    // If $users is not an array, it means an error occurred or no user data was found
    echo "<h4>Error Retrieving User Data: " . htmlspecialchars($users) . "</h4>";
}
?>
