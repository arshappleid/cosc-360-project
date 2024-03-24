$(document).ready(function() {
    // Attempt to use global variables first
    var showChart = window.showChart || false;
    var showButton = window.showButton || false;

    // Check if the right container has an image and center the item image and info if not
    if (!showChart) {
        $('.right').hide();
        $('.first').css('justify-content', 'center');
    }

    // Adjust the layout depending on whether the button should be shown
    if (!showButton) {
        $('.left').css({
            'position': 'relative',
            'top': '1em'
        });
        $('#comment-button').hide();
    }

    // Toggle comment form display on button click
    const commentButton = document.getElementById("comment-button");
    const commentForm = document.getElementById("add-comment-form");
    if (commentButton && commentForm) {
        commentButton.addEventListener("click", function() {
            commentForm.style.display = commentForm.style.display === "none" ? "block" : "none";
            commentButton.textContent = commentForm.style.display === "block" ? "Hide Comment Form" : "Add Comment";
        });
    }

    // Function to extract query parameters from the URL
    function getQueryParam(param) {
        var searchParams = new URLSearchParams(window.location.search);
        return searchParams.get(param);
    }

    // Update the item list based on the item ID in the URL query parameter
    function updateItemList() {
        var itemID = getQueryParam('ITEM_ID');
        if (itemID) {
            $.get("./../server/getProductDetails.php?ITEM_ID=" + encodeURIComponent(itemID), function(data) {
                $("#item_list").html(data);
            });
        } else {
            $("#item_list").html('<p>No product details available.</p>');
        }
    }

    // Call updateItemList to update the item list on page load
    updateItemList();
});
