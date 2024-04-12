<?php

require_once('./../../server/functions/user_management.php');

if (!isset($_SESSION['USER_EMAIL'])) {
    //die("User email is not set in the session.");
}

$users = User_management::getAllUserData($_SESSION['USER_EMAIL']);

//print_r($users);

if (is_array($users)) {
?>
    <form id="updateFirstNameForm" method="POST" action="../../server/updateFirstName.php">
    <label for="firstName" class="visually-hidden">First Name:</label>
    <input type="text" id="firstName" name="firstName" placeholder="<?= htmlspecialchars($users['First_Name']) ?>" required>
    <button class="yellowbutton" type="submit">Update First Name</button>
</form>

<form id="updateLastNameForm" method="POST" action="../../server/updateLastName.php">
    <label for="lastName" class="visually-hidden">Last Name:</label>
    <input type="text" id="lastName" name="lastName" placeholder="<?= htmlspecialchars($users['Last_Name']) ?>" required>
    <button class="yellowbutton" type="submit">Update Last Name</button>
</form>

<form id="updatePasswordForm" method="POST" action="../../server/updateUserPassword.php">
    <label for="oldpassword" class="visually-hidden">Old Password:</label>
    <input type="password" id="oldpassword" name="oldpassword" placeholder="Old Password" required>
    
    <label for="password" class="visually-hidden">New Password:</label>
    <input type="password" id="password" name="password" placeholder="New Password" required>
    
    <label for="password2" class="visually-hidden">Re-enter New Password:</label>
    <input type="password" id="password2" name="password2" placeholder="Re-enter New Password" required>
    
    <button class="yellowbutton" type="submit">Update Password</button>
</form>

<form id="updatePfpForm" method="POST" action="./../../server/updateUserPicture.php" enctype="multipart/form-data">
    <?php
        echo "<div class=\"image-container\">";
        echo "<a class=\"pfp-text\">Profile Picture: </a>";
        echo "<img src=\"./../../server/getUserImages.php?USER_ID=" . $users['USER_ID'] . "\" class='user-image' alt='user image'>";
        echo "</div>";
    ?>
    <label for="profilePicture" class="visually-hidden">Upload Profile Picture:</label>
    <input type="file" id="profilePicture" name="image" accept="image/*">
    <button class="yellowbutton" type="submit">Update Profile Picture</button>
</form>
<?php
} else {
    echo "<h4>Error Retrieving User Data: " . htmlspecialchars($users) . "</h4>";
}
