$(document).ready(function () {
    // Define the updateItemList function inside the document ready function
    function updateItemList() {
        $.get("./../server/getProductDetails.php", function (data) {
            $("#item_list").html(data);
        });
    }

    // Call updateItemList within the document ready function
    updateItemList();
}); // Ensure this closing bracket matches the opening bracket of $(document).ready
