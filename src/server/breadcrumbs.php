<?php
echo "<div class = \"breadcrumb_box\"></div>";
echo "<ul class = \"breadcrumb\" >";
foreach ($_SESSION['BREADCRUMBS'] as $key => $value) {
	# code...
	echo "<li><a href=\"" . $value[1] . "\">" . $value[0] . "</a></li>";
	if ($key != 0) {
		echo "<li><a href=\"" . $value[1] . "\">" . $value[0] . "</a>/</li>";
	}
}
echo "</ul>";
echo "</div>";
