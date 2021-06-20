<?php 

# Define some useful vars
$child_theme_root = get_stylesheet_directory_uri()

# Include the ACF Field definition file
include_once "acf-fields.php"; 

# Enque main styles of the child theme
wp_enqueue_style("ebdAPPStyles", $child_theme_root . "/src/css/ebdAPPStyles.css"

?>