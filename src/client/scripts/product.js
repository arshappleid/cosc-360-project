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

    function updateItemList() {
        var itemID = getQueryParam('ITEM_ID'); 
        var storeID = getQueryParam('STORE_ID'); 
        console.log(itemID, storeID); // Debugging to see if IDs are retrieved correctly
        
        if (itemID && storeID) {
            // Encode the parameters and append both to the request URL
            $.get("./../server/getProductDetails.php?ITEM_ID=" + encodeURIComponent(itemID) + "&STORE_ID=" + encodeURIComponent(storeID), function (data) {
                $("#product_list").html(data);
    
                var overlayHeight = $('.overlay').outerHeight();
                $('.underheadercontainer').height(overlayHeight);
            });
        } else {
            $("#product_list").html('<p>No product details available.</p>');
        }
    }
    
    // Assuming getQueryParam is defined and can correctly parse query parameters from the URL
    // If not, here's a simple implementation:
    function getQueryParam(param) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }
    
    // Call updateItemList to update the item list on page load
    updateItemList();

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

