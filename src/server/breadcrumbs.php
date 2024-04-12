<?php

function buildBreadcrumbs($baseLabel = 'login', $baseUrl = 'qfinocch/src/client')
{
    // Get the REQUEST_URI, and strip the query string if present
    $uri = strtok($_SERVER['REQUEST_URI'], '?');

    //print_r($uri);
    // Split the URI into components
    $parts = explode('/', $uri);
    //print_r($parts);

    // Filter out empty values and the base directory
    $parts = array_filter($parts, function ($value) use ($baseUrl) {
        return $value !== '' && !in_array($value, explode("/", $baseUrl));
    });
    print_r($parts);

    $startUrl = $baseLabel . ".php";
    $breadcrumbs = "<div class=\"breadcrumb_box\"><a href=\"$startUrl\">$baseLabel</a>";
    $path = $baseUrl;

    foreach ($parts as $part) {
        // Decode URL-encoded string to normal string
        $partName = urldecode($part);
        // Construct the path for the breadcrumb link
        $path .= '/' . $partName . ".php";

        // Check if we are at the last part to avoid making the current page a link
        if ($part !== end($parts)) {
            $showName = ucfirst($partName);
            $breadcrumbs .= " / <a href=\"$path\">$showName</a>";
        } else {
            // Display the current page name without a link
            $partName = ucfirst(str_replace(".php", "", $partName));
            $breadcrumbs .= " / $partName";
        }
    }

    $breadcrumbs .= "</div>";

    return $breadcrumbs;
}

// Example usage
echo buildBreadcrumbs();
