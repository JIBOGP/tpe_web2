<h2>Agregar producto</h2>
<form action="addproduct" method="POST" enctype="multipart/form-data" class="my-4 ms-4 me-4">
    <div class="form-group my-2">
        <label>Nombre</label>
        <input class="form-control" type="text" value="{$name}" aria-label="Disabled input example" name="name"
            readonly>
    </div>
    <div class="form-group my-2">
        <label>Categoria</label>
        <select class="form-select" name="category" readonly>
            <option value={$category->id}>
                {$category->categoria}
                ({foreach from=$category->estructura_especificaciones item=$esp}
                    {if !$esp@last}{$esp},
                    {else}{$esp}
                    {/if}
                {/foreach})
            </option>
        </select>
    </div>
    <div class="form-group my-2">
        <label>Especificaciones</label>
        {for $i=0 to ($category->estructura_especificaciones|@count -1)}
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <span>{$category->estructura_especificaciones[$i]}:</span>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" name="specs[{$i}]"
                        placeholder="{$category->estructura_especificaciones[$i]}">
                </div>
            </div>
        {/for}
    </div>
    <div class="form-group my-2">
        <label>Subir Imagen</label>
        <input type="file" class="form-control-file" required="required" name="imagen">
    </div>
    <div class="row my-2">
        <div class="col col-md-3">
            <input type="number" step="any" class="form-control" required="required" name="price" placeholder="Precio">
        </div>
        <div class="col col-md-3">
            <input type="number" class="form-control" required="required" name="stock" placeholder="Stock">
        </div>
    </div>
    {if $error!=""}
        <p class="bg-danger text-white">{$error}</p>
    {/if}
    <a href='seleccionar_categoria' class="btn btn-warning mt-2">Anterior</a>
    <button type="submit" class="btn btn-primary mt-2">Agregar</button>
    <a href='home' class="btn btn-danger mt-2">Salir</a>
</form>
{include file="footer.tpl"}