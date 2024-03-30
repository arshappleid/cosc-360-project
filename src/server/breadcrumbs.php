<?php
echo "<div class = \"breadcrumb_box\">";
// Get the current path
$currentPath = $_SERVER["PHP_SELF"];

// Split the path into parts
$pathParts = explode('/', $currentPath);

unset($pathParts[0]); // Remove Src
unset($pathParts[1]); // Remove Client

$breadcrumbs = [];

// Build breadcrumbs
foreach ($pathParts as $key => $part) {
    // Build URL up to the current part
    $part = str_replace('.php', '', $part); // remove .php file extension
    $url = "client/" . implode('/', array_slice($pathParts, 0, $key + 1));
    // Add to breadcrumbs
    $breadcrumbs[] = "<a href='/$url'>$part</a>";
}

// Display breadcrumbs, separating them by " > "
echo implode(" / ", $breadcrumbs);
echo "</ul>";
echo "</div>";
