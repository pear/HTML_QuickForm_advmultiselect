<?php
/**
 * Release Notes for HTML_QuickForm_advmultiselect package.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 */

// New version and state of the package
$release['version'] = '1.1.0';
$release['state']   = 'stable';

$release['apiversion'] = '1.0.0';
$release['apistate']   = 'stable';

// Notes about this new release
$release['notes'] = <<<NOTES
* news
- ability to select/unselect all items (options) in one stroke.
- you may also toggle a selection.

See examples/qfams_custom_7.php script that demonstrates these new features.

* Quality Assurance
- User Guide (TDG), english html multi pages include was also updated
See chapter 5.Advanced features / buttons
and also chapter 8.Examples / Avanced selection usage

NOTES;

// specify files to exclude entirely from the package.xml
$release['ignore'] = array(
    'package.xml', 'packageV1.php', 'packageV2.php', basename(__FILE__),
    'Thumbs.db'
);

// specify file role for specific files
$release['exceptions'] = array(
    'ChangeLog' => 'doc',
    'NEWS' => 'doc'
);


// List of replacements that should be performed on every single file
// if list is empty then a global replacement will be apply
$release['replacements'] = array();  // none replacement
$release['replacements'] = true;     // global replacement
$release['replacements'] = array(    // replacement on a subset of files
    'advmultiselect.php'
);

// specify Maintainers list
$release['maintainers'] = array(
    'farell' => array('role' => 'lead', 'name' => 'Laurent Laville', 'email' => 'pear@laurent-laville.org')
);

// specify Dependencies list
$release['dependencies'] = false;     // no dependency
$release['dependencies'] = array();   // no dependency (empty list)
$release['dependencies'] = array(
    'PHP'  => array('version' => '4.2.0', 'type' => 'php'),
    'PEAR' => array('operator' => 'has'),
    'HTML_Common'  => array('version' => '1.2.1'),
    'HTML_QuickForm'  => array('version' => '3.2.4', 'operator' => 'gt')
);

?>