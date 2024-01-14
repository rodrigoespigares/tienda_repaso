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
            <td><?=$producto->getCategoriaId()?></td>
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
<form action="<?=BASE_URL?><?=isset($productoEditar)?"editP":"addP"?>" method="post" enctype="multipart/form-data">
    <h2><?=isset($productoEditar)?"Editar Producto":"Crear producto"?></h2>
    <?php if(isset($productoEditar)):?>
            <input type="text" name="data[id]" value="<?=$productoEditar[0]->getId()?>" hidden>
        <?php endif;?>
    <div>
        <label for="categoria_id">Categoria id</label>
        <select name="data[categoria_id]" id="categoria_id">
            <?php foreach ($categorias as $key => $value) :?>
                <?php if($value->getBorrado()==0) :?>
                    <option value="<?=$value->getId()?>" <?=isset($productoEditar)&& $productoEditar[0]->getCategoriaId()==$value->getId()?"selected":""?>><?=$value->getNombre()?></option>
                <?php endif; ?>
            <?php endforeach;?>
        </select>
    </div>
    <div>
        <label for="nombre">Nombre</label>
        <input type="text" name="data[nombre]" id="nombre" value="<?=isset($productoEditar)?$productoEditar[0]->getNombre():""?>">
    </div>
    <div>
        <label for="descripcion">Descripcion</label>
        <input type="text" name="data[descripcion]" id="descripcion" value="<?=isset($productoEditar)?$productoEditar[0]->getDescripcion():""?>">
    </div>
    <div>
        <label for="precio">Precio</label>
        <input type="text" name="data[precio]" id="precio" value="<?=isset($productoEditar)?$productoEditar[0]->getPrecio():""?>">
    </div>
    <div>
        <label for="stock">Stock</label>
        <input type="text" name="data[stock]" id="stock" value="<?=isset($productoEditar)?$productoEditar[0]->getStock():""?>">
    </div>
    <div>
        <label for="oferta">Oferta</label>
        <input type="text" name="data[oferta]" id="oferta" value="<?=isset($productoEditar)?$productoEditar[0]->getOferta():""?>">
    </div>
    <div>
        <label for="fecha">Fecha</label>
        <input type="text" name="data[fecha]" id="fecha" value="<?=isset($productoEditar)?$productoEditar[0]->getFecha():""?>">
    </div>
    <div>
        <label for="imagen">Imagen<?=isset($productoEditar)?" actual":""?></label>
        <?php if(isset($productoEditar)):?>
            <input type="text" name="imagen_anterior" value="<?=$productoEditar[0]->getImagen()?>" hidden>
            <div class="foto__prueba">
                <img src="<?=BASE_URL."/subidas/".$productoEditar[0]->getImagen()?>" alt="">
            </div>
        <?php endif;?>
        <?=isset($productoEditar)?"Reemplazar imagen":""?>
        <input type="file" name="imagen" id="imagen">
    </div>
    <button type="submit"><?=isset($productoEditar)?"Editar":"Guardar"?></button>
</form>