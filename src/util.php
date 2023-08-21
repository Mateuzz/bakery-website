<?php

require_once "config/config.php";

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
        $imgDir = UPLOADED_IMAGES_FULL_PATH;
        $imgDirLink = UPLOADED_IMAGES_PATH;

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

function getImg($name)
{
    if (isset($_FILES[$name]) && $_FILES[$name]['error'] == 0) {
        return getImgLink($_FILES[$name]);
    }
    return null;
}

function renderLayout($title, $template, $post = [], $assetGroup = 'default')
{
    $post['title'] = $title . PAGE_TITLE_SUFFIX;
    $post['isAdmin'] = isset($_SESSION['admin']);
    $post['mainTemplate'] = $template;
    $assets = getAssetsByGroup($assetGroup);
    $post = array_merge($post, $assets);
    return renderTemplateHTML("views/layout.php", $post);
}

function renderTemplateHTML($template, $post = [])
{
    extract($post);

    ob_start();
    require $template;

    return ob_get_clean();
}

?>
