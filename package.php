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
$p2->setReleaseVersion('1.5.0');
$p2->setAPIVersion('1.5.0');
$p2->setReleaseStability('stable');
$p2->setAPIStability('stable');
$p2->setNotes('* news
- copyright bump to 2009
- fix dependencies
- remove dreprecated function (setJsElement) since version 1.3.0
- rewrites JS in object literal notation (uses namespace)
- add two new buttons to move up to top or down to bottom a selected item
- add a minimized/compressed version of Javascript code; uses getElementJs()
- may now load options (class constructor) with fancy attributes
  without additional code
- qfams_custom_3.php show that it is now possible
  to define one or more item (preselected) that cannot be remove by end-user
- setElementTemplate() function signature changed (but keep BC) :
  allow to use only one instance of javascript code
- remove embedded version of TDG (The Definitive Guide)
  now it was included in the new PEAR
- new example qfams_custom_9.php show how to handle fancy options attributes
  (disabled, style:color background-color ...)
- handle of persistant options at run-time
  (see new methods: getPersistantOptions, setPersistantOptions)
- PEAR_Error instance throws have now a level (exception or error)
  and a code identified by HTML_QUICKFORM_ADVMULTISELECT_ERROR_INVALID_INPUT constant

* QA
- Old User Guide 1.4.0 that was previously included in past releases, was removed.
  The most up-to-date documentation is now part of the new PEAR Manual.
- Add unit test suites (for PHPUnit 3.2+) with code coverage closest to 100% (97.30)
');

//$p2->setLicense('BSD', 'http://www.opensource.org/licenses/bsd-license.php');

if (isset($_GET['make'])
    || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    $p2->writePackageFile();
} else {
    $p2->debugPackageFile();
}
?>