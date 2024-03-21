$(document).ready(function () {
    function updateItemList() {
        $.get("./../server/getAllItems.php", function (data) {
            $("#item_list").html(data);
        });
    }

    updateItemList();

    function updateStoreFilterList(storenumber) {
        $.get("./../server/getStoreItems.php?SELECTED_STORE=" + storenumber, function (data) {
            $("#item_list").html(data);
        });
    }

    $("#store_select").on("change", function () {
        console.log("store_select change event triggered with value: " + this.value);
        updateStoreFilterList(this.value);
    });

    function filterStoreItems(searchTerm) {
        $("#item_list section").each(function () {
            var itemText = $(this).find("aside h3").text().toLowerCase();
            var searchTermLower = searchTerm.toLowerCase(); // Converts searchTerm to lowercase

            // Check if itemText contains the searchTermLower
            if (itemText.indexOf(searchTermLower) === -1) {
                $(this).hide(); // Hide if not containing searchTerm
            } else {
                $(this).show(); // Show if containing searchTerm
            }
        });
    }

    $("#search_item").on("keyup", function () {
        filterStoreItems(this.value);
    });
});