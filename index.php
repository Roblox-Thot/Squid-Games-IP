<?php
function createImage(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // (A) OPEN IMAGE
    $img = imagecreatefrompng('image0.png');

    // (B) WRITE TEXT
    $white = imagecolorallocate($img, 0, 0, 0);
    $txt = $ip;
    $font = "C:\Windows\Fonts\arial.ttf"; 

    // THE IMAGE SIZE
    $width = imagesx($img);
    $height = imagesy($img);

    // THE TEXT SIZE
    $text_size = imagettfbbox(24, 0, $font, $txt);
    $text_width = max([$text_size[2], $text_size[4]]) - min([$text_size[0], $text_size[6]]);
    $text_height = max([$text_size[5], $text_size[7]]) - min([$text_size[1], $text_size[3]]);

    // CENTERING THE TEXT BLOCK
    $centerX = CEIL(($width - $text_width) / 2);
    $centerX = $centerX<0 ? 0 : $centerX;
    $centerY = 55;
    $centerY = $centerY<0 ? 0 : $centerY;
    imagettftext($img, 24, 0, $centerX, $centerY, $white, $font, $txt);

    // (C) OUTPUT IMAGE

    //imagepng($img, "SAVE.PNG");

    // (C) OUTPUT IMAGE
    header('Content-type: image/png');
    imagepng($img);
    imagedestroy($img);
}


function CheckUser($header){
	$arr = array('DiscordBot', 'Discordbot', '+https://discordapp.com', 'electron', 'discord', 'Firefox/92.0');
	foreach ($arr as &$value) {
		if (strpos($header, $value) !== false){
	    	return true;
		}
	}
	return false;
}

function GiveFile($file){
	if (file_exists($file))
	{
	    $size = getimagesize($file);

	    $fp = fopen($file, 'rb');

	    if ($size and $fp)
	    {
	        header('Content-Type: '.$size['mime']);
	        header('Content-Length: '.filesize($file));

	        fpassthru($fp);

	        exit;
	    }
	}
}

if (CheckUser($_SERVER['HTTP_USER_AGENT'])){
	#GiveFile('./image0.gif');
	GiveFile('open.png');
    #header('Location: https://cdn.discordapp.com/attachments/505623794342166538/900574033861550121/open.png', true, 301);
}else{

    // Redirect
    #header('Location: https://i.imgur.com' . $_SERVER['REQUEST_URI'], true, 301);
    createImage();
}