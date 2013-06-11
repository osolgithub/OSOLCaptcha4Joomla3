<?php
//http://osol1/pjtg/joomla25rets/public_html/plugins/system/osolcaptcha/captchaPreview.php?osolcaptcha_imageFunction=Adv&osolcaptcha_font_ttf=BookmanOldStyle.TTF&osolcaptcha_font_size=48&osolcaptcha_bgColor=%232c8007&osolcaptcha_textColor=%23ffffff&white_noise_density=.2&black_noise_density=.2&osolcaptcha_symbolsToUse=ABCDEFGHJKLMNPQRSTWXYZ23456789
$adminIndexRelativePath = "/../../../administrator/index.php";
$adminIndexpath = realpath(dirname(__FILE__)).$adminIndexRelativePath;
//die($adminIndexpath);
ob_start();
require_once($adminIndexpath);
    $user = JFactory::getUser();
    $isAdmin = $user->get('isRoot');
    ob_end_clean(); 
    if ($isAdmin) {
		
		require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'OSOLmulticaptcha.php');
		$captcha = new OSOLmulticaptcha();
		$captcha->displayCaptcha();
    }
	else
	{
		//die(JURI::base()."/..".$adminIndexRelativePath);
		header("location:".JURI::base()."/..".$adminIndexRelativePath);
	}
//ob_end_flush();

?>