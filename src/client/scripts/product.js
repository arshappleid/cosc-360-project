$(document).ready(function () {
    // Function to extract query parameters from the URL
    function getQueryParam(param)
    {
        var searchParams = new URLSearchParams(window.location.search);
        for (const [key, value] of searchParams.entries()) {
            if (key.toUpperCase() === param.toUpperCase()) {
                return value;
            }
        }
        return null;
    }

    // Update the item list based on the item ID in the URL query parameter
    function updateItemList()
    {
        var itemID = getQueryParam('item_ID');
        console.log(itemID);
        if (itemID) {
            $.get("./../server/getProductDetails.php?ITEM_ID=" + encodeURIComponent(itemID), function (data) {
                $("#item_list").html(data);
            });
        } else {
            $("#item_list").html('<p>No product details available.</p>');
        }
    }

    // Call updateItemList to update the item list on page load
    updateItemList();
    // Toggle comment form display on button click
    $(document).on("click", "#comment-button", function () {
        $("#add-comment-form").toggle();
        $(this).text(function (i, text) {
            return text === "Show Comment Form" ? "Hide Comment Form" : "Show Comment Form";
        });
    });
});

