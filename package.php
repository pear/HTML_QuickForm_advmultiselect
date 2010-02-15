<?php
/**
 * HTML_QuickForm_advmultiselect Package Script Generator
 *
 * Generate a new fresh version of package xml 2.0
 * built with PEAR_PackageFileManager 1.6.0+
 *
 * PHP versions 4 and 5
 *
 * @category  HTML
 * @package   HTML_QuickForm_advmultiselect
 * @author    Laurent Laville <pear@laurent-laville.org>
 * @copyright 2007-2009 Laurent Laville
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/HHTML_QuickForm_advmultiselect
 * @since     File available since Release 1.3.0
 * @ignore
 */

require_once 'PEAR/PackageFileManager2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

$packagefile = dirname(__FILE__) . '/package.xml';

$options = array('filelistgenerator' => 'svn',
    'packagefile' => 'package.xml',
    'baseinstalldir' => '/',
    'simpleoutput' => true,
    'clearcontents' => false,
    'changelogoldtonew' => false,
    'ignore' => array(__FILE__)
    );

$p2 = &PEAR_PackageFileManager2::importOptions($packagefile, $options);
$p2->setPackageType('php');
$p2->addRelease();
$p2->generateContents();
$p2->setReleaseVersion('1.5.1');
$p2->setAPIVersion('1.5.0');
$p2->setReleaseStability('stable');
$p2->setAPIStability('stable');
$p2->setNotes('
[+] New features
 -  None

[*] Improvements / changes
 -  None

[-] Bugfixes
 -  single or dual shape is now well commented when using setComment()

[!] Quality Assurance
 -  Improve unit test suites (for PHPUnit 3.2+) with code coverage closest to 100% (99.81)
 -  Upgrade HTML_Common dependency from 1.2.4 to 1.2.5
');

//$p2->setLicense('BSD', 'http://www.opensource.org/licenses/bsd-license.php');

if (isset($_GET['make'])
    || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    $p2->writePackageFile();
} else {
    $p2->debugPackageFile();
}
?>