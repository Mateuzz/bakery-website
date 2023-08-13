<?php

ob_start();

if (isset($signupErrors)) {
    foreach ($signupErrors as $error) {
        echo<<<_EOF
        <div class="login-error">
            $error
        </div>
        _EOF;
    }
}

$errorsHtml = ob_get_clean();

echo <<< _EOF
<main class="main-card-page">
    <form class="signup-form ut-flow form-card basic-form" method="post" action="">
        <h1>Criar Conta</h1>

        $errorsHtml

        <div>
            <label for="name">Nome Completo</label>
            <input type="text" value="$name" id="name" name="name" minlength="3" maxlenght="60" placeholder="Nome" required>
            <span class="validity-symbol" aria-hidden="true"></span>
            <div class="form-validity-message" role="alert"></div>
        </div>

        <div>
            <label for="email">Email</label>
            <input pattern="^[\w\.]+@[\w]+\.[\w]+$" type="email" value="$email" id="email" name="email" maxlength="60" placeholder="Email@exemplo.com" required>
            <span class="validity-symbol" aria-hidden="true"></span>
            <div class="form-validity-message" role="alert"></div>
        </div>

        <div>
            <label for="birth-date">Data de Nascimento</label> 
            <input type="date"  value="$birth" id="birth-date" name="birth-date" required>
            <span class="validity-symbol" aria-hidden="true"></span>
            <div class="form-validity-message" role="alert"></div>
        </div>

        <div>
            <label for="telephone">Telefone</label>
            <input type="tel" value="$tel" id="telephone" name="telephone" placeholder="(DDD) XXXX XXXX" required>
            <span class="validity-symbol" aria-hidden="true"></span>
            <div class="form-validity-message" role="alert"></div>
        </div>

        <div>
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" minlength="8" placeholder="************" required>
            <span class="validity-symbol" aria-hidden="true"></span>
            <div class="form-validity-message" role="alert"></div>
        </div>

        <div>
            <label for="password-confirm">Confirme sua Senha</label>
            <input type="password" id="password-confirm" minlength="8" placeholder="************" required>
            <span class="validity-symbol" aria-hidden="true"></span>
            <div class="form-validity-message" role="alert"></div>
        </div>

        <div class="contact-link">
            <a href="login">Já tem uma conta?</a>
        </div>

        <button type="submit" name="submit" value="submit" class="button-link">Crie sua Conta</button>
    </form>
</main>
_EOF;

?>

