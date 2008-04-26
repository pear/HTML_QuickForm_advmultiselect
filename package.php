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
 * @copyright 2007-2008 Laurent Laville
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/HHTML_QuickForm_advmultiselect
 * @since     File available since Release 1.3.0
 * @ignore
 */

require_once 'PEAR/PackageFileManager2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

$packagefile = 'c:/php/pear/HTML_QuickForm_advmultiselect/package2.xml';

$options = array('filelistgenerator' => 'cvs',
    'packagefile' => 'package2.xml',
    'baseinstalldir' => 'HTML',
    'simpleoutput' => true,
    'clearcontents' => false,
    'changelogoldtonew' => false,
    'ignore' => array(__FILE__)
    );

$p2 = &PEAR_PackageFileManager2::importOptions($packagefile, $options);
$p2->setPackageType('php');
$p2->addRelease();
$p2->generateContents();
$p2->setReleaseVersion('1.4.1');
$p2->setAPIVersion('1.0.0');
$p2->setReleaseStability('stable');
$p2->setAPIStability('stable');
$p2->setNotes('* news
- Introduce a TIP to make double-select-box XHTML 1.0 Strict compliant
  even with an empty list.

* bugs
- fix #13680 : XHTML - Need to create a distinct id for all checkboxes

* changes
- With default element template there is a label, that does not exist with submit button
  All examples uses a custom submit-element template to make them XHTML compliant.

* QA
- User Guide 1.4.0 included in this release cover all versions 1.x.x
  see http://pear.laurent-laville.org/HTML_QuickForm_advmultiselect
  for more format to download.
');

//$p2->setLicense('BSD', 'http://www.opensource.org/licenses/bsd-license.php');

if (isset($_GET['make'])
    || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    $p2->writePackageFile();
} else {
    $p2->debugPackageFile();
}
?>