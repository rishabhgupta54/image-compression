<?php
$raw_directory = __DIR__ . '/raw';
$compress_directory = __DIR__ . '/compress';
$quality = 70;

if (file_exists($compress_directory) === FALSE) {
    mkdir($compress_directory);
}

function get_files_in_directory($directory_path, $compress_directory, $quality) {
    $current_raw_path = $directory_path;
    $current_compress_path = str_replace('raw', 'compress', $directory_path);

    if (file_exists($current_compress_path) === FALSE) {
        mkdir($current_compress_path);
    }

    if (file_exists($directory_path)) {
        if (is_dir($directory_path)) {
            foreach (scandir($directory_path) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_dir($current_raw_path . '/' . $file)) {
                    get_files_in_directory($current_raw_path . '/' . $file, $current_compress_path, $quality);
                } else {
                    image_compress($current_raw_path . '/' . $file, $current_compress_path . '/' . $file, $quality);
                }
            }
        }
    }
}

function image_compress($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg'):
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif'):
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png'):
        $image = imagecreatefrompng($source);
    endif;
    imagejpeg($image, $destination, $quality);

    return $destination;
}

get_files_in_directory($raw_directory, $compress_directory, $quality);
