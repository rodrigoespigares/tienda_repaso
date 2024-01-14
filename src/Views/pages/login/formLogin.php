<?php if ((isset($_POST['login']) && !isset($_SESSION['identity'])) || isset($error)) : ?>
    <h2>Login</h2>
    <form action="<?= BASE_URL ?>vlogin" method="post" class="formLogin">
        <input type="text" name="isLogin" value="true" hidden>
        <div>
            <label for="email">Email</label>
            <input type="text" name="data[email]" id="email">
            <p class="err"><?= isset($error['email']) ? $error['email'] : "" ?></p>
        </div>
        <div>
            <label for="password">Contraseña</label>
            <input type="password" name="data[password]" id="password">
            <p class="err"><?= isset($error['password']) ? $error['password'] : "" ?></p>
        </div>
        <p>¿No tienes usuario?<a href="<?= BASE_URL ?>login"> Haz click y registrate</a></p>
        <button type="submit">Login</button>
    </form>
<?php elseif (!isset($_POST['login']) || isset($_POST['register'])) : ?>
    <h2>Register</h2>
    <form action="<?= BASE_URL ?>vlogin" method="post" class="formLogin">
        <input type="text" name="isLogin" value="false" hidden>
        <div>
            <label for="email">Email</label>
            <input type="text" name="data[email]" id="email">
            <p class="err"><?= isset($errores['email']) ? $errores['email'] : "" ?></p>
        </div>
        <div>
            <label for="password">Contraseña</label>
            <input type="password" name="data[password]" id="password">
            <p class="err"><?= isset($errores['password']) ? $errores['password'] : "" ?></p>
        </div>
        <div>
            <label for="password2">Confirma contraseña</label>
            <input type="password" name="data[password2]" id="password2">
            <p class="err"><?= isset($errores['password2']) ? $errores['password2'] : "" ?></p>
        </div>
        <div>
            <label for="name">Nombre</label>
            <input type="text" name="data[name]" id="name">
            <p ><?= isset($errores['name']) ? $errores['name'] : "" ?></p>
        </div>
        <div>
            <label for="subname">Apellidos</label>
            <input type="text" name="data[subname]" id="subname">
            <p class="err"><?= isset($errores['subname']) ? $errores['subname'] : "" ?></p>
        </div>
        <button type="submit">Registrar</button>
    </form>
<?php endif; ?>