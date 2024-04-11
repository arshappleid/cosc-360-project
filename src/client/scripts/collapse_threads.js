$(document).ready(function () {
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




