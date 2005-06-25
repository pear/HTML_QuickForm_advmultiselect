<?php
/**
 * Custom advMultiSelect HTML_QuickForm element
 * embedded into a Sigma template and using the QF dynamic renderer.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 * @subpackage Examples
 * @access     public
 */

require_once 'HTML/Template/Sigma.php';
require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/Renderer/ITDynamic.php';
require_once 'HTML/QuickForm/advmultiselect.php';

$form = new HTML_QuickForm('amsTemplate1');
$form->removeAttribute('name');        // XHTML compliance

$fruit_array = array(
    'apple'     =>  'Apple',
    'orange'    =>  'Orange',
    'pear'      =>  'Pear',
    'banana'    =>  'Banana',
    'cherry'    =>  'Cherry',
    'kiwi'      =>  'Kiwi',
    'lemon'     =>  'Lemon',
    'lime'      =>  'Lime',
    'tangerine' =>  'Tangerine',
);

// rendering with css selectors and API selLabel(), setButtonAttributes()
$form->addElement('header', null, 'Advanced Multiple Select: custom layout ');

$form->addElement('text', 'name', 'Name:', array('size' => 40, 'maxlength' => 80));

$ams =& $form->addElement('advmultiselect', 'fruit', null, $fruit_array,
                           array('size' => 15,
                                 'class' => 'pool', 'style' => 'width:150px;'
                                )
);
$ams->setLabel(array('Fruit:', 'Available', 'Selected'));
$ams->setButtonAttributes('add',    array('value' => 'Add >>',
                                           'class' => 'inputCommand'
));
$ams->setButtonAttributes('remove', array('value' => '<< Remove',
                                           'class' => 'inputCommand'
));
$template = '
<table{class}>
<!-- BEGIN label_2 --><tr><th>{label_2}</th><!-- END label_2 -->
<!-- BEGIN label_3 --><th>&nbsp;</th><th>{label_3}</th></tr><!-- END label_3 -->
<tr>
  <td valign="top">{unselected}</td>
  <td align="center">{add}{remove}</td>
  <td valign="top">{selected}</td>
</tr>
</table>
';
$ams->setElementTemplate($template);

if (isset($_POST['fruit'])) {
    $form->setDefaults(array('fruit' => $_POST['fruit']));
}

$form->addElement('submit', 'send', 'Send', array('class' => 'inputCommand'));

$form->addRule('name', 'Your name is required', 'required',
               null, 'client');
$form->addRule('fruit', 'At least one fruit is required', 'required',
               null, 'client');

$form->applyFilter('__ALL__', 'trim');
$form->applyFilter('__ALL__', 'strip_tags');

$valid = $form->validate();

$tpl = new HTML_Template_Sigma('.');
$tpl->loadTemplateFile('itdynamic.html');
$tpl->setVariable('ams_javascript', $ams->getElementJs(false));

$renderer = new HTML_QuickForm_Renderer_ITDynamic($tpl);

$form->accept($renderer);
$tpl->show();

if ($valid) {
    $clean = $form->getSubmitValues();

    printf("<p>Welcome <b>%s</b> you've selected these fruits:</p>",
           $clean['name']);
    echo implode(', ', $clean['fruit']);
}
?>