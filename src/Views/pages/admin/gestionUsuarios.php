<table>
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
                        <button name="editar" value="<?= $usuario->getId()?>">editar</button>
                    </td>
                </form>
        </tr>
    <?php endforeach;?>
</table>