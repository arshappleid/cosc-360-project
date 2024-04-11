$(document).ready(function () {
    var buttons = $(".collapsible");
    buttons.each(function () {
        $(this).on("click", function () {
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
                if (content.id === "hidden_comments") {
                    $(content).toggle(); // This will handle showing and hiding
                }
            });
            if (this.innerHTML === "Show All Comments") {
                this.innerHTML = "Hide Comments";
            } else {
                this.innerHTML = "Show All Comments";
            }
        });
        console.log("Script executed");
    });
});