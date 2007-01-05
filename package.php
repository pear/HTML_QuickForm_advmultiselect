<?php
/**
 * HTML_QuickForm_advmultiselect Package Script Generator
 *
 * Generate a new fresh version of package xml 2.0 built with PEAR_PackageFileManager 1.6.0+
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   HTML
 * @package    HTML_QuickForm_advmultiselect
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2007 Laurent Laville
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/HHTML_QuickForm_advmultiselect
 * @since      File available since Release 1.3.0
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
    'ignore' => array('package.php')
    );

$p2 = &PEAR_PackageFileManager2::importOptions($packagefile, $options);
$p2->setPackageType('php');
$p2->addRelease();
$p2->generateContents();
$p2->setReleaseVersion('1.3.0');
$p2->setAPIVersion('1.0.0');
$p2->setReleaseStability('stable');
$p2->setAPIStability('stable');
$p2->setNotes('* warning
- PHP 4.2.0 is still enough to use all other API except getElementJs()
  that requires now PHP 4.3.0 to retrieve inline javascript source code.
  BTW usage of getElementJs() begin optional and not recommanded.

* news
- placeholders to display live counters (unselected, selected, all items)
  see examples/qfams_multiple_2.php and User Guide for details

* changes
- fixed closing html-styles tags that raised a warning in all examples
- copyright notice bumped to 2007
- license fixed to PHP 3.01
- use namespace for CSS and JS
- setJsElement() is marked as deprecated, since rewrite of JS (external file) with namespace
- more placeholders into template to support new feature : Live Counter
- getElementJs return now content of external JS to avoid BC break

* QA
- User Guide 1.3.0 included in this release cover all versions 1.x.x
  see http://pear.laurent-laville.org/HTML_QuickForm_advmultiselect for more format to download.
');

if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    $p2->writePackageFile();
} else {
    $p2->debugPackageFile();
}
?>