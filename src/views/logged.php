<?php 

echo <<<HTML
<main class="main-card-page">
    <div class="ut-flow logged-form form-card basic-form">
        <h1>$name</h1>
        <div>
            <label>Email</label>
            <input type="text" value="$email" name="email" id="" disabled aria-lab>
        </div>
        <div>
            <label>Data de Nascimento</label>
            <input type="email" value="$birth" name="birth-date" id="" disabled>
        </div>
        <div>
            <label>Telefone</label>
            <input type="tel" value="$tel" name="telephone" id="" disabled>
        </div>
        <div>
            <a href="/user/logout" class="button-link">Log out</a>
        </div>
    </div>
</main>
HTML

?>
