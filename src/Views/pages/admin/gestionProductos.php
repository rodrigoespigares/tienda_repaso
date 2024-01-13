<table>
    <tr>
        <th>id</th>
        <th>nombre</th>
        <th>stock</th>
        <th>opciones</th>
    </tr>
    <?php foreach ($productos as $key => $producto) : ?>
        <tr>
            <td><?=$key?></td>
            <td><?=$producto->getNombre()?></td>
            <td><?=$producto->getStock()?></td>
            <td>
                <form action="<?=BASE_URL?>opcionesProd" method="POST">
                    <?php if($producto->getBorrado()==0):?>
                        <button name="borrar" value="<?=$producto->getId()?>">Desactivar</button>
                    <?php else:?>
                        <button name="activar" value="<?=$producto->getId()?>">Activar</button>
                    <?php endif;?>
                    <button name="editar" value="<?=$producto->getId()?>">Editar</button>
                </form>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<form action="<?=BASE_URL?>addP" method="post" enctype="multipart/form-data">
    <div>
        <label for="categoria_id">Categoria id</label>
        <select name="data[categoria_id]" id="categoria_id">
            <?php foreach ($categorias as $key => $value) :?>
                <?php if($value->getBorrado()==0) :?>
                    <option value="<?=$value->getId()?>"><?=$value->getNombre()?></option>
                <?php endif; ?>
            <?php endforeach;?>
        </select>
    </div>
    <div>
        <label for="nombre">Nombre</label>
        <input type="text" name="data[nombre]" id="nombre">
    </div>
    <div>
        <label for="descripcion">Descripcion</label>
        <input type="text" name="data[descripcion]" id="descripcion">
    </div>
    <div>
        <label for="precio">Precio</label>
        <input type="text" name="data[precio]" id="precio">
    </div>
    <div>
        <label for="stock">Stock</label>
        <input type="text" name="data[stock]" id="stock">
    </div>
    <div>
        <label for="oferta">Oferta</label>
        <input type="text" name="data[oferta]" id="oferta">
    </div>
    <div>
        <label for="fecha">Fecha</label>
        <input type="text" name="data[fecha]" id="fecha">
    </div>
    <div>
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" id="imagen">
    </div>
    <button type="submit">Guardar</button>
</form>