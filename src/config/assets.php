<?php

require_once "config.php";
require "manifest.php";

const JS_PATH = "js";
const TEMPLATES_PATH = "/views";
const CSS_PATH = "css";

const ASSETS_GROUP = [
    'cart' => [ 'script' => 'cart.js', ], 
    'default' => [ 'script' => 'global.js', ], 
    'menu' => [ 'script' => 'menu.js', ], 
    'signup' => [ 'script' => 'signup.js', ], 
    'stock' => [ 'script' => 'stock.js', ], 
];

function getAssetsByGroup($group) {
    global $gMode;

    $css = CSS_PATH . "/styles.css";
    $script = JS_PATH . "/" . ASSETS_GROUP[$group]['script'];
    $assets = [];

    if ($gMode === Modes::Production) {
        // get path from manifest.php
        $assets['css'] = '/' . getBundleAsset($css);
        $assets['script'] = '/' . getBundleAsset($script);
    } else {
        // get normal files
        $assets['css'] = "/$css";
        $assets['script'] = "/$script";
    }

    return $assets;
}

function getBundleAsset($path) {
    return EsbuildPluginPhpManifest::$files[$path];
}

?>
