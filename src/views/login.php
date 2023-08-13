<?php

ob_start();

if (isset($loginErrors)) {
    foreach ($loginErrors as $error) {
        echo<<<_EOF
        <div class="login-error">
            $error
        </div>
        _EOF;
    }
}

if (isset($createdAccountMessage)) {
    echo <<<_EOF
        <div class="form-message">
            $createdAccountMessage
        </div>
    _EOF;
}

$messagesHtml = ob_get_clean();


echo <<< _EOF

<main class="main-card-page">
        <form class="ut-flow form-card basic-form" method="post" action="">
            <h1>Login</h1>

            $messagesHtml

            <div>
                <label for="email">Email</label>

                <input value="$email" pattern="^[\w\.]+@[\w]+\.[\w]+$" type="email" 
                       id="email" name="email" maxlength="50" placeholder="Email@exemplo.com" required>

                <span class="validity-symbol" aria-hidden="true"></span>
            </div>

            <div>
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" minlength="8" placeholder="************" required>
                <span class="validity-symbol" aria-hidden="true"></span>
            </div>

            <div class="contact-link">
                <a href="signup">Criar Conta</a>
            </div>

            <button name="submit" type="submit" class="button-link">Login</button>
        </form>
</main>

_EOF

?>
