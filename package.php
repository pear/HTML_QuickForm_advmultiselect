<?php
/**
 * Make package.xml and GNU TAR archive files for HTML_QuickForm_advmultiselect class
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 */

require_once 'PEAR/Packager.php';
require_once 'PEAR/PackageFileManager.php';

function handleError($e) {

    if (PEAR::isError($e)) {
        die($e->getMessage());
    }
}

// Full description of the package
$description = <<<DESCR
The HTML_QuickForm_advmultiselect package adds an element to the
HTML_QuickForm package that is two select boxes next to each other
emulating a multi-select.
DESCR;

// Summary of description of the package
$summary = 'Element for HTML_QuickForm that emulate a multi-select.';

// New version and state of the package
$version = '0.4.0';
$state   = 'beta';

// Notes about this new release
$notes = <<<NOTE
This is the initial release of the HTML_QuickForm_advmultiselect package.

Live demos, screenshots, source codes and much more are available on my
project homepage at http://pear.laurent-laville.org/HTML_QuickForm_advmultiselect
NOTE;

// Configuration of PEAR::PackageFileManager
$options = array(
    'package'           => 'HTML_QuickForm_advmultiselect',
    'summary'           => $summary,
    'description'       => $description,
    'license'           => 'PHP License 3.0',
    'baseinstalldir'    => 'HTML/QuickForm',
    'version'           => $version,
    'packagedirectory'  => '.',
    'state'             => $state,
    'filelistgenerator' => 'cvs',
    'changelogoldtonew' => false,
//    'simpleoutput'      => true,       // see bug#4604
    'notes'             => $notes,
    'ignore'            => array('package.xml', 'package.php',
                                 'Thumbs.db'
                                ),
    'cleardependencies' => true
);


$pkg = new PEAR_PackageFileManager();

$e = $pkg->setOptions( $options );
handleError($e);

// Replaces version number only in necessary files
$phpfiles = array(
    'advmultiselect.php',
);
foreach ($phpfiles as $file) {
    $e = $pkg->addReplacement($file, 'package-info', '@package_version@', 'version');
    handleError($e);
}
// Maintainers List
$e = $pkg->addMaintainer( 'farell', 'lead', 'Laurent Laville', 'pear@laurent-laville.org' );
handleError($e);

// Dependencies List
$e = $pkg->addDependency('PHP', '4.2.0', 'ge', 'php');
handleError($e);
$e = $pkg->addDependency('PEAR', false, 'has');
handleError($e);
$e = $pkg->addDependency('HTML_Common', '1.2.1', 'ge');
handleError($e);
$e = $pkg->addDependency('HTML_QuickForm', '3.2.4', 'gt');
handleError($e);

// Writes the new version of package.xml
if (isset($_GET['make'])) {
    $e = @$pkg->writePackageFile();
} else {
    $e = @$pkg->debugPackageFile();
}
handleError($e);

// Build the new binary package
if (!isset($_GET['make'])) {
    echo '<a href="' . $_SERVER['PHP_SELF'] . '?make=1">Make this XML file</a>';
} else {
    $options = $pkg->getOptions();
    $pkgfile = $options['packagedirectory'] . DIRECTORY_SEPARATOR . $options['packagefile'];

    $pkgbin = new PEAR_Packager();

    $e = $pkgbin->package($pkgfile);
    handleError($e);
}
?>