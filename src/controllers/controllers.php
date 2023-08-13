<?php

require 'models/user.php';
require 'models/product.php';
require_once 'util.php';

const TITLE_SUFFIX = " | Mckay's Bakery";

function startUserSession($userRow) {
    $_SESSION['logged'] = true;
    $_SESSION['s_name'] = $userRow['name'];
    $_SESSION['s_email'] = $userRow['email'];
    $_SESSION['s_birth'] = $userRow['birth'];
    $_SESSION['s_tel'] = $userRow['telephone'];

    if ($userRow['flag'] == 'admin') {
        $_SESSION['admin'] = true;
    }
}

function deleteUserSession() {
    $_SESSION = [];
}

function cartAddItem($itemId, $itemQtd) {
    $product = getProduct($itemId);

    if ($product) {
        if (isset($_SESSION['cart_items'][$itemId])) {
            $_SESSION['cart_items'][$itemId]['qtd'] += $itemQtd;
        } else {
            $_SESSION['cart_items'][$itemId] = [
                'data' => $product,
                'qtd' => "$itemQtd"
            ];
        }
    }
}

function loginSubmit() {
    $email = userInput(strtolower($_POST['email']));
    $password = userInput($_POST['password']);

    $userRow = userLogin($email, $password); 

    if ($userRow) {
        startUserSession($userRow);
        header("location: /user/logged");
        exit();
    }

    return renderLayout("Login" . TITLE_SUFFIX, "views/login.php", [
        'loginErrors' => ['Invalid Credentials.'],
        'email' => $email,
    ]);
}

function signupSubmit() {
    $name = userInput($_POST['name']);
    $email = userInput(strtolower($_POST['email']));
    $birth = userInput($_POST['birth-date']);
    $tel = userInput($_POST['telephone']);
    $password = userInput($_POST['password']);

    $errors = userSignup($name, $email, $birth, $tel, $password);

    if ($errors) {
        return renderLayout('Cadastrar' . TITLE_SUFFIX, "views/signup.php", [
            'signupErrors' => $errors,
            'name' => $name,
            'email' => $email,
            'birth' => $birth,
            'tel' => $tel,
            ]);
        }

        header("location: /user/login?account_created=true");
        exit();
}

function loggedPage() {
    if (!isset($_SESSION['logged'])) {
        http_response_code(402);
        return;
    }

    return renderLayout('Logado' . TITLE_SUFFIX, 'views/logged.php', $_SESSION);
}

function logoutPage() {
    deleteUserSession();
    header("location: /user/login");
}

function loginPage() {
    if (isset($_SESSION['logged'])) {
        header("location: /user/logged");
        exit();
    }

    if (isset($_POST['submit'])) {
        return loginSubmit();
    }

    $post = ['email' => ""];

    if (isset($_GET['account_created'])) {
        $post = [
            'createdAccountMessage' => 'Your Account was created, you can login now'
        ];
    }

    return renderLayout("Login" . TITLE_SUFFIX, "views/login.php", $post);
}

function userApi() {
    if (isset($_GET['get_user']) && !empty($_GET['email'])) {
        $email = strtolower($_GET['email']);
        $userRow = getUser($email);

        if ($userRow) {
            return $userRow['name'];
        }
    }

    return "not found";
}

function signupPage() {
    if (isset($_SESSION['logged'])) {
        header("location: /user/logged");
        exit();
    }

    if (isset($_POST['submit'])) {
        return signupSubmit();
    }

    return renderLayout("Cadastrar" . TITLE_SUFFIX, "views/signup.php");
}

function homePage() {
    return renderLayout("Inicio" . TITLE_SUFFIX, "views/home.php", [
        'categories' => categoriesGetAll(),
    ]);
}

function aboutPage() {
    return renderLayout("Sobre" . TITLE_SUFFIX, "views/about.php");
}

function contactPage() {
    return renderLayout("Contate-nos" . TITLE_SUFFIX, "views/contact.php");
}

function cartPage() {
    if (!isset($_SESSION['cart_items'])) {
        $_SESSION['cart_items'] = [];
    }

        if (!empty($_POST['add-item-id']) && isset($_POST['add-item-qtd']) && $_POST['add-item-id'] > 0) {
            $itemId = $_POST['add-item-id'];
            $itemQtd = $_POST['add-item-qtd'];
            cartAddItem($itemId, $itemQtd);
        } else if (!empty($_GET['remove-item-id'])) {
            $itemId = $_GET['remove-item-id'];
            unset($_SESSION['cart_items'][$itemId]);
        }

        return renderLayout("Meu Carrinho" . TITLE_SUFFIX, "views/cart.php", [
            'cart_items' => $_SESSION['cart_items']
        ]);
}

function menuPage() {
    return renderLayout("Menu" . TITLE_SUFFIX, "views/menu.php", [
        'menuAllItems' => productsGetAll(),
        'categories' => categoriesGetAll()
    ]);
}

function stockControlPage() {
    if (!isset($_SESSION['admin'])) {
        http_response_code(403);
        return "";
    }

    return renderLayout('Estoque' . TITLE_SUFFIX, "views/stock.php", [
        'productsAllItems' => productsGetAll(),
        'categories' => categoriesGetAll()
    ]);
}

function stockEditPage() {
    if (!isset($_SESSION['admin'])) {
        http_response_code(403);
        return "";
    }

    if (!isUnsetAny($_POST, ['submit', 'description']) &&
        !emptyAny($_POST, ['id', 'category', 'price', 'name'])) {
        $id = userInput($_POST['id']);
        $category = userInput($_POST['category']);
        $price = userInput($_POST['price']);
        $name = userInput($_POST['name']);
        $description = userInput($_POST['description']);

        $img =  getImg('img');

        editProduct($id, $name, $description, $price, $category, $img);
    } else if (isset($_POST['delete']) && !empty($_POST['id'])) {
        deleteProduct($_POST['id']);
    }

    header("location: /admin/stock");
}

function getImg($name) {
    if (isset($_FILES[$name]) && $_FILES[$name]['error'] == 0) {
        return getImgLink($_FILES[$name]);
    }
    return null;
}

function stockAddPage() {
    if (!isset($_SESSION['admin'])) {
        http_response_code(403);
        return "";
    }

    if (isset($_POST['submit-category']) && !empty($_POST['name'])) {
        $imgLink = getImg('img');

        if ($imgLink) {
            addCategory($_POST['name'], $imgLink);
        }
    }

    if (isset($_POST['submit-product']) && !emptyAny($_POST, ['name', 'category', 'price'])) {
        $name = userInput($_POST['name']);
        $category = userInput($_POST['category']);
        $price = userInput($_POST['price']);
        $imgLink =  getImg('img');

        if (isset($_POST['description'])) 
            $description = userInput($_POST['description']);
        else 
            $description = '';

        addProduct($name, $description, $price, $category, $imgLink);
    }

    header("location: /admin/stock");
}

function renderLayout($title, $path, $post = []) {
    return renderTemplateHTML("views/layout.php", [
        'title' => $title,
        'isAdmin' => isset($_SESSION['admin']),
        'content' => renderTemplateHTML($path, $post)
    ]);
}

function renderTemplateHTML($template, $post = []) {
    extract($post);

    ob_start();
    require $template;

    return ob_get_clean();
}
