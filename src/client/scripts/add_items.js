$(document).ready(function () {
    // When 'Bulk Upload' is clicked
    $("#bulk-upload").click(function () {
        $("#bulk-upload-form").show();
        $("#individual-upload-form").hide();
        $("#new-category-form").hide();
    });

    // When 'Individual Upload' is clicked
    $("#individual-upload").click(function () {
        $("#bulk-upload-form").hide();
        $("#individual-upload-form").show();
        $("#new-category-form").hide();
    });

    $("#new-category").click(function () {
        $("#bulk-upload-form").hide();
        $("#individual-upload-form").hide();
        $("#new-category-form").show();
    });

    document.getElementById("bulk-upload-form").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevents the default form submission
        const file = document.getElementById("PRODUCT_INFO").files[0];
        if (!file) {
            alert("Please select a file");
            return;
        }

        const reader = new FileReader();

        reader.onload = async function (e) {
            const content = e.target.result;
            const rows = content.split("\n");
            const storeID = $("#bulk-upload-form #store_select").val();
            const apiResponses = [];
            var itemsAdded = 0;
            // Use Promise.all to wait for all fetch calls to complete
            await Promise.all(
                rows.map((row) => {
                    const record = row.split(",").map((entry) => entry.trim());
                    if (record.length < 4) return;
                    if (record.some((field) => field === "")) {
                        apiResponses.push({
                            row: index + 1,
                            reason: "Invalid format or missing fields",
                        });
                        return; // Skip this record
                    }
                    const postData = {
                        ITEM_NAME: record[0],
                        DESCRIPTION: record[1],
                        ITEM_PRICE: record[2],
                        EXTERNAL_LINK: record[3],
                        CATEGORY_NAME: record[4],
                        STORE_ID: storeID,
                    };

                    return fetch("./../../server/addMultipleItemToStore.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(postData),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            apiResponses.push(data.status);
                            if (data.status === "ITEM_ADDED") {
                                itemsAdded++;
                            }
                        });
                }),
            );

            // Now, apiResponses is fully populated
            $("#bulk_message").text(apiResponses.join(", ") + "\n;Items Added : " + itemsAdded); // Corrected jQuery selector and join array
        };

        reader.readAsText(file);
    });
    // Form Validation for individual upload
    document.getElementById("individual-upload-form").addEventListener("submit", function (event) {
        event.preventDefault();
        var allFilled = true;
        var formElements = this.elements;
        var elementsNotAdded = [];
        for (var i = 0; i < formElements.length; i++) {
            // Check if the form element is input or textarea and it's not empty
            if (
                formElements[i].type === "button" ||
                formElements[i].type === "submit" ||
                formElements[i].type === "reset"
            ) {
                continue;
            }
            if (formElements[i].name == "PRODUCT_IMAGE") {
                continue;
            }
            if (formElements[i].value === "") {
                elementsNotAdded.push(
                    formElements[i].name.replace("ITEM_", "").replace("_", " ").toLowerCase() + " ",
                );
                formElements[i].focus();
                allFilled = false;
            }
        }
        if (allFilled) {
            this.submit();
        } else {
            $("#individual_item_message").text(
                "Items Values : " + elementsNotAdded.toString() + " are Empty.",
            );
        }
    });
});
