<?php
defined('_JEXEC') or die();
if($isEnabledForForms['enableForContactUs'])
			{
				$this->enabledForms['Core Joomla Contact Us']  = array('requestVars' => 'option=com_contact&view=contact|contact.submit',
																		 'formId' => "contact-form",//if there is no name use formName
																		 'tagToPlaceCaptchaBefore' =>'<button class="btn btn-primary validate" type="submit">',
																		 'verifyOnVars' =>'option=com_contact&task=contact.submit',
																		 //'redirectOnfailure' =>JURI::base() ,//JFactory::getURI()->toString(),
																		 'skipAJAXVerification' => false,
																		 'onCaptchaFailSetVars' =>'view=contact&task='
																		);
			}
			if($isEnabledForForms['enableForRegistration'])
			{
				$this->enabledForms['Core Joomla Registration']  = array('requestVars' => 'option=com_users&view=registration',
																 'formId' => "member-registration",//if there is no name use formName 
																 'tagToPlaceCaptchaBefore' =>'<button type="submit" class="btn btn-primary validate">',
																 'verifyOnVars' =>'option=com_users&task=registration.register',
																 //'redirectOnfailure' =>JFactory::getURI()->toString(),
																 'skipAJAXVerification' => false,
																 'onCaptchaFailSetVars' =>'view=registration&task='
																);
			}
			if($isEnabledForForms['enableForRemind'])
			{
				$this->enabledForms['Core Joomla remind username'] = array('requestVars' => 'option=com_users&view=remind',
																 'formId' => "user-registration",//if there is no name use formName 
																 'tagToPlaceCaptchaBefore' =>'<button type="submit" class="btn btn-primary validate">',
																 'verifyOnVars' =>'option=com_users&task=remind.remind',
																 //'redirectOnfailure' =>JFactory::getURI()->toString(),
																 'skipAJAXVerification' => false,
																 'onCaptchaFailSetVars' =>'view=remind&task='
																);
			}
			if($isEnabledForForms['enableForReset'])
			{
				$this->enabledForms['Core Joomla reset password'] = array('requestVars' => 'option=com_users&view=reset',
																 'formId' => "user-registration",//if there is no name use formName 
																 'tagToPlaceCaptchaBefore' =>'<button type="submit" class="btn btn-primary validate">',
																 'verifyOnVars' =>'option=com_users&task=reset.request',
																 //'redirectOnfailure' =>JFactory::getURI()->toString(),
																 'skipAJAXVerification' => false,
																 'onCaptchaFailSetVars' =>'view=reset&task='
																);
			}
			if($isEnabledForForms['enableForComLogin'] && 0)
			{
				$this->enabledForms['Core Joomla login Module'] = array('requestVars' => '*',
																		 'formId' => "login-form",//if there is no name use formName
																		 'ignore_condition' => 'task=user.logout',
																		 'tagToPlaceCaptchaBefore' =>'<button type="submit" tabindex="0" name="Submit" class="btn btn-primary">',
																		 'verifyOnVars' =>'option=com_users&task=user.login',
																		 'redirectOnfailure' =>JURI::base()."index.php/login" ,//JFactory::getURI()->toString(),
																		 'skipAJAXVerification' => false,
																		 //'onCaptchaFailSetVars' =>'view=users&task='
																		 'isVertical' =>  true,
																		) ;
				$this->enabledForms['Core Joomla login Component Form'] = array('requestVars' => 'option=com_users&view=login',
																		 'formaction_regExp' => $this->createFormActionRegexp('task=user.login'),//since the form has no id or name use action regexp here
																		 //'no-id-form-ref-field' => 'task=user.login',//'task=search',//
																		 'ignore_condition' => 'task=user.logout',
																		 'tagToPlaceCaptchaBefore' =>'<button type="submit" class="btn btn-primary">',
																		 'verifyOnVars' =>'option=com_users&task=user.login',
																		 'redirectOnfailure' =>JURI::base()."index.php/login" ,//JFactory::getURI()->toString(),
																		 'skipAJAXVerification' => false,
																		 //'onCaptchaFailSetVars' =>'view=users&task='
																		 'isVertical' =>  false,
																		) ;
			}
?>