<h2>Editar categoria</h2>
<form action="updatecategory/{$category->id}" method="POST" enctype="multipart/form-data" class="my-4 ms-4 me-4">
    <div class="form-group my-2 ">
        <label>Nombre</label>
        <input type="text" value="{$category->categoria}" class="form-control" required="required" name="name"
            placeholder="Nombre">
    </div>
    <div class="form-group my-2">
        <label>Especificaciones:</label>
        <a href='editcategoryform/{$category->categoria}?id={$category->id}&cant_esp={$cant_esp-1}' class="fs-3" id="category_minus">-</a><span
            class="fs-3" id="category_cant">{$cant_esp}</span><a
            href='editcategoryform/{$category->categoria}?id={$category->id}&cant_esp={$cant_esp+1}' class="fs-3" id="category_plus">+</a>
        <tr>
            {for $i=0 to $cant_esp-1}
                <td>
                    <input type="text" class="form-control" required="required" name="specs[{$i}]"
                        placeholder="Especificación {$i+1}" {if isset($category->estructura_especificaciones[$i])}
                        value="{$category->estructura_especificaciones[$i]}" {/if}>
                </td>
            {/for}
        </tr>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Editar</button>
    <a href='home' class="btn btn-danger mt-2">Salir</a>
</form>
{include file="footer.tpl"}