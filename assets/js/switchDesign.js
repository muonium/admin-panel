$(document).ready(function() {
    var design = Cookies.get('design');
    setupDesign(design);
});

$("#switchDesign").click(function() {
    var design = Cookies.get('design');
    if(design == undefined || design == "light") {
        Cookies.set('design', 'dark');
        $("#style").attr('href', './assets/css/dark.css');
        $("#designLogo").removeClass("far");
        $("#designLogo").addClass("fas");
    } else {
        Cookies.set('design', 'light');
        $("#style").attr('href', './assets/css/light.css');
        $("#designLogo").removeClass("fas");
        $("#designLogo").addClass("far");
    }
});

function setupDesign(design) {
    if(design == undefined || design == "light") {
        Cookies.set('design', 'light');
        $("#style").attr('href', './assets/css/light.css');
        $("#designLogo").removeClass("fas");
        $("#designLogo").addClass("far");
    } else {
        Cookies.set('design', 'dark');
        $("#style").attr('href', './assets/css/dark.css');
        $("#designLogo").removeClass("far");
        $("#designLogo").addClass("fas");
    }
}