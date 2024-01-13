<table>
    <tr>
        <th>id</th>
        <th>nombre</th>
        <th>opciones</th>
    </tr>
    <?php foreach ($cats as $key => $cat) : ?>
        <tr>
            <td><?=$cat->getId()?></td>
            <td><?=$cat->getNombre()?></td>
            <td>
                <form action="<?=BASE_URL?>opcionesCat" method="POST">
                    <?php if($cat->getBorrado()==0):?>
                        <button name="borrar" value="<?=$cat->getId()?>">Desactivar</button>
                    <?php else:?>
                        <button name="activar" value="<?=$cat->getId()?>">Activar</button>
                    <?php endif;?>
                    <button name="editar" value="<?=$cat->getId()?>">Editar</button>
                </form>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<form action="<?=BASE_URL?>addC" method="post">
    <label for="name">Nombre nueva categoria:</label>
    <input type="text" name="nombre" id="name">
    <button type="submit">Guardar</button>
</form>