$(document).ready(function(){
    $("#loadCerts").click(function() {
        $("#content").attr("data", "certs.php");
    });
    $("#loadLabs").click(function() {
        $("#content").attr("data", "labs.php");
    });
    $("#loadNews").click(function() {
        $("#content").attr("data", "news.html");
    });
    $("#loadAbout").click(function() {
        $("#content").attr("data", "about.html");
    });
    $(".clickable").mouseover(function () {
        $(this).css("background-color", "rgb(77, 77, 255)");
    });
    $(".clickable").mouseleave(function () {
        $(this).css("background-color", "rgb(255, 153, 102)");
    });
});
