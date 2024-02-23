function updateGlobalVariable(storeId) {
    $.get("../server/getStoreItems.php?SELECTED_STORE=" + storeId, function (data) {
        //console.log(data);
        $("#item_list").html(data);
    });
}

$("#store_select").on("change", function () {
    //console.log("store_select change event triggered with value: " + this.value);
    updateGlobalVariable(this.value);
});
