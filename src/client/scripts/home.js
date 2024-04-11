$(document).ready(function () {

    var selectedStoreId = "all";

    updateFilteredItemList(selectedStoreId, "");

    function updateFilteredItemList(storeId, searchTerm) {
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
    }

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

    function initializeCollapsibles() {
        $(".collapsible").off("click").on("click", function () { // Turn off any existing click handlers to prevent duplicates
            var sibling = $(this).prev().children().first().next().children().first();
            var siblings = [];
            while (sibling.length !== 0) {
                if (!sibling.is(this)) {
                    siblings.push(sibling.get(0));
                }
                sibling = sibling.next();
            }
            if (siblings.length === 0) return;
            siblings.forEach((content) => {
                if ($(content).hasClass("hidden_comments")) {
                    $(content).toggle(); // This will handle showing and hiding
                }
            });
            if (this.innerHTML === "Show All Comments") {
                this.innerHTML = "Hide Comments";
            } else {
                this.innerHTML = "Show All Comments";
            }
        });
    }

    initializeCollapsibles();

    $(window).on("pageshow", function(event) {
        if (event.originalEvent.persisted) {
            initializeCollapsibles(); 
        }
    });
});