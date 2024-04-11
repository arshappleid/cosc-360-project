document.getElementById("myForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the form from submitting

    // Get the password from the input
    var password = document.getElementById("password").value;

    // Hash the password using MD5
    var hashedPassword = CryptoJS.MD5(password).toString();

    // You can either send the hashed password as a hidden input or replace the password field value
    // For this example, let's replace the password field value
    document.getElementById("password").value = hashedPassword;

    // Now submit the form programmatically
    this.submit();
});
