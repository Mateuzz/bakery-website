<?php

function escapeDir($path) {
    return strtolower(preg_replace("[^A-Za-z0-9]", "", $path));
}

function escapeFilename($path) {
    return strtolower(preg_replace("[^A-Za-z0-9]", "", $path));
}

function removeExtension($name) {
    $dotPos = strrpos($name, ".");
    return $dotPos ? substr($name, 0, $dotPos) : $name;
}

function userInput($input) {
    $input = stripslashes($input);
    $input = strip_tags($input);
    return htmlspecialchars($input);
}

function getImageExtension($imgPath) {
    $finfo = finfo_open(FILEINFO_EXTENSION);
    if (!$finfo)
        return false;

    $ext = finfo_file($finfo, $imgPath);
    if (!$ext)
        return false;

    // jpeg/jpg/jpe/jgif becomes jpeg
    return preg_replace("/\/.*/", "", $ext); 
}

function getImgLink($img) {
    if ($img) {
        $imgDir = IMAGES_PATH_MKDIR;
        $imgDirLink = IMAGES_PATH;

        if (!is_dir($imgDir)) {
            mkdir($imgDir);
        }
    
        $ext = getImageExtension($img['tmp_name']);

        if ($ext) {
            $imgName = removeExtension(escapeFilename($img['name'])) . ".$ext";
            $imgFullPath = "$imgDir/$imgName";
            $imgFullPathLink = "$imgDirLink/$imgName";
            move_uploaded_file($img['tmp_name'], $imgFullPath);

            return $imgFullPathLink;
        }
    }

    return null;
}

?>
