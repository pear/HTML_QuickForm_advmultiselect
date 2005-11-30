<?php
/**
 * Make package.xml version 1.0 and GNU TAR archive files
 * for HTML_QuickForm_advmultiselect package.
 * from a CVS repository (see line 55).
 *
 * This script is almost generic :
 * All you have to do is change (for your own package)
 * - $package         package name
 * - $license         license used
 * - $description     a full description of your new package
 * - $summary         a short description of your new package
 * - $baseinstalldir  base of directory installation
 *
 * Release specific data are only into file "release.inc"
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 */

require_once 'PEAR/Packager.php';
require_once 'PEAR/PackageFileManager.php';
require_once 'release.inc';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

// Package name and license used
$package = 'HTML_QuickForm_advmultiselect';
$license = 'PHP License 3.0';

// Full description of the package
$description = <<<DESCR
The HTML_QuickForm_advmultiselect package adds an element to the
HTML_QuickForm package that is two select boxes next to each other
emulating a multi-select.
DESCR;

// Summary of description of the package
$summary = 'Element for HTML_QuickForm that emulate a multi-select.';

// base of install directory
$baseinstalldir = 'HTML/QuickForm';

// -----------------------------------------------------------------------------
// --- DON'T MODIFY ANYTHING BELOW ---------------------------------------------
// -----------------------------------------------------------------------------

// Configuration of PEAR::PackageFileManager
$optionsUpdate = array(
    'version'           => $release['version'],
    'state'             => $release['state'],
    'notes'             => $release['notes'],
    'packagedirectory'  => '.',
    'filelistgenerator' => 'cvs',
    'baseinstalldir'    => $baseinstalldir,
    'changelogoldtonew' => false,
    'simpleoutput'      => false,
    'ignore'            => $release['ignore'],
    'exceptions'        => $release['exceptions']
);

$optionsCreate = array(
    'package'           => $package,
    'summary'           => $summary,
    'description'       => $description,
    'license'           => $license
);


$packagefile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'package.xml';

$pkg = new PEAR_PackageFileManager();

$packagefileExists = file_exists($packagefile);

if ($packagefileExists) {
    $pkg->importOptions($packagefile, $optionsUpdate);
} else {
    $options = array_merge($optionsUpdate, $optionsCreate);
    $pkg->setOptions($options);
}

// Replacements on all files or only a subset of them
if (is_array($release['replacements'])) {
    foreach ($release['replacements'] as $file) {
        $pkg->addReplacement($file, 'package-info', '@package_version@', 'version');
    }
} elseif ($release['replacements'] === true) {
    $pkg->addGlobalReplacement('package-info', '@package_version@', 'version');
}

// package file does not exists
if (!$packagefileExists) {

    // add Maintainers
    if (is_array($release['maintainers'])) {
        foreach ($release['maintainers'] as $handle => $data) {
            $pkg->addMaintainer($handle, $data['role'], $data['name'], $data['email']);
        }
    }

    // add Dependencies
    if (is_array($release['dependencies'])) {
        foreach ($release['dependencies'] as $name => $data) {
            $version  = isset($data['version']) ? $data['version'] : false;
            $operator = isset($data['operator']) ? $data['operator'] : 'ge';
            $type     = isset($data['type']) ? $data['type'] : 'pkg';
            $optional = isset($data['optional']) ? $data['optional'] : false;

            $pkg->addDependency($name, $version, $operator, $type, $optional);
        }
    }
}

// Writes the new version of package.xml
if (isset($_GET['make']) || isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'make') {
    @$pkg->writePackageFile();

// Writes the new version of package.xml and Build the new binary distribution
} elseif (isset($_GET['build']) || isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'build') {
    @$pkg->writePackageFile();
    $pkgbin = new PEAR_Packager();
    $pkgbin->package($packagefile);

} else {
    @$pkg->debugPackageFile();

    if (substr(php_sapi_name(), 0, 3) == 'cli') {
        $cmdHelp =
          "usage: php -f " . basename(__FILE__) . " [options]\n"
        . "Options:\n"
        . "     make        write only the new version of package.xml\n"
        . "     build       write new version of package.xml and build tarball\n";

        echo "\n$cmdHelp";
    } else {
        echo '[<a href="' . $_SERVER['PHP_SELF'] . '?make=1">Make new XML file</a>] - ';
        echo '[<a href="' . $_SERVER['PHP_SELF'] . '?build=1">Make new XML file and build Tarball</a>]';
    }
}
?>