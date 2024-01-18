<section class="divider">
<table class="table">
    <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Operaciones</th>
    </tr> 
    <?php foreach ($usuarios as $key => $usuario) : ?>
        <tr>
            <td><?= $usuario->getNombre()?></td>
            <td><?= $usuario->getApellidos()?></td>
            <td><?= $usuario->getEmail()?></td>
                <form action="<?=BASE_URL?>editUser" method="POST">
                    <td>
                        <select name="edit">
                            <option value="admin" <?= $usuario->getRol()=="admin"?"selected":""?>>Admin</option>
                            <option value="user" <?= $usuario->getRol()=="user"?"selected":""?>>User</option>
                        </select>
                    </td>
                    <td>
                        <button name="editar" value="<?= $usuario->getId()?>">Cambiar Rol</button>
                    </td>
                </form>
        </tr>
    <?php endforeach;?>
</table>
    
    <form action="<?= BASE_URL ?>vloginAdmin" method="post" class="formLogin">
        <h2>Register</h2>   
        <input type="text" name="isLogin" value="false" hidden>
        <div>
            <label for="email">Email</label>
            <input type="text" name="data[email]" id="email" value="<?=isset($relleno['email'])?$relleno['email']:""?>">
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
            <input type="text" name="data[name]" id="name" value="<?=isset($relleno['name'])?$relleno['name']:""?>">
            <p ><?= isset($errores['name']) ? $errores['name'] : "" ?></p>
        </div>
        <div>
            <label for="subname">Apellidos</label>
            <input type="text" name="data[subname]" id="subname" value="<?=isset($relleno['subname'])?$relleno['subname']:""?>">
            <p class="err"><?= isset($errores['subname']) ? $errores['subname'] : "" ?></p>
        </div>
        <div>
            <label for="rol">Rol</label>
            <select name="data[rol]" id="rol">
                <option value="user">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
        </div>
        <button type="submit">Registrar</button>
    </form>
</section>