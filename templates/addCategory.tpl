<h2>Agregar categoria</h2>
<form action="addcategory" method="POST" enctype="multipart/form-data" class="my-4 ms-4 me-4">
    <div class="form-group my-2 ">
        <label>Nombre</label>
        <input type="text" class="form-control" required="required" name="name" placeholder="Nombre">
    </div>
    <div class="form-group my-2">
        <label>Especificaciones:</label>
        <a href='formcategory/{$cant-1}' class="fs-3" id="category_minus">-</a><span class="fs-3"
            id="category_cant">{$cant}</span><a href='formcategory/{$cant+1}' class="fs-3" id="category_plus">+</a>
        <tr>
            {for $i=0 to $cant-1}
                <td>
                    <input type="text" class="form-control" required="required" name="specs[{$i}]"
                        placeholder="Especificación {$i+1}">
                </td>
            {/for}
        </tr>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Agregar</button>
    <a href='home' class="btn btn-danger mt-2">Salir</a>
</form>
{include file="footer.tpl"}