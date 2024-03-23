$(document).ready(function () {
    // Function to extract query parameters from the URL
    function getQueryParam(param) {
        var searchParams = new URLSearchParams(window.location.search);
        return searchParams.get(param);
    }

    // Define the updateItemList function inside the document ready function
    function updateItemList() {
        var itemID = getQueryParam('ITEM_ID'); // Get the item ID from the URL
        if (itemID) {
            // Include the item ID as a query parameter in the request
            $.get("./../server/getProductDetails.php?ITEM_ID=" + encodeURIComponent(itemID), function (data) {
                $("#item_list").html(data);
            });
        } else {
            // Handle the case where no item ID is provided in the URL
            $("#item_list").html('<p>No product details available.</p>');
        }
    }

    // Call updateItemList within the document ready function
    updateItemList();
});