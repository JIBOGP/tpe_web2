<h2>Seleccionar Categoria</h2>
<form action="formulario_product" method="POST" enctype="multipart/form-data" class="my-4 ms-4 me-4">
    <div class="form-group my-2">
        <label>Nombre</label>
        <input type="text" class="form-control" required="required" name="name" placeholder="Nombre">
    </div>
    <div class="form-group my-2">
        <label>Categoria</label>
        <select class="form-select" name="category">
            {foreach from=$categorias item=$categoria}
                <option value={$categoria->categoria}>
                    {$categoria->categoria}
                    ({foreach from=$categoria->estructura_especificaciones item=$esp}
                        {if !$esp@last}{$esp},
                        {else}{$esp}
                        {/if}
                    {/foreach})
                </option>
            {/foreach}
        </select>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Siguiente</button>
    <a href='home' class="btn btn-danger mt-2">Salir</a>
</form>
{include file="footer.tpl"}