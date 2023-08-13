<main class="main-card-page">
        <form class="ut-flow form-card basic-form" method="post" action="">
            <h1>Contate-nos</h1>
            <div>
                <label for="name">Nome Completo</label>
                <input type="text" id="name" name="name" maxlenght="32" placeholder="Nome" required>
                <span></span>
            </div>

            <div>
                <label for="email">Email</label>
                <input pattern="^[\w]+@[\w]+\.[\w]+$" type="email" id="email" name="email" maxlength="50" placeholder="Email@exemplo.com" required>
                <span></span>
            </div>

            <div>
                <label for="telephone">Telefone</label>
                <input type="tel" id="telephone" name="telephone" placeholder="(DDD)XXXXXXXX" required>
                <span></span>
            </div>

            <div>
                <label for="message">Mensagem</label>
                <textarea rows="7" id="message" name=message" placeholder="Digite aqui sua mensagem" required></textarea>
                <span></span>
            </div>

            <button type="submit" class="button-link">Enviar</button>
        </form>
</main>
