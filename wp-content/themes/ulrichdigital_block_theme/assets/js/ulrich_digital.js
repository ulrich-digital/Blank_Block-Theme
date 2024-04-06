jQuery(document).ready(function ($) {

/* =============================================================== *\ 
   Fehlendes title-Attribute hinzufügen
   - überprüft zuerst den Text-Content
   - danach das alt-Attribute
   - danach das Linkziel
\* =============================================================== */

function fehlendes_title_attribute_hinzufuegen() {
    $('a').each(function() {
        var $link = $(this);
        var title = $link.attr('title');
        
        if (!title) {
            var linkText = $link.text().trim();
            var imgAlt = $link.find('img').attr('alt');

            if (linkText) {        
                title = linkText.replace(/\n/g, '').trim().substring(0, 20); // Maximal 20 Zeichen
            } else if (imgAlt) { 
                title = imgAlt.replace(/\n/g, '').trim().substring(0, 20); // Maximal 20 Zeichen
            } else { 
                var linkHref = $link.attr('href');
                if (linkHref) {
                    var linkTitle = linkHref.replace(/^https?:\/\/[^/]+/, '').replace(/\/$/, '').replace(/^\//, '');
                    title = linkTitle.replace(/\n/g, '').trim().substring(0, 20); // Maximal 20 Zeichen
                }
            }
            
            if (title) {
                $link.attr('title', title);
            }
        }
    });
}

// Aufruf der Funktion
//fehlendes_title_attribute_hinzufuegen();

    /* =============================================================== *\ 
       DEVELOPMENT: 
       - Mobile Menü immer geöffnet
    \* =============================================================== */
    var bodyElement = $("body");
    var htmlElement = $("html");

    function addClassesIfMissing() {
        var responsiveContainer = $(".wp-block-navigation__responsive-container");
        if (responsiveContainer.length > 0) {
            responsiveContainer.addClass("has-modal-open is-menu-open");
            bodyElement.addClass("has-modal-open is-menu-open"); // Verwendung der gespeicherten Referenzen
            htmlElement.addClass("has-modal-open"); // Verwendung der gespeicherten Referenzen
        }
    }

    function startMutationObserver() {
        var targetNode = document.body;
        var config = { childList: true, subtree: true };
        var observer = new MutationObserver(function(mutationsList) {
            for (var mutation of mutationsList) {
                if (mutation.type === 'childList') {
                    addClassesIfMissing();
                    break; // Hinzugefügt, um den Observer nach der ersten Mutation zu stoppen
                }
            }
        });
        observer.observe(targetNode, config);
        addClassesIfMissing();
    }

    // Observer beim Laden des Dokuments starten
    //startMutationObserver();

}); //jQuery(document).ready
