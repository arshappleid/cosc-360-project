<?php
include './functions/user_management.php';

if (!isset($_SESSION['USER_EMAIL'])) {
    die("User email is not set in the session.");
}

$users = User_management::getAllUserData($_SESSION['USER_EMAIL']);

if (is_array($users)) {
    echo "<table id=\"user_table\">";
    echo "<tr><th>First Name</th><td>" . htmlspecialchars($users['First_Name']) . "<button>Update</button></td></tr>";
    echo "<tr><th>Last Name</th><td>" . htmlspecialchars($users['Last_Name']) . "<button>Update</button></td></tr>";
    echo "<tr><th>Email</th><td>" . htmlspecialchars($users['Email']) . "<button>Update</button></td></tr>";
    echo '<tr><th>Profile Picture</th><td><button>Update</button><input type="file" id="profilePicture" 
            name="profilePicture" placeholder="Upload Profile Picture" accept="image/*"></td></tr>';
    echo "<tr><th>Update Password</th><td><button>Update Password</button></td></tr>";
    echo "</table>";
} else {
    echo "<h4>Error Retrieving User Data: " . htmlspecialchars($users) . "</h4>";
}
?>
