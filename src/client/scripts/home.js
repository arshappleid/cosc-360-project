$(document).ready(function () {
    var lastUsedStoreId = "all";
    var lastUsedSearchTerm = "";

    updateFilteredItemList(lastUsedStoreId, "");

    function updateFilteredItemList(storeId, searchTerm) {
        storeId = storeId || lastUsedStoreId;
        searchTerm = searchTerm || lastUsedSearchTerm;
        var url =
            storeId === "all" ? "./../server/getAllItems.php" : "./../server/getStoreItems.php";
        if (storeId !== "all") {
            url += "?SELECTED_STORE=" + encodeURIComponent(storeId);
        }
        $.get(url, function (data) {
            $("#item_list").empty().html(data);

            var overlayHeight = $(".overlay").outerHeight();
            $(".underheadercontainer").height(overlayHeight);

            if (searchTerm) {
                filterStoreItems(searchTerm); // Apply text filter if there's a search term
            }

            if ($("#item_list section:visible").length === 0) {
                $("#item_list").html('<h1 class = "noitems">No products found.</h1>');
            }
        }).fail(function () {
            $("#item_list").html("<p>Error fetching products. Please try again.</p>");
        });
        lastUsedStoreId = storeId;
        lastUsedSearchTerm = searchTerm;
    }
    // Run the UpdateFilteredItemList Function every 60 seconds
    setInterval(function () {
        updateFilteredItemList();
    }, 60000);

    $("#search-button").on("click", function () {
        var searchTerm = $("#search-input").val();
        updateFilteredItemList(selectedStoreId, searchTerm);
    });

    $("#store_select").on("change", function () {
        selectedStoreId = this.value;
    });

    // Filters items in the item list based on the search term
    function filterStoreItems(searchTerm) {
        var searchTermLower = searchTerm.toLowerCase();

        $("#item_list section").each(function () {
            var itemText = $(this).find("aside h3").text().toLowerCase();
            if (itemText.indexOf(searchTermLower) === -1) {
                $(this).hide(); // Hide items that do not match the search term
            } else {
                $(this).show(); // Show items that match the search term
            }
        });
    }
});
