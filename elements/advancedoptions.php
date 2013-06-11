<?php
//http://docs.joomla.org/Creating_a_custom_form_field_type
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
jimport('joomla.form.formfield');
class JFormFieldadvancedoptions extends JFormField 
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	
	protected $type = 'advancedoptions';
	var $loadPanoLightBoxInitiated = false;
	private  function loadShowModalFunction()
	{
		//die("DSDSDS");

  // Load the javascript and css
			/*JHTML::script('joomla.javascript.js', 'includes/js/', false);
			JHTML::script('mootools.js', 'media/system/js/', false);
			JHTML::script('modal.js');
			JHTML::stylesheet('modal.css');
			JHTML::_('behavior.modal');*/
			
			
			JHTML::_('behavior.framework',true);
			$uncompressed = JFactory::getConfig()->get('debug') ? '-uncompressed' : '';
			JHTML::_('script','system/modal'.$uncompressed.'.js', true, true);
			JHTML::_('stylesheet','media/system/css/modal.css');
			if(!$this->loadPanoLightBoxInitiated)
			{
				$this->loadPanoLightBoxInitiated = true;
				$script = "window.addEvent('domready', function() {
				// SqueezeBox.fromElement('testest');
			  });".'
				
				function showOSOLCaptchaModal(aObj)
							{
								
								alert(aObj.href);
								//alert(SqueezeBox);
								//SqueezeBox.initialize({});
								SqueezeBox.fromElement(aObj);
								
								/*var scrollTop = document.documentElement.scrollTop;
								
								if(navigator.userAgent.indexOf("MSIE") > -1 )
								{
									document.location = "#top";
								}*/
								
							
								return false;
							}';
    			$document =& JFactory::getDocument();
    			$document->addScriptDeclaration($script);
				
			}

	}

	protected function getInput()//function fetchElement($name, $value, &$node, $control_name)
	{
		
		$this->loadShowModalFunction();
		//templates/bluestork/images/header/icon-48-plugin.png
		$link = "
				<a id=\"testest\" href=\"".JURI::base()."index.php?osolAdminOption=advancedConfig&format=raw\" ".
				"  rel=\"{handler: 'iframe', size: {x: 600, y: 550}}\" ".
				"onclick=\"return showOSOLCaptchaModal(this);\" >
				Advanced Options
				</a>";
		return $link;
	}
	public function getLabel() {
     return '<span style="text-decoration: underline;">' . parent::getLabel() . '</span>';
	}
}