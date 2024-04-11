$(document).ready(function () {

    // Retrieve the value from sessionStorage under the key 'currentList' - this is so that the table is the same when togglign bans 
    var currentList = sessionStorage.getItem('currentList');

    // Variable to store the user selection option
    let userSelectOption="all";

    // Check if currentList is truthy (i.e., not undefined, null, or empty string)
    if (currentList) {
        // If truthy, assign the value of currentList to userSelectOption
        userSelectOption = currentList;
    }
        updateFilteredUserTable(userSelectOption, "");

    //userSelectOptionKeyword will be all, active or inactive 
    function updateFilteredUserTable(userSelectOptionKeyword, userSearchTerm)
    {

        var userSelectUrl;

		userSelectUrl = "./../server/allUserList.php";
		if (userSelectOptionKeyword == "active_users"){
            userSelectUrl = "./../server/activeUserList.php"
        }
        else if (userSelectOptionKeyword == "inactive_users"){
            userSelectUrl = "./../server/inactiveUserList.php"
        }
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

        //adding this so the submit button works even when page is refreshed from ajax
        var userSelectOption = $("#user_select").val();
        updateFilteredUserTable(userSelectOption, userSearchTerm);

        //keep a memory of the page you were just on 
        sessionStorage.setItem('currentList', userSelectOption);
    });

    $("#user_select").on("change", function () {
        userSelectOption = this.value;  
    });

	function filterUserTable(userSearchTerm) {
        var userSearchTermLower = userSearchTerm.toLowerCase();
    
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

