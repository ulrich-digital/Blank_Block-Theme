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


}); //jQuery(document).ready
