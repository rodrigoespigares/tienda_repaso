<table>
    <tr>
        <th>ID</th>
        <th>Provincia</th>
        <th>localidad</th>
        <th>Fecha Completa</th>
        <th>Estado</th>
        <th>Detalles</th>
    </tr>
    <?php foreach ($pedidos as $key => $value) : ?>
        <tr>
            <td><?=$value->getId()?></td>
            <td><?=$value->getProvincia()?></td>
            <td><?=$value->getLocalidad()?></td>
            <td><?=$value->getFecha()?> <?=$value->getHora()?></td>
            <td>
                <form action="<?=BASE_URL?>changeEstado/<?=$value->getId()?>" method="post">
                    <select name="estado">
                        <option value="pendiente" <?=$value->getEstado()=="pendiente"?"selected":""?>>Pendiente</option>
                        <option value="enviado" <?=$value->getEstado()=="enviado"?"selected":""?>> Enviado</option>
                    </select>
                    <button type="submit">Guardar</button>
                </form>
            </td>
            <td>
                <form action="<?=BASE_URL ?>detalle_pedido" method="post">
                    <button type="submit" name="detalle" value="<?=$value->getId()?>">Detalle</button>
                </form>
            </td>
        </tr>
        <?php if(isset($detalles) && $detalles[0]['id_pedido']==$pedido->getId()):?>
            <article class="detalle__producto">
                <div class="detalle__producto--cabecera">
                <h2>Detalles de su pedido:</h2>
                <a href="<?=BASE_URL?>mis_pedidos"><i class="ph-light ph-x"></i></a>
                </div>
                <div>
                    <?php foreach ($detalles as $value) :?>
                        
                        <div class="carrito__producto__info">
                            <div class="carrito__producto__content">
                                <img src="<?=BASE_URL."/subidas/".$value['producto']->getImagen()?>" alt="Producto" class="carrito__producto__content__img">
                            </div>
                            <p><?= $value['producto']->getNombre()?></p>
                        </div>
                    
                    <?php endforeach;?>
                </div>
            </article>
        <?php endif;?>
    <?php    endforeach;
?>
</table>