<?php
// Head include: outputs DOCTYPE, head and opens <body>
// Usage: set $page_title before including if you want a custom title.
if (!isset($page_title)) {
    $page_title = 'TechFix';
}
// Compute cache-busting timestamp for CSS
$css_path = __DIR__ . '/../css/style.css';
$css_ts = file_exists($css_path) ? filemtime($css_path) : time();
// Base href for stylesheet - adjust if your project is served from a subpath
$css_href = '/Customer-Service-Management-System/src/css/style.css?v=' . $css_ts;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="<?php echo $css_href; ?>">
    <?php
    // Allow pages to inject additional head content (styles/scripts) via $extra_head
    if (!empty($extra_head)) {
        echo $extra_head;
    }
    ?>
</head>
<body>
