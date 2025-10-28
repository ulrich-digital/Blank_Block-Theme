<?php
// Falls 404-Block-Template existiert, wird dieses i. d. R. bevorzugt.
// Diese Datei greift nur, wenn kein 404.html vorhanden ist.
wp_safe_redirect(home_url('/'), 301);
exit;
