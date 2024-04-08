$(document).ready(function () {

    var userSelectOption="all";

    updateFilteredUserTable(userSelectOption, "");
    //userSelectOptionKeyword will be all, active or inactive 
    function updateFilteredUserTable(userSelectOptionKeyword, userSearchTerm)
    {
        var userSelectUrl;

		console.log("userSelectOptionKeyword = " + userSelectOptionKeyword);

		userSelectUrl = "./../server/allUserList.php";
		if (userSelectOptionKeyword == "active_users"){
            userSelectUrl = "./../server/activeUserList.php"
        }
        else if (userSelectOptionKeyword == "inactive_users"){
            userSelectUrl = "./../server/inactiveUserList.php"
        }
        console.log(userSelectUrl);
        $.get(userSelectUrl, function (data) {
           
            $("#user_table").empty().html(data);

            if (userSearchTerm) {
                filterUserTable(userSearchTerm);
            }
            if ($("#user_table tbody tr:visible").length === 0) {
                $("#user_table").html("<tr><td colspan='3'>No users found.</td></tr>");
            }
        }).fail(function () {
            $("#user_table").html("<tr><td colspan='3'>Error fetching users. Please try again.</td></tr>");
        });
	}


	$("#user-search-button").on("click", function () {
        var userSearchTerm = $("#user-search-input").val();
        updateFilteredUserTable(userSelectOption, userSearchTerm);
		console.log("userSelectOption =" + userSelectOption);

    });

    $("#user_select").on("change", function () {
        userSelectOption = this.value;
		console.log("userSelectOption =" +userSelectOption)
		console.log("Selected value =", $(this).val());
    });

	function filterUserTable(userSearchTerm) {
        var userSearchTermLower = userSearchTerm.toLowerCase();
        console.log("Search term:", userSearchTermLower); // Log the search term
    
        $("#user_table tbody tr:not(:first-child)").each(function () { // Exclude the first row
            var userFirstName = $(this).find("td:eq(0)").text().trim().toLowerCase(); // Target the first name cell using :eq(0)
            var userLastName = $(this).find("td:eq(1)").text().trim().toLowerCase(); // Target the last name cell using :eq(1)
            var userEmail = $(this).find("td:eq(2)").text().trim().toLowerCase(); // Target the last name cell using :eq(1)

            
            var match = userFirstName.indexOf(userSearchTermLower) !== -1 || userLastName.indexOf(userSearchTermLower) !== -1 || userEmail.indexOf(userSearchTerm) !== -1;
    
            if (match) {
                $(this).show(); // Show rows that match the search term
            } else {
                $(this).hide(); // Hide rows that do not match the search term
            }
        });
    }
});

