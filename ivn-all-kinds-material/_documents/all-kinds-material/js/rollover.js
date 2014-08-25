// JavaScript Document

$(function() {
    $(".rollover").hover(function() {
        $(this).attr("src", $(this).attr("src").replace(/(.*)\.(.*)/, "$1_on.$2"));
    }, function () {
        $(this).attr("src", $(this).attr("src").replace(/_on/, ""));
    });
});