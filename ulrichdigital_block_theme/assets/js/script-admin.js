jQuery(document).ready(function ($) {

    var el = $("button:contains('Beitragsbild')");
    setTimeout(function() {
        $(".block-editor-page button:contains('Beitragsbild')").hide();
    }, 2000);

});