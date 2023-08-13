<?php 

echo <<<_EOF
<main class="main-card-page">
    <div class="ut-flow logged-form form-card basic-form">
        <h1>$s_name</h1>
        <div>
            <label>Email</label>
            <input type="text" value="$s_email" name="email" id="" disabled aria-lab>
        </div>
        <div>
            <label>Data de Nascimento</label>
            <input type="email" value="$s_birth" name="birth-date" id="" disabled>
        </div>
        <div>
            <label>Telefone</label>
            <input type="tel" value="$s_tel" name="telephone" id="" disabled>
        </div>
        <div>
            <a href="logout" class="button-link">Log out</a>
        </div>
    </div>
</main>
_EOF

?>
