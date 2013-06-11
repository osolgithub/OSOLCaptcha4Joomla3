<?php
defined('_JEXEC') or die();
# OSOLMulticaptcha version 1.0

/* ===================================================
* @author
* Name: Sreekanth Dayanand, www.outsource-online.net
* Email: joomla@outsource-online.net
* Url: http://www.outsource-online.net
* ===================================================
* @copyright (C) 2012,2013 Sreekanth Dayanand, Outsource Online (www.outsource-online.net). All rights reserved.
* @license see http://www.gnu.org/licenses/gpl-2.0.html  GNU/GPL.
* You can use, redistribute this file and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation.
*If you use this software as a part of own sofware, you must leave copyright notices intact or add OSOLMulticaptcha copyright notices to own.
*/

# System requirements: PHP 5.3.1 + w/ GD
# Open  previewCaptcha.php in browser for customization
/*
//simplest way to show captcha
$captcha = new OSOLmulticaptcha();
$captcha->displayCaptcha();*/
class OSOLmulticaptcha{
	
	var $imageFunction = "Adv";
	var $font_size = 36;
	var $font_ttf  = 'AdLibBT.TTF';
	var $bgColor = "#2c8007";
	var $textColor = "#ffffff";
	
	var $symbolsToUse = "ABCDEFGHJKLMNPQRTWXY346789";//"234789acdeghklmnpqrwxyz";
	var $fluctuation_amplitude = 4;
	var $white_noise_density = 0;
	var $black_noise_density = 0;
	
	var $captchaLength = 5;
	
	var $fontPNGFile = "font-png.png";
	var $DS = "/";
	var $fontPNGLocation = "";
	var $fontMetaFile = 'fontFileMeta.meta';
	
	
	
	function __construct()
	{
		
		$imageFunction = 'create_image'.((isset($_REQUEST['osolcaptcha_imageFunction']) && $_REQUEST['osolcaptcha_imageFunction'] !='')?$_REQUEST['osolcaptcha_imageFunction']:$this->imageFunction);
		$this->imageFunction = ((!method_exists($this,$imageFunction)))?'create_imageAdv':$imageFunction;
		
		$this->DS = DIRECTORY_SEPARATOR;
		$this->fontPNGLocation = dirname(__FILE__).$this->DS.'osolCaptcha';//dirname(__FILE__).$this->DS.'utils';
		$font_ttf  = $this->fontPNGLocation.$this->DS.'ttfs'.$this->DS.((isset($_REQUEST['osolcaptcha_font_ttf']) && $_REQUEST['osolcaptcha_font_ttf'] !='')?$_REQUEST['osolcaptcha_font_ttf']:$this->font_ttf);
		 $this->fontPNGFile = (isset($_REQUEST['previewCaptcha']) && $_REQUEST['previewCaptcha'] == 'True')?'temp.png':$this->fontPNGFile;
		 $this->fontMetaFile = (isset($_REQUEST['previewCaptcha']) && $_REQUEST['previewCaptcha'] == 'True')?'temp.meta':$this->fontMetaFile;
		 $this->font_ttf = file_exists($font_ttf) && !is_dir($font_ttf)?$font_ttf:$this->font_ttf;
		 $this->font_size  = (isset($_REQUEST['osolcaptcha_font_size']) && $_REQUEST['osolcaptcha_font_size'] !='')?$_REQUEST['osolcaptcha_font_size']:$this->font_size;
	
		$this->bgColor  = (isset($_REQUEST['osolcaptcha_bgColor']) && $_REQUEST['osolcaptcha_bgColor'] !='')?$_REQUEST['osolcaptcha_bgColor']:$this->bgColor;
		$this->textColor  = (isset($_REQUEST['osolcaptcha_textColor']) && $_REQUEST['osolcaptcha_textColor'] !='')?$_REQUEST['osolcaptcha_textColor']:$this->textColor;
		
		
		
		
		$this->fluctuation_amplitude = (isset($_REQUEST['osol_fluctuation']) && $_REQUEST['osol_fluctuation'] != '')?$_REQUEST['osol_fluctuation']:$this->fluctuation_amplitude;
		$this->white_noise_density=(isset($_REQUEST['white_noise_density']) && $_REQUEST['white_noise_density'] != '')?$_REQUEST['white_noise_density']:$this->white_noise_density; // no white noise
		//$white_noise_density=1/6;
		$this->black_noise_density=(isset($_REQUEST['black_noise_density']) && $_REQUEST['black_noise_density'] != '')?$_REQUEST['black_noise_density']:$this->black_noise_density; // no black noise
		
		$this->symbolsToUse = ((isset($_REQUEST['osolcaptcha_symbolsToUse']) && $_REQUEST['osolcaptcha_symbolsToUse'] !='')?$_REQUEST['osolcaptcha_symbolsToUse']:$this->symbolsToUse);
		
		
		

	
	}
	function displayCaptcha()
	{
		
		$imageFunction = $this->imageFunction;
		set_time_limit(1000);
		if($imageFunction == 'create_imageAdv')
		{
			$this->callCreateAlphaImageForDistorted();
		}
		$this->$imageFunction();
		return $this->keystring;
	}
	
	function createKeyString()
	{
		$allowed_symbols = $this->symbolsToUse;
		while(true){
				$this->keystring='';
				for($i=0;$i<$this->captchaLength;$i++){
					$this->keystring.=$allowed_symbols{mt_rand(0,strlen($allowed_symbols)-1)};
				}
				if(!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $this->keystring)) break;
			}
	}
	function callCreateAlphaImageForDistorted()
	{
		// Example usage - gif image output
		$alphabet = $this->symbolsToUse;
		
		$alphabet =  implode(" ",str_split($alphabet));
		$text_string    = $alphabet;
		
		$font_ttf = $this->font_ttf;
		
		
		$text_angle        = 0;
		$text_padding    = 20; // Img padding - around text
		$font_size = $this->font_size;
		$fontFileMeta = array(
								'alphabet' => $alphabet,
								'font_ttf' => basename($font_ttf),
								'font_size' => $font_size,
								);
		$fontMetaFile = $this->fontPNGLocation.$this->DS.$this->fontMetaFile;
		if(!file_exists($fontMetaFile) )
		{
			die("missing meta file : ".$fontMetaFile);
		}
		
		$savedfontMeta = unserialize( file_get_contents($fontMetaFile));
		if(!is_array($savedfontMeta) || !isset($savedfontMeta['alphabet'])  || !isset($savedfontMeta['font_ttf'])  || !isset($savedfontMeta['font_size']))
		{
			die("corrupted meta file : ".$fontMetaFile." download the correct one ");
		}
		//die("Saved one <pre>".print_r(unserialize( file_get_contents($fontMetaFile)),true)."</pre><hr />Required one <pre>".print_r($fontFileMeta,true)."</pre>");
		if( $savedfontMeta == $fontFileMeta)
		{
			
			return;
		}
		elseif(!(file_exists($font_ttf) || is_dir($font_ttf)))
		{
			$alphabet = $this->symbolsToUse = $savedfontMeta['alphabet'];
			$font_ttf = $this->font_ttf = $savedfontMeta['font_ttf'];
			$font_size = $this->font_size = $savedfontMeta['font_size'];
			
		}
		
		
		
		file_put_contents ( $fontMetaFile,serialize($fontFileMeta));
		$the_box        = $this->calculateTextBox($text_string, $font_ttf, $font_size, $text_angle);
		
		$imgWidth    = $the_box["width"] + $text_padding*2;
		$imgHeight    = $the_box["height"] + $text_padding*2;
		$img = $image = imagecreatetruecolor($imgWidth,$imgHeight);
		
		$colorBlack =imagecolorallocate($image,0,0,0);
		
		imagealphablending($image, false);
		imagesavealpha($image, true);	
		$transparent = imageColorAllocateAlpha($img, 0, 0, 0, 127);
		imagefilledrectangle($image, 0, 0, $imgWidth-1, $imgHeight-1, $transparent);
		imageAlphaBlending($image, true);       
		imageantialias($image, true);       
		
		
		imagettftext($image,
			$font_size,
			$text_angle,
			$the_box["left"] + ($imgWidth / 2) - ($the_box["width"] / 2),
			$the_box["top"] + ($imgHeight / 2) - ($the_box["height"] / 2) ,
			$colorBlack,
			$font_ttf,
			$text_string);
		imagealphablending($image, false);
		imagesavealpha($image, true);
		//header("content-type: image/png");imagepng($image);imagepng($image,'test.png');imagedestroy($image); exit;
		$font_file = $this->fontPNGLocation.$this->DS.$this->fontPNGFile;
		imagepng($image,$font_file);
		$image =  $this->createAlphaImage();
		imagepng($image,$font_file);
		
	}
	function  createAlphaImage()
	{
		
			$font_file = $this->fontPNGLocation.$this->DS.$this->fontPNGFile;
			$img=imagecreatefrompng($font_file);
			imageAlphaBlending($img, false);
			imageSaveAlpha($img, true);
			$transparent=imagecolorallocatealpha($img,255,255,255,127);
			$white=imagecolorallocate($img,255,255,255);
			$black=imagecolorallocate($img,0,0,0);
			$gray=imagecolorallocate($img,100,100,100);
			
			for($x=0;$x<imagesx($img);$x++){
				$space=true;
				$column_opacity=0;
				for($y=1;$y<imagesy($img);$y++){
					$rgb = ImageColorAt($img, $x, $y);
					$opacity=$rgb>>24;
					if($opacity!=127){
						$space=false;
					}
					$column_opacity+=127-$opacity;
				}
				if(!$space){
					imageline($img,$x,0,$x,0,$column_opacity<200?$gray:$black);
				}
			}
			
			return $img;
		
	   // closedir($handle);
	}
	function validateFontfile($fontFile)
	{
		if(!(file_exists($fontFile) || is_dir($fontFile)))
		{
			die("Missing $fontFile.Cant create captcha without it");
		}
	}
		/************
		simple function that calculates the *exact* bounding box (single pixel precision).
		The function returns an associative array with these keys:
		left, top:  coordinates you will pass to imagettftext
		width, height: dimension of the image you have to create
		*************/
	function calculateTextBox($text,$fontFile,$fontSize,$fontAngle) {
		//die($fontFile);
		$this->validateFontfile($fontFile);
		$rect = imagettfbbox($fontSize,$fontAngle,$fontFile,$text);
		$minX = min(array($rect[0],$rect[2],$rect[4],$rect[6]));
		$maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6]));
		$minY = min(array($rect[1],$rect[3],$rect[5],$rect[7]));
		$maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7]));
	   
		return array(
		 "left"   => abs($minX) - 1,
		 "top"    => abs($minY) - 1,
		 "width"  => $maxX - $minX,
		 "height" => $maxY - $minY,
		 "box"    => $rect
		);
	}
	// generates distorted letters ,this is a revised version of a method used in kcaptcha
	#http://www.phpclasses.org/browse/package/3193.html
		
	# Copyright by Kruglov Sergei, 2006-2013
	# www.captcha.ru, www.kruglov.ru
	
	# System requirements: PHP 4.0.6+ w/ GD
	
	# KCAPTCHA is a free software. You can freely use it for building own site or software.
	# If you use this software as a part of own sofware, you must leave copyright notices intact or add KCAPTCHA copyright notices to own.
	function create_imageAdv(){
		
		
		$alphabet = $this->symbolsToUse;
		$allowed_symbols = $this->symbolsToUse;
		
		$length = $this->captchaLength;
		
		$width = $this->font_size * 5;
		$height = $this->font_size * 2.5;
		$fluctuation_amplitude = $this->fluctuation_amplitude;
		$white_noise_density=$this->white_noise_density; // no white noise
		
		$black_noise_density=$this->black_noise_density; // no black noise
		
		$no_spaces = true;
		
		
		$jpeg_quality = 90;//die($this->bgColor.",".$this->textColor);
		$background_color = $this->HexToRGB($this->bgColor) ;
		$foreground_color = $this->HexToRGB($this->textColor);
	
		$alphabet_length=strlen($alphabet);
		
		do{
			// generating random keystring
			$this->createKeyString();
			$font_file_name = $this->fontPNGFile;
			$font_file = $this->fontPNGLocation.$this->DS.$font_file_name;
			$this->validateFontfile($font_file);
			$font=imagecreatefrompng($font_file);
			imagealphablending($font, true);
			$fontfile_width=imagesx($font);
			$fontfile_height=imagesy($font)-1;
			$font_metrics=array();
			$symbol=0;
			$reading_symbol=false;

			// loading font
			for($i=0;$i<$fontfile_width && $symbol<$alphabet_length;$i++){
				$transparent = (imagecolorat($font, $i, 0) >> 24) == 127;

				if(!$reading_symbol && !$transparent){
					$font_metrics[$alphabet{$symbol}]=array('start'=>$i);
					$reading_symbol=true;
					continue;
				}

				if($reading_symbol && $transparent){
					$font_metrics[$alphabet{$symbol}]['end']=$i;
					$reading_symbol=false;
					$symbol++;
					continue;
				}
			}

			$img=imagecreatetruecolor($width, $height);
			imagealphablending($img, true);
			$foreground_color = $this->HexToRGB($this->textColor);
			$white= imagecolorallocate($img,$foreground_color[0],$foreground_color[1],$foreground_color[2]);//imagecolorallocate($img, 255, 255, 255);
			$black=imagecolorallocate($img,$background_color[0],$background_color[1],$background_color[2]);//imagecolorallocate($img, 0, 0, 0);

			imagefilledrectangle($img, 0, 0, $width-1, $height-1, $white);

			// draw text
			$x=1;
			for($i=0;$i<$length;$i++){
				$m=$font_metrics[$this->keystring{$i}];

				$y=mt_rand(-$fluctuation_amplitude, $fluctuation_amplitude)+($height-$fontfile_height)/2+2;

				if($no_spaces){
					$shift=0;
					if($i>0){
						$shift=10000;
						for($sy=7;$sy<$fontfile_height-20;$sy+=1){
							for($sx=$m['start']-1;$sx<$m['end'];$sx+=1){
				        		$rgb=imagecolorat($font, $sx, $sy);
				        		$opacity=$rgb>>24;
								if($opacity<127){
									$left=$sx-$m['start']+$x;
									$py=$sy+$y;
									if($py>$height) break;
									for($px=min($left,$width-1);$px>$left-12 && $px>=0;$px-=1){
						        		$color=imagecolorat($img, $px, $py) & 0xff;
										if($color+$opacity<190){
											if($shift>$left-$px){
												$shift=$left-$px;
											}
											break;
										}
									}
									break;
								}
							}
						}
						if($shift==10000){
							$shift=mt_rand(4,6);
						}

					}
				}else{
					$shift=1;
				}
				imagecopy($img, $font, $x-$shift, $y, $m['start'], 1, $m['end']-$m['start'], $fontfile_height);
				$x+=$m['end']-$m['start']-$shift;
			}
		}while($x>=$width-10); // while not fit in canvas

		//noise
		
		for($i=0;$i<(($height-30)*$x)*$white_noise_density;$i++){
			imagesetpixel($img, mt_rand(0, $x-1), mt_rand(10, $height-15), $black);
		}
		for($i=0;$i<(($height-30)*$x)*$black_noise_density;$i++){
			imagesetpixel($img, mt_rand(0, $x-1), mt_rand(10, $height-15), $white);
		}
		

		$center=$x/2;

		
		$img2=imagecreatetruecolor($width, $height);
		$foreground=imagecolorallocate($img2, $foreground_color[0], $foreground_color[1], $foreground_color[2]);
		$background=imagecolorallocate($img2, $background_color[0], $background_color[1], $background_color[2]);
		imagefilledrectangle($img2, 0, 0, $width-1, $height-1, $background);		
		imagefilledrectangle($img2, 0, $height, $width-1, $height+12, $foreground);
		

		// periods
		$rand1=mt_rand(750000,1200000)/10000000;
		$rand2=mt_rand(750000,1200000)/10000000;
		$rand3=mt_rand(750000,1200000)/10000000;
		$rand4=mt_rand(750000,1200000)/10000000;
		// phases
		$rand5=mt_rand(0,31415926)/10000000;
		$rand6=mt_rand(0,31415926)/10000000;
		$rand7=mt_rand(0,31415926)/10000000;
		$rand8=mt_rand(0,31415926)/10000000;
		// amplitudes
		$rand9=mt_rand(330,420)/110;
		$rand10=mt_rand(330,450)/110;

		//wave distortion

		for($x=0;$x<$width;$x++){
			for($y=0;$y<$height;$y++){
				$sx=$x+(sin($x*$rand1+$rand5)+sin($y*$rand3+$rand6))*$rand9-$width/2+$center+1;
				$sy=$y+(sin($x*$rand2+$rand7)+sin($y*$rand4+$rand8))*$rand10;

				if($sx<0 || $sy<0 || $sx>=$width-1 || $sy>=$height-1){
					continue;
				}else{
					$color=imagecolorat($img, $sx, $sy) & 0xFF;
					$color_x=imagecolorat($img, $sx+1, $sy) & 0xFF;
					$color_y=imagecolorat($img, $sx, $sy+1) & 0xFF;
					$color_xy=imagecolorat($img, $sx+1, $sy+1) & 0xFF;
				}

				if($color==255 && $color_x==255 && $color_y==255 && $color_xy==255){
					continue;
				}else if($color==0 && $color_x==0 && $color_y==0 && $color_xy==0){
					$newred=$foreground_color[0];
					$newgreen=$foreground_color[1];
					$newblue=$foreground_color[2];
				}else{
					$frsx=$sx-floor($sx);
					$frsy=$sy-floor($sy);
					$frsx1=1-$frsx;
					$frsy1=1-$frsy;

					$newcolor=(
						$color*$frsx1*$frsy1+
						$color_x*$frsx*$frsy1+
						$color_y*$frsx1*$frsy+
						$color_xy*$frsx*$frsy);

					if($newcolor>255) $newcolor=255;
					$newcolor=$newcolor/255;
					$newcolor0=1-$newcolor;

					$newred=$newcolor0*$foreground_color[0]+$newcolor*$background_color[0];
					$newgreen=$newcolor0*$foreground_color[1]+$newcolor*$background_color[1];
					$newblue=$newcolor0*$foreground_color[2]+$newcolor*$background_color[2];
				}

				imagesetpixel($img2, $x, $y, imagecolorallocate($img2, $newred, $newgreen, $newblue));
			}
		}
		//die($this->keystring);
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
		header('Cache-Control: no-store, no-cache, must-revalidate'); 
		header('Cache-Control: post-check=0, pre-check=0', FALSE); 
		header('Pragma: no-cache');
		
		if(function_exists("imagejpeg")){
			header("Content-Type: image/jpeg");
			imagejpeg($img2, null, $jpeg_quality);
		}else if(function_exists("imagegif")){
			header("Content-Type: image/gif");
			imagegif($img2);



		}else if(function_exists("imagepng")){
			header("Content-Type: image/x-png");
			imagepng($img2);
		}
		
		
		$this->storeKeyString();
		
		
	}
	function storeKeyString()
	{
		//$keyStringFile = $this->fontPNGLocation.$this->DS.'keystring.txt';$fp = fopen($keyStringFile,'w');fwrite($fp,$this->keystring);fclose($fp);
	}
	// generates plain letters
	function create_imagePlane()
	{

		$length = 5;
		$allowed_symbols = $this->symbolsToUse;
		// generating random keystring
		$this->createKeyString();
			
		
		$width = $this->font_size * 5;
		$height = $this->font_size * 2.5;
		
		$image = imagecreate($width, $height);  
		//$this->setColors();
		$foreground_color = $this->HexToRGB($this->textColor);
		$background_color = $this->HexToRGB($this->bgColor) ;
		//We are making three colors, white, black and gray
		$white = imagecolorallocate ($image, $foreground_color[0],$foreground_color[1],$foreground_color[2]);//255, 255, 255);
		$black = imagecolorallocate ($image,$background_color[0],$background_color[1],$background_color[2]);//44,127,7);// imagecolorallocate ($image, 0, 0, 0);
		$grey = imagecolorallocate ($image, 204, 204, 204);
		
		//Make the background black 
		imagefill($image, 0, 0, $black); 
		
		$size = ceil($this->font_size/2);
		$this->ly = (int)(4.4 * $size);
		$x = ceil($size/2);//20;
		for($i=0;$i<strlen($this->keystring);$i++)
		{
			
			$angle = rand(-45,45);
			$y        = intval(rand((int)($size * 1.5), (int)($this->ly - ($size / 7))));
			
			@imagettftext($image, $size, $angle, $x + (int)($size / 15), $y, $white, $this->font_ttf, $this->keystring[$i]);
			
			//noise
		$white_noise_density=$this->white_noise_density; 
		
		$black_noise_density=$this->black_noise_density;
		//$this->calculateTextBox($this->keystring[$i],$this->font_ttf,$size, $angle);//left,top,widht,height
		for($i2=0;$i2<(($height-30)*$x)*$white_noise_density/4;$i2++){
			imagesetpixel($image, mt_rand(0, $width), mt_rand(10, $height-15), $white);
		}
		for($i2=0;$i2<(($height-30)*$x)*$black_noise_density/4;$i2++){
			imagesetpixel($image, mt_rand(0, $width), mt_rand(10, $height-15), $black);
		}
			$x += ($size *2);
		}
		
		header('Content-type: image/png');
		imagepng($image);
		
		$this->storeKeyString();
	}	
		function HexToRGB($hex) {
			$hex = preg_replace("/#/", "", $hex);
			$color = array();
			
			if(strlen($hex) == 3) {
				$color['r'] = hexdec(substr($hex, 0, 1) . $r);
				$color['g'] = hexdec(substr($hex, 1, 1) . $g);
				$color['b'] = hexdec(substr($hex, 2, 1) . $b);
			}
			else if(strlen($hex) == 6) {
				$color['r'] = hexdec(substr($hex, 0, 2));
				$color['g'] = hexdec(substr($hex, 2, 2));
				$color['b'] = hexdec(substr($hex, 4, 2));
			}
			
			return array_values($color);
		}
	
		function RGBToHex($r, $g, $b) {
			$hex = "#";
			$hex.= dechex($r);
			$hex.= dechex($g);
			$hex.= dechex($b);
			
			return $hex;
		}
}
?>