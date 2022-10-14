<h2>Editar Producto</h2>
<form action="updateProduct/{$iditem}" method="POST" enctype="multipart/form-data" class="my-4 ms-4 me-4">
    <div class="form-group my-2 ">
        <label>Nombre</label>
        <input type="text" class="form-control" value="{$product->nombre}" required="required" name="name"
            placeholder="">
    </div>
    <div class="form-group my-2 ">
        <div class="form-group my-2">
            <label>Especificaciones</label>
            {for $i=0 to ($esp_cant -1)}
                <input type="text" class="form-control" required="required" name="specs[{$i}]" placeholder="{$esp[$i]}"
                    value="{$esp_data[$i]}">
            {/for}
        </div>
    </div>
    <div class="form-group my-2">
        <label>Subir Imagen</label>
        <input type="file" class="form-control-file" name="imagen">
    </div>
    <div class="row my-2">
        <div class="col col-md-3">
            <input type="number" class="form-control" value="{$product->precio}" required="required" name="price"
                placeholder="Precio">
        </div>
        <div class="col col-md-3">
            <input type="number" class="form-control" value="{$product->stock}" required="required" name="stock"
                placeholder="Stock">
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Guardar Cambios</button>
    <a href='verproducto/{$iditem}' class="btn btn-danger mt-2">Salir</a>
</form>
{include file="footer.tpl"}