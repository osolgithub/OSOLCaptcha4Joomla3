<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
jimport('joomla.form.formfield');
class JFormFieldpreviewcaptchawithsettings extends JFormField 
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	
	protected $type = 'previewcaptchawithsettings';
	
	protected function getInput()//function fetchElement($name, $value, &$node, $control_name)
	{
			
			JHTML::_('behavior.framework',true);
			JHTML::_('behavior.modal');
			$uncompressed = JFactory::getConfig()->get('debug') ? '-uncompressed' : '';
			//JHTML::_('script','system/modal'.$uncompressed.'.js', true, true);
			//JHTML::_('stylesheet','media/system/css/modal.css');
		
		$enabled = JPluginHelper::isEnabled('system', 'osolcaptcha');
		//echo ($enabled?"ENABLED":"DISABLED")."<br />";
		//JURI::base()."../index.php?showCaptcha=True&instanceNo=0
		$elementData = "
					
					<script>
						function previewOSOLCaptcha(e,text){
							var image = new Image();
							image.onload = function() { // always fires the event.
								document.getElementById('ToolTip').innerHTML=  text;
							};
							image.src = getOSOSLCaptchaPreviewImageURL();
							//alert(e.clientX+20+document.body.scrollLeft + \" : \" + e.clientY+document.body.scrollTop);
							ajaxLoaderURL = '".JURI::base()."../plugins/system/osolcaptcha/osolCaptcha/ajax-loader-big.gif';
							document.getElementById('ToolTip').innerHTML=  '<div><img src=\"'+ajaxLoaderURL+'\" style=\"float:left\" /></div><div>Please wait while captcha preview is loaded</div>';
							/*ToolTip.style.pixelLeft=(e.clientX+20+document.body.scrollLeft);
							ToolTip.style.pixelTop=(e.clientY+document.body.scrollTop);
							ToolTip.style.left = '100px';
							ToolTip.style.top = '-100px';*/
							ToolTip.style.visibility=\"visible\";
							//alert(e.clientY);
							ToolTip.style.left = (e.clientX)+'px';
							ToolTip.style.top = (e.clientY-($('jform_params_letterSize').value * 3)) + 'px';
							//alert(ToolTip.style.left  + \" : \"  + ToolTip.style.top  + ' : ' + ToolTip.style.visibility);
						}
						function hidePreviewOSOLCaptcha(){
							ToolTip.style.visibility=\"hidden\";
						}
						function getOSOSLCaptchaPreviewImageURL()
						{
							formFieldPrefix = 'jform_params_'
							var formFields = {bgColor:'osolcaptcha_bgColor',textColor:'osolcaptcha_textColor',allowedSymbols:'osolcaptcha_symbolsToUse',imageFunction:'osolcaptcha_imageFunction',fontFile:'osolcaptcha_font_ttf',white_noise_density:'white_noise_density',black_noise_density:'black_noise_density',letterSize:'osolcaptcha_font_size'}
						
							qVars = 'previewCaptcha=True&';
							for(var i in formFields)
							{
								qVars = qVars +formFields[i]+'='+encodeURIComponent($(formFieldPrefix+i).value)+'&';
							}
							return imageURL = '".JURI::base()."../plugins/system/osolcaptcha/captchaPreview.php?'+qVars;;
						}
						function OSOLCaptchPreviewHTML()
						{
							imageURL = getOSOSLCaptchaPreviewImageURL();
							
						//previewCaptcha=True&osolcaptcha_imageFunction=Adv&osolcaptcha_font_ttf=BookmanOldStyle.TTF&osolcaptcha_font_size=72&osolcaptcha_bgColor=%232c8007&osolcaptcha_textColor=%23ffffff&white_noise_density=.2&black_noise_density=.2&osolcaptcha_symbolsToUse=ABCDEFGHJKLMNPQRSTWXYZ23456789
							return  '<img src=\"'+imageURL+'\" style=\"float:left\" />';
						}
						</script>
						<style>
						#ToolTip {
						  position:fixed;
						 
						  visibility:hidden;
						   z-index:10000;
						  background-color:#dee7f7;
						  border:1px solid #337;
						  width:auto; padding:4px;
						  height:auto;
						  color:#000; font-size:11px; line-height:1.3;
						  font-family:verdana;
						}
						</style>
						
						
						
						
						
						<span  onmouseover=\"javascript:previewOSOLCaptcha(event,OSOLCaptchPreviewHTML())\" onmouseout=\"javascript:hidePreviewOSOLCaptcha()\" style=\"float:left\"> Hover Mouse here to preview Captcha with entered settings </span>
						<p></p>
						<div id=\"ToolTip\"></div> 
						";
		
		return $elementData;
	}
}