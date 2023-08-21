<?php

require_once 'db.php';
require_once 'util.php';

function getProduct($id) {
    return selectOneDB('bakery', 'products', 'pk_id', $id);
}

function productsGetAll() {
    return selectAllDB('bakery', 'products');
}
    
function editProduct($id, $name, $description, $price, $category, $img) {
    $fields = [
        ['name', $name],
        ['description', $description],
        ['category', $category],
        ['price', $price],
    ];

    if ($img) {
        $fields[] = ['img_url', $img];
    }

    return updateDB( 'bakery', 'products', $fields, ['pk_id', $id]);
}

function addProduct($name, $description, $price, $category, $img) {
    $fieldNames = ['name', 'description', 'category', 'price'];
    $fieldValues = [$name, $description, $category, $price];

    if ($img) {
        $fieldNames[] = 'img_url';
        $fieldValues[] = $img;
    }

    return insertIgnoreDB('bakery', 'products', $fieldNames, $fieldValues);
}

function deleteProduct($id) {
    return deleteDB('bakery', 'products', 'pk_id', $id);
}

function categoriesGetAll() {
    return selectAllDB('bakery', 'categories');
}

function addCategory($name, $img) {
    return insertIgnoreDB('bakery', 'categories', ['name', 'img_url'], [$name, $img]);
}

function editCategory($id, $name) {
    return updateDB('bakery', 'categories', ['name', $name], ['pk_id'], $id);
}

function removeCategory($id) {
    return deleteDB('bakery', 'categories', 'pk_id', $id);
}

?>
