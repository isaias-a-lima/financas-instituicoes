<?php
$email = isset($_POST['email']) ? $_POST['email'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
?>
<section class="row">
    <div class="col-sm-6">
        <h1>Login</h1>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" type="mail" name="email" id="email" required />
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input class="form-control" type="password" name="senha" id="senha" required />
            </div>
            <input class="btn btn-default" type="submit" value="Login" />
        </form>
    </div>
</section>