<?php
//http://docs.joomla.org/Creating_a_custom_form_field_type
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
jimport('joomla.form.formfield');
class JFormFieldnondefaultforms extends JFormField 
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	
	protected $type = 'nondefaultforms';
	 
	 
	// getLabel() left out
 
	
	
	public function getInput()//$name, $value, &$node, $control_name)
	{
		
		$mosConfig_live_site = str_replace("/administrator/","/",JURI::base());
		$link = "<input type=\"checkbox\" id=\"".$this->id."\" /><a   href=\"".$mosConfig_live_site."/index.php?osolAdminOption=nondefaultforms\" ".
				"target=\"_blank\">Click Here</a>";
		return $link;
	}
	public function getLabel() {
     return '<span style="text-decoration: underline;">' . parent::getLabel() . '</span>';
	}
}