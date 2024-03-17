<?php
echo "<div class = \"breadcrumb_box\">";
echo "<ul class = \"breadcrumb\" >";
$length = count($_SESSION['BREADCRUMBS']);
foreach ($_SESSION['BREADCRUMBS'] as $key => $value) {
    echo "<li><a href=\"" . $value[1] . "\">" . $value[0] . "</a></li>";
}
echo "</ul>";
echo "</div>";