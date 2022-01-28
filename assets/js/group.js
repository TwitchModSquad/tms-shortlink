$(function() {
    $(".user").on("click", function (e) {
        console.log(e);
        let ele = $(e.target);
        if (ele.attr("data-href")) {
            window.open(ele.attr("data-href"), "__blank");
            return false;
        }
    });
});