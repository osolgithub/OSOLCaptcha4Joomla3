<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
jimport('joomla.form.formfield');
class JFormFieldjsforadmipassphrase extends JFormField 
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	
	protected $type = 'jsforadmipassphrase';
	
	protected function getInput()//function fetchElement($name, $value, &$node, $control_name)
	{
			
			JHTML::_('behavior.framework',true);
			JHTML::_('behavior.modal');
			$uncompressed = JFactory::getConfig()->get('debug') ? '-uncompressed' : '';
			//JHTML::_('script','system/modal'.$uncompressed.'.js', true, true);
			//JHTML::_('stylesheet','media/system/css/modal.css');
		
		$elementData = "
					
					<script>
						var origPassPhrase = '';
						var newPassPhrase =  '';
						function showOSOLCaptchaAdvancedOptions()
						{
							
							SqueezeBox.fromElement(document.getElementById('adminPassPhraseConfirmLink'));
							setTimeout(showAdvancedImageOptions,1000);
						}
						function showAdvancedImageOptions()
						{
							new_content = 'testing';
							var iframes = document.getElementById('sbox-window').getElementsByTagName(\"iframe\");
							//alert();
							var iframe = iframes[0];
							iframe.contentWindow.document.open()
							//alert(new_content);
							iframe.contentWindow.document.write(new_content);
						}
						function switchAdvancedOptionsLink()
						{
							var imageTypeSelector = $('jform_params_imageFunction');
							var imageType = imageTypeSelector.get(\"value\");
							if(imageType != 'Adv')
							{
								//alert(imageType);
								$('link_to_advanced_osol_options').setStyle('display','none');
							}
							else
							{
								$('link_to_advanced_osol_options').setStyle('display','block');
							}
							
						}
						function getPassPhrase()
						{
							origPassPhrase = document.getElementById('jform_params_adminPassPhrase').value;
							document.getElementById('jform_params_adminPassPhrase').onblur=alertPassPhraseChange
							 //alert(origPassPhrase);
							 
							 /*var imageTypeSelector = $('jform_params_imageFunction');
							 
							 link_to_advanced_osol_options = new Element('div#link_to_advanced_osol_options');
							 link_to_advanced_osol_options.setStyle('float','left');
							 link_to_advanced_osol_options.setStyle('padding-top','5px');
							
							 link_to_advanced_osol_options.set('html','<a href=\"javascript:showOSOLCaptchaAdvancedOptions()\">More Adanced Options</a>');
							 imageTypeSelector.getParent('li').adopt(link_to_advanced_osol_options,'after');
							 imageTypeSelector.addEvent('change',function(event){switchAdvancedOptionsLink()});
							 switchAdvancedOptionsLink();*/
							
						}
						function alertPassPhraseChange()
						{
							var adminPassPhraseField = document.getElementById('jform_params_adminPassPhrase');
							newPassPhrase = adminPassPhraseField.value;
							if(origPassPhrase != newPassPhrase && newPassPhrase != '')
							{
								//alert('Pass Phrase Changed');
								if(!confirm(\"You have altered \'ADMIN PASS PHRASE\'.\\nThis change  will alter URL of admin side of this site.\\nIE AFTER YOU SAVE THE NEW \'ADMIN PASS PHRASE\', ADMIN URL WILL BE\\n\\n ".JURI::base()."?osolPP=\" + newPassPhrase +\" \\n\\nClick 'cancel' if you haven't understood this\"))
								{
								  adminPassPhraseField.value = origPassPhrase;
								 
								}
								else
								{
									 showModal(document.getElementById('adminPassPhraseConfirmLink'));
								}
							}
						}
						function showModal(aObj)
					   {
							//alert(aObj.href);
					  		SqueezeBox.fromElement(aObj);
							setTimeout(showAdminPassPhraseConfirmMessage,1000);
							return false;
					   }
					   function resetOSOLPassPhrase()
					   {
						   var adminPassPhraseField = document.getElementById('jform_params_adminPassPhrase');
							newPassPhrase = adminPassPhraseField.value;
							adminPassPhraseField.value = origPassPhrase;
							SqueezeBox.close()
					   }
					   function showAdminPassPhraseConfirmMessage()
					   {
						  
						var adminPassPhraseField = document.getElementById('jform_params_adminPassPhrase');
						newPassPhrase = adminPassPhraseField.value;
						//alert(newPassPhrase);
						var new_content = '<span style=\"font-weight:bold;font-size:18px\">You have set a new ADMIN PASS PHRASE.<br />This change  will make it mandatory to use query variable<br /><a href=\"".JURI::base()."/index.php?osolPP=' + newPassPhrase + '\" target=\"_blank\" >".JURI::base()."/index.php?osolPP=' + newPassPhrase + '</a> to access admin side of this site <br />Click \'cancel\' if you haven\'t understood this </span><br />\\n<input type=\"button\" value=\"cancel\" onclick=\"window.parent.resetOSOLPassPhrase()\" /> <input type=\"button\" value=\"OK\" onclick=\"window.parent.SqueezeBox.close();\" />'
						
						
						//alert(document.getElementById('sbox-window').innerHTML );
						//document.getElementById('sbox-window').innerHTML =\"DDD\"
						var iframes = document.getElementById('sbox-window').getElementsByTagName(\"iframe\");
						//alert();
						var iframe = iframes[0];
						iframe.contentWindow.document.open()
						//alert(new_content);
						iframe.contentWindow.document.write(new_content);
					   }
						window.addEvent( 'domready', getPassPhrase );
						</script>
						
						<a id=\"adminPassPhraseConfirmLink\" href=\"#\" rel=\"{handler: 'iframe', size: {x: 900, y: 500}}\"   style=\"display:none\" >BUHAHAHAHAHA</a>
						";
		return $elementData;
	}
}