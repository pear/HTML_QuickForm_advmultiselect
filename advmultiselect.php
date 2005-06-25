<?php
/**
 * Element for HTML_QuickForm that emulate a multi-select.
 *
 * The HTML_QuickForm_advmultiselect package adds an element to the
 * HTML_QuickForm package that is two select boxes next to each other
 * emulating a multi-select.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   HTML
 * @package    HTML_QuickForm_advmultiselect
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/HTML_QuickForm_advmultiselect
 */

require_once 'HTML/QuickForm/select.php';

/**
 * Replace PHP_EOL constant
 *
 * @category    PHP
 * @package     PHP_Compat
 * @link        http://php.net/reserved.constants.core
 * @author      Aidan Lister <aidan@php.net>
 * @version     $Revision$
 * @since       PHP 5.0.2
 */
if (!defined('PHP_EOL')) {
    switch (strtoupper(substr(PHP_OS, 0, 3))) {
        // Windows
        case 'WIN':
            define('PHP_EOL', "\r\n");
            break;

        // Mac
        case 'DAR':
            define('PHP_EOL', "\r");
            break;

        // Unix
        default:
            define('PHP_EOL', "\n");
    }
}

/**
 * Element for HTML_QuickForm that emulate a multi-select.
 *
 * The HTML_QuickForm_advmultiselect package adds an element to the
 * HTML_QuickForm package that is two select boxes next to each other
 * emulating a multi-select.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   HTML
 * @package    HTML_QuickForm_advmultiselect
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/HTML_QuickForm_advmultiselect
 */
class HTML_QuickForm_advmultiselect extends HTML_QuickForm_select
{
    /**
     * Prefix function name in javascript move selections
     *
     * @var        string
     * @access     private
     */
    var $_jsPrefix;

    /**
     * Postfix function name in javascript move selections
     *
     * @var        string
     * @access     private
     */
    var $_jsPostfix;

    /**
     * Associative array of the multi select container attributes
     *
     * @var        array
     * @access     private
     */
    var $_tableAttributes;

    /**
     * Associative array of the add button attributes
     *
     * @var        array
     * @access     private
     */
    var $_addButtonAttributes;

    /**
     * Associative array of the remove button attributes
     *
     * @var        array
     * @access     private
     */
    var $_removeButtonAttributes;

    /**
     * Associative array of the unselected item box attributes
     *
     * @var        array
     * @access     private
     */
    var $_attributesUnselected;

    /**
     * Associative array of the selected item box attributes
     *
     * @var        array
     * @access     private
     */
    var $_attributesSelected;

    /**
     * Associative array of the internal hidden box attributes
     *
     * @var        array
     * @access     private
     */
    var $_attributesHidden;

    /**
     * Default Element template string
     *
     * @var        string
     * @access     private
     */
    var $_elementTemplate = '
{javascript}
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

    /**
     * Default Element stylesheet string
     *
     * @var        string
     * @access     private
     */
    var $_elementCSS = '
#{id}amsSelected {
  font: 13.3px sans-serif;
  background-color: #fff;
  overflow: auto;
  height: 14.3em;
  width: 12em;
  border-left:   1px solid #404040;
  border-top:    1px solid #404040;
  border-bottom: 1px solid #d4d0c8;
  border-right:  1px solid #d4d0c8;
}
#{id}amsSelected label {
  padding-right: 3px;
  display: block;
}
';

    /**
     * Class constructor
     *
     * @param      string    Dual Select name attribute
     * @param      mixed     Label(s) for the select boxes
     * @param      mixed     Data to be used to populate options
     * @param      mixed     Either a typical HTML attribute string or an associative array
     *
     * @access     public
     * @return     void
     */
    function HTML_QuickForm_advmultiselect($elementName=null, $elementLabel=null,
                                           $options=null, $attributes=null)
    {
        $this->HTML_QuickForm_select($elementName, $elementLabel, $options, $attributes);

        // add multiple selection attribute by default if missing
        $this->updateAttributes(array('multiple' => 'multiple'));

        if (is_null($this->getAttribute('size'))) {
            // default size is ten item on each select box (left and right)
            $this->updateAttributes(array('size' => 10));
        }
        if (is_null($this->getAttribute('style'))) {
            // default width of each select box
            $this->updateAttributes(array('style' => 'width:100px;'));
        }
        $this->_tableAttributes = $this->getAttribute('class');
        if (is_null($this->_tableAttributes)) {
            // default table layout
            $attr = array('border' => '0', 'cellpadding' => '10', 'cellspacing' => '0');
        } else {
            $attr = array('class' => $this->_tableAttributes);
            $this->_removeAttr('class', $this->_attributes);
        }
        $this->_tableAttributes = $this->_getAttrString($attr);

        // set default add button attributes
        $this->setButtonAttributes('add');
        // set default remove button attributes
        $this->setButtonAttributes('remove');
        // defines javascript functions names
        $this->setJsElement();
    }

    /**
     * Sets the button Add|Remove attributes
     *
     * @param      string    Button identifier, either 'add' or 'remove'
     * @param      mixed     (optional) Either a typical HTML attribute string
     *                                  or an associative array
     * @access     public
     */
    function setButtonAttributes($button, $attributes = null)
    {
        if (!is_string($button)) {
            return PEAR::raiseError('Argument 1 of advmultiselect::setButtonAttributes'
                                   .' is not a string');
        }

        switch ($button) {
            case 'add':
                if (is_null($attributes)) {
                    $this->_addButtonAttributes = array('name'  => 'add',
                                                        'value' => ' >> ',
                                                        'type'  => 'button'
                                                       );
                } else {
                    $this->_updateAttrArray($this->_addButtonAttributes,
                                            $this->_parseAttributes($attributes)
                    );
                }
                break;
            case 'remove':
                if (is_null($attributes)) {
                    $this->_removeButtonAttributes = array('name'  => 'remove',
                                                           'value' => ' << ',
                                                           'type'  => 'button'
                                                          );
                } else {
                    $this->_updateAttrArray($this->_removeButtonAttributes,
                                            $this->_parseAttributes($attributes)
                    );
                }
                break;
            default;
                return PEAR::raiseError('Argument 1 of advmultiselect::setButtonAttributes'
                                       .' has unexpected value');
        }
    }

    /**
     * Sets element template
     *
     * @param      string    The HTML surrounding select boxes and buttons
     *
     * @access     public
     * @return     void
     */
    function setElementTemplate($html)
    {
        $this->_elementTemplate = $html;
    }

    /**
     * Sets JavaScript function name parts. Maybe usefull to avoid conflict names
     *
     * @param      string    (optional) Prefix name
     * @param      string    (optional) Postfix name
     *
     * @access     public
     * @return     void
     */
    function setJsElement($pref = null, $post = 'moveSelections')
    {
        $this->_jsPrefix  = $pref;
        $this->_jsPostfix = $post;
    }

    /**
     * Gets default element stylesheet for a basic render
     *
     * @param      boolean   (optional) html output with script tags or just raw data
     *
     * @access     public
     * @return     string
     */
    function getElementCss($raw = true)
    {
        $id = $this->getAttribute('id');
        $css = str_replace('{id}', $id, $this->_elementCSS);

        if ($raw !== true) {
            $css = '<style type="text/css">' . PHP_EOL
                 . '<!--' . $css . '// -->'  . PHP_EOL
                 . '</style>';
        }
        return $css;
    }

    /**
     * Returns the HTML generated for the advanced mutliple select component
     *
     * @access     public
     * @return     string
     */
    function toHtml()
    {
        if ($this->_flagFrozen) {
            return $this->getFrozenHtml();
        }

        $tabs    = $this->_getTabs();
        $tab     = $this->_getTab();
        $strHtml = '';

        if ($this->getComment() != '') {
            $strHtml .= $tabs . '<!-- ' . $this->getComment() . " //-->" . PHP_EOL;
        }

        $selectName = $this->getName() . '[]';

        // placeholder {unselected} existence determines if we will render
        if (strpos($this->_elementTemplate, '{unselected}') === false) {
            // ... a single multi-select with checkboxes

            $id = $this->getAttribute('id');

            $strHtmlSelected = $tab . '<div id="'.$id.'amsSelected">'  . PHP_EOL;

            foreach ($this->_options as $option) {

                $_labelAttributes  = array('style', 'class', 'onmouseover', 'onmouseout');
                $labelAttributes = array();
                foreach ($_labelAttributes as $attr) {
                    if (isset($option['attr'][$attr])) {
                        $labelAttributes[$attr] = $option['attr'][$attr];
                        unset($option['attr'][$attr]);
                    }
                }

                if (is_array($this->_values) && in_array((string)$option['attr']['value'], $this->_values)) {
                    // The items is *selected*
                    $checked = ' checked="checked"';
                } else {
                    // The item is *unselected* so we want to put it
                    $checked = '';
                }
                $strHtmlSelected .= $tab
                                 .  '<label'
                                 .  $this->_getAttrString($labelAttributes) .'>'
                                 .  '<input type="checkbox"'
                                 .  ' name="'.$selectName.'"'
                                 .  $checked
                                 .  $this->_getAttrString($option['attr'])
                                 .  ' />' .  $option['text'] . '</label>'
                                 .  PHP_EOL;
            }
            $strHtmlSelected    .= $tab . '</div>'. PHP_EOL;

            $strHtmlHidden = '';
            $strHtmlUnselected = '';
            $strHtmlAdd = '';
            $strHtmlRemove = '';

        } else {
            // ... or a dual multi-select

            // set name of Select From Box
            $this->_attributesUnselected = array('name' => '__'.$selectName, 'ondblclick' => "{$this->_jsPrefix}{$this->_jsPostfix}(this.form.elements['__" . $selectName . "'], this.form.elements['_" . $selectName . "'], this.form.elements['" . $selectName . "'], 'add')");
            $this->_attributesUnselected = array_merge($this->_attributes, $this->_attributesUnselected);
            $attrUnselected = $this->_getAttrString($this->_attributesUnselected);

            // set name of Select To Box
            $this->_attributesSelected = array('name' => '_'.$selectName, 'ondblclick' => "{$this->_jsPrefix}{$this->_jsPostfix}(this.form.elements['__" . $selectName . "'], this.form.elements['_" . $selectName . "'], this.form.elements['" . $selectName . "'], 'remove')");
            $this->_attributesSelected = array_merge($this->_attributes, $this->_attributesSelected);
            $attrSelected = $this->_getAttrString($this->_attributesSelected);

            // set name of Select hidden Box
            $this->_attributesHidden = array('name' => $selectName, 'style' => 'overflow: hidden; visibility: hidden; width: 1px; height: 0;');
            $this->_attributesHidden = array_merge($this->_attributes, $this->_attributesHidden);
            $attrHidden = $this->_getAttrString($this->_attributesHidden);

            // The 'unselected' multi-select which appears on the left
            $strHtmlUnselected = "<select$attrUnselected>". PHP_EOL;
            // The 'selected' multi-select which appears on the right
            $strHtmlSelected = "<select$attrSelected>". PHP_EOL;
            // The 'hidden' multi-select
            $strHtmlHidden = "<select$attrHidden>". PHP_EOL;

            foreach ($this->_options as $option) {
                if (is_array($this->_values) && in_array((string)$option['attr']['value'], $this->_values)) {
                    // The items is *selected* so we want to put it in the 'selected' multi-select
                    $strHtmlSelected .= $tabs . $tab
                                     . '<option' . $this->_getAttrString($option['attr']) . '>'
                                     . $option['text'] . '</option>' . PHP_EOL;
                    // Add it to the 'hidden' multi-select and set it as 'selected'
                    $strHtmlHidden .= $tabs . $tab
                                   . '<option' . $this->_getAttrString($option['attr'])
                                   . ' selected="selected">'
                                   . $option['text'] . '</option>' . PHP_EOL;
                }
                else {
                    // The item is *unselected* so we want to put it in the 'unselected' multi-select
                    $html = $tabs . $tab
                          . '<option' . $this->_getAttrString($option['attr']) . '>'
                          . $option['text'] . '</option>' . PHP_EOL;
                    $strHtmlUnselected .= $html;
                    // Add it to the hidden multi-select as 'unselected'
                    $strHtmlHidden .= $html;
                }
            }
            $strHtmlSelected   .= '</select>';
            $strHtmlUnselected .= '</select>';
            $strHtmlHidden     .= '</select>';

            // build the remove button with all its attributes
            $attributes = array('onclick' => "{$this->_jsPrefix}{$this->_jsPostfix}(this.form.elements['__" . $selectName . "'], this.form.elements['_" . $selectName . "'], this.form.elements['" . $selectName . "'], 'remove'); return false;");
            $this->_removeButtonAttributes = array_merge($this->_removeButtonAttributes, $attributes);
            $attrStrRemove = $this->_getAttrString($this->_removeButtonAttributes);
            $strHtmlRemove = "<input $attrStrRemove />". PHP_EOL;

            // build the add button with all its attributes
            $attributes = array('onclick' => "{$this->_jsPrefix}{$this->_jsPostfix}(this.form.elements['__" . $selectName . "'], this.form.elements['_" . $selectName . "'], this.form.elements['" . $selectName . "'], 'add'); return false;");
            $this->_addButtonAttributes = array_merge($this->_addButtonAttributes, $attributes);
            $attrStrAdd = $this->_getAttrString($this->_addButtonAttributes);
            $strHtmlAdd = "<input $attrStrAdd />". PHP_EOL;
        }

        // render all part of the multi select component with the template
        $strHtml = $this->_elementTemplate;

        // Prepare multiple labels
        $labels = $this->getLabel();
        if (is_array($labels)) {
            array_shift($labels);
        }
        // render extra labels, if any
        if (is_array($labels)) {
            foreach($labels as $key => $text) {
                $key  = is_int($key)? $key + 2: $key;
                $strHtml = str_replace("{label_{$key}}", $text, $strHtml);
                $strHtml = str_replace("<!-- BEGIN label_{$key} -->", '', $strHtml);
                $strHtml = str_replace("<!-- END label_{$key} -->", '', $strHtml);
            }
        }
        // clean up useless label tags
        if (strpos($strHtml, '{label_')) {
            $strHtml = preg_replace('/\s*<!-- BEGIN label_(\S+) -->.*<!-- END label_\1 -->\s*/i', '', $strHtml);
        }

        $placeHolders = array(
            '{stylesheet}', '{javascript}', '{class}',
            '{unselected}', '{selected}',
            '{add}', '{remove}'
        );
        $htmlElements = array(
            $this->getElementCss(false), $this->getElementJs(false), $this->_tableAttributes,
            $strHtmlUnselected, $strHtmlSelected . $strHtmlHidden,
            $strHtmlAdd, $strHtmlRemove
        );

        $strHtml = str_replace($placeHolders, $htmlElements, $strHtml);

        return $strHtml;
    }

    /**
     * Returns the javascript code generated to handle this element
     *
     * @access     private
     * @return     string
     */
    function getElementJs($raw = true)
    {
        $js = '';
        $jsfuncName = $this->_jsPrefix . $this->_jsPostfix;
        if (!defined('HTML_QUICKFORM_ADVMULTISELECT_'.$jsfuncName.'_EXISTS')) {
             // We only want to include the javascript code once per form
            define('HTML_QUICKFORM_ADVMULTISELECT_'.$jsfuncName.'_EXISTS', true);

            $js .= "
/* begin javascript for HTML_QuickForm_advmultiselect */
function {$jsfuncName}(selectLeft, selectRight, selectHidden, action) {
    if (action == 'add') {
        menuFrom = selectLeft;
        menuTo = selectRight;
    }
    else {
        menuFrom = selectRight;
        menuTo = selectLeft;
    }
    // Don't do anything if nothing selected. Otherwise we throw javascript errors.
    if (menuFrom.selectedIndex == -1) {
        return;
    }

    // Add items to the 'TO' list.
    for (i=0; i < menuFrom.length; i++) {
        if (menuFrom.options[i].selected == true ) {
            menuTo.options[menuTo.length]= new Option(menuFrom.options[i].text, menuFrom.options[i].value);
        }
    }

    // Remove items from the 'FROM' list.
    for (i = (menuFrom.length - 1); i>=0; i--){
        if (menuFrom.options[i].selected == true ) {
            menuFrom.options[i] = null;
        }
    }

    // Unselect all options in the hidden select.
    for (i=0; i < selectHidden.length; i++) {
        selectHidden.options[i].selected = false;
    }

    // Set the appropriate items as 'selected in the hidden select.
    // These are the values that will actually be posted with the form.
    for (i=0; i < selectRight.length; i++) {
        selectHidden.options[selectHidden.length] = new Option(selectRight.options[i].text, selectRight.options[i].value);
        selectHidden.options[selectHidden.length-1].selected = true;
    }
}
/* end javascript for HTML_QuickForm_advmultiselect */
";

            if ($raw !== true) {
                $js = '<script type="text/javascript">' . PHP_EOL
                    . '//<![CDATA[' . $js . '//]]>'     . PHP_EOL
                    . '</script>';
            }
        }
        return $js;
    }
}

if (class_exists('HTML_QuickForm')) {
    HTML_QuickForm::registerElementType('advmultiselect', 'HTML/QuickForm/advmultiselect.php', 'HTML_QuickForm_advmultiselect');
}
?>