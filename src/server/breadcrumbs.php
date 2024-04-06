<?php

function buildBreadcrumbs($baseLabel = 'login', $baseUrl = '/client') {
    // Get the REQUEST_URI, and strip the query string if present
    $uri = strtok($_SERVER['REQUEST_URI'], '?');

    // Split the URI into components
    $parts = explode('/', $uri);

    // Filter out empty values and the base directory
    $parts = array_filter($parts, function($value) use ($baseUrl) {
        return $value !== '' && $value !== ltrim($baseUrl, '/');
    });

    // Initialize breadcrumbs
    $startUrl = $baseLabel.".php";
    $breadcrumbs = "<a href=\"$startUrl\">$baseLabel</a>";
    $path = $baseUrl;

    foreach ($parts as $part) {
        // Decode URL-encoded string to normal string
        $partName = urldecode($part);
        // Construct the path for the breadcrumb link
        $path .= '/' . $partName .".php";

        // Check if we are at the last part to avoid making the current page a link
        if ($part !== end($parts)) {
            $showName = ucfirst($partName);
            $breadcrumbs .= " / <a href=\"$path\">$showName</a>";
        } else {
            // Display the current page name without a link
            $breadcrumbs .= " / $partName";
        }
    }

    return $breadcrumbs;
}

// Example usage
echo buildBreadcrumbs();
?>
