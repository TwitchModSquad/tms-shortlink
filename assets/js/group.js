$(function() {
    $(".user").on("click", function (e) {
        let ele = $(this);
        if (ele.attr("data-href") && !$(e.target).attr("href")) {
            window.open(ele.attr("data-href"), "__blank");
            return false;
        }
    });
});