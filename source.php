<?php
// $Id$
$_SERVER['BASE_PAGE'] = 'source.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/prepend.inc';

$SIDEBAR_DATA = '
<p>
 The syntax highlighted source is automatically generated by PHP from
 the plaintext script.
</p>

<p>
 If you\'re interested in what\'s behind the several functions we
 used, you can always take a look at the source of the
 <ul>
  <li><a href="/source.php?url=/include/prepend.inc">prepend.inc</a></li>
  <li><a href="/source.php?url=/include/site.inc">site.inc</a></li>
  <li><a href="/source.php?url=/include/mirrors.inc">mirrors.inc</a></li>
  <li><a href="/source.php?url=/include/countries.inc">countries.inc</a></li>
  <li><a href="/source.php?url=/include/languages.inc">languages.inc</a></li>
  <li><a href="/source.php?url=/include/langchooser.inc">langchooser.inc</a></li>
  <li><a href="/source.php?url=/include/ip-to-country.inc">ip-to-country.inc</a></li>
  <li><a href="/source.php?url=/include/layout.inc">layout.inc</a></li>
  <li><a href="/source.php?url=/include/last_updated.inc">last_updated.inc</a></li>
  <li><a href="/source.php?url=/include/shared-manual.inc">shared-manual.inc</a></li>
  <li><a href="/source.php?url=/include/manual-lookup.inc">manual-lookup.inc</a></li>
 </ul>
 files.
</p>

<p>
 Of course, if you want to see the source of this page, have a look
 <a href="/source.php?url=/source.php">here</a>.
 You can also browse the cvs repository for this website on
 <a href="http://cvs.php.net/cvs.php/phpweb/">cvs.php.net</a>.
</p>
';

commonHeader("Show Source");

// No file param specified
if (!isset($_GET['url'])) {
    echo "<h1>No page URL specified</h1>";
    commonFooter();
    exit;
}

echo "<h1>Source of: " . htmlentities($_GET['url']) . "</h1>"; 

// Get dirname of the specified URL part
$dir = dirname($_GET['url']);

// Some dir was present in the filename
if (!empty($dir) && !preg_match("!^(\\.|/)$!", $dir)) {

    // Check if the specified dir is valid
    $legal_dirs = array(
        "/manual"  => 1,
        "/include" => 1,
        "/stats"   => 1,
        "/error"   => 1,
        "/license" => 1
    );
    if (preg_match("!^/manual/$!", $dir) || isset($legal_dirs[$dir])) {
        $page_name = $_SERVER['DOCUMENT_ROOT'] . $_GET['url'];
    } else { $page_name = FALSE; }
} else {
    $page_name = $_SERVER['DOCUMENT_ROOT'] . '/' . basename($_GET['url']);
}

// Provide some feedback based on the file found
if (!$page_name || @is_dir($page_name)) {
    echo "<p>Invalid file or folder specified</p>\n";
} elseif (file_exists($page_name)) {
    highlight_php(join("", file($page_name)));
} else {
    echo "<p>This file does not exist.</p>\n";
}

commonFooter();

?>
