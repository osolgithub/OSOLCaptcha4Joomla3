<?php

$this->enabledForms['Virtuemart Registration Form'] = array('requestVars' => 'option=com_virtuemart&page=checkout.index',
																		 'formName' =>"adminForm",
																		 'ignore_condition' => 'task=logout',
																		 'tagToPlaceCaptchaBefore' =>'<input type="submit"',
																		 'verifyOnVars' =>'option=com_virtuemart&func=shopperadd',
																		 'redirectOnfailure' =>JURI::base()."?page=checkout.index&option=com_virtuemart" ,//JFactory::getURI()->toString(),
																		 'skipAJAXVerification' => false,
																		 'isVertical' =>  false,
																		) ;

?>