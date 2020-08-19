<?php

$dir = __DIR__; // current working directory
$dir = $dir . '/Images/'; // Dirctory containg original photos
$compression_directory = __DIR__ . '/Compress/'; // directory containg compressed photos

if(!file_exists($compression_directory)) {
	mkdir($compression_directory);
}

// loop through all the files in directory
if (is_dir($dir)){
	if ($dh = opendir($dir)){
		while (($file = readdir($dh)) !== false){
			if(is_dir($file)) {
				continue;
			}
	  		image_compress($dir . $file, $compression_directory . $file, 70	);
		}
		closedir($dh);
	}
}

// to compress the files
function image_compress($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg'): 
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif'): 
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png'):
        $image = imagecreatefrompng($source);
    endif;
    return $destination;
}
