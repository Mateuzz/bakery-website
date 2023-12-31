<?php

ob_start();

if (isset($signupErrors)) {
    foreach ($signupErrors as $error) {
        echo<<<HTML
        <div class="login-error">
            $error
        </div>
        HTML;
    }
}

$errorsHtml = ob_get_clean();

foreach (['name', 'tel', 'birth', 'email'] as $var) {
    if (!isset($$var))
        $$var = "";
}

echo <<< HTML
<main class="main-card-page">
    <form class="signup-form ut-flow form-card basic-form" method="post" action="" novalidate>
        <h1>Criar Conta</h1>

        $errorsHtml

        <div class="form-group">
            <label for="name">Nome Completo</label>
            <input type="text" value="$name" id="name" name="name" minlength="3" maxlenght="60" placeholder="Nome" required>
            <span class="validity-symbol validity-info">
                <dialog></dialog>
            </span>
            <div class="form-validity-message validity-info" role="alert"></div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input pattern="^[\w\.]+@[\w]+\.[\w]+$" type="email" value="$email" id="email" name="email" maxlength="60" placeholder="Email@exemplo.com" required>
            <span class="validity-symbol validity-info">
                <dialog></dialog>
            </span>
            <div class="form-validity-message validity-info" role="alert"></div>
        </div>

        <div class="form-group">
            <label for="birth-date">Data de Nascimento</label> 
            <input type="date"  value="$birth" id="birth-date" name="birth-date" required>
            <span class="validity-symbol validity-info">
                <dialog></dialog>
            </span>
            <div class="form-validity-message validity-info" role="alert"></div>
        </div>

        <div class="form-group">
            <label for="telephone">Telefone</label>
            <input type="tel" value="$tel" id="telephone" name="telephone" placeholder="(DDD) XXXX XXXX" required>
            <span class="validity-symbol validity-info">
                <dialog></dialog>
            </span>
            <div class="form-validity-message validity-info" role="alert"></div>
        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" minlength="8" placeholder="************" required>
            <span class="validity-symbol validity-info">
                <dialog></dialog>
            </span>
            <div class="form-validity-message validity-info" role="alert"></div>
        </div>

        <div class="form-group">
            <label for="password-confirm">Confirme sua Senha</label>
            <input type="password" id="password-confirm" minlength="8" placeholder="************" required>
            <span class="validity-symbol validity-info">
                <dialog></dialog>
            </span>
            <div class="form-validity-message validity-info" role="alert"></div>
        </div>

        <div class="contact-link">
            <a href="/user/login">Já tem uma conta?</a>
        </div>

        <button type="submit" name="submit" value="submit" class="button-link">Crie sua Conta</button>
    </form>
</main>
HTML;

?>

