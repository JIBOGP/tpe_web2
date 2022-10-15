<div class="container mt-4">
    <div class="row">
        <div class="col prodimage">
            {if $product->imagen!=null}
                <img class="image-product" src="{$product->imagen}" alt="...">
            {/if}
        </div>
        <div class="col">

            <h1>{$product->nombre}
                {if isset($smarty.session.ID_USER)}
                    <a href='editproduct/{$iditem}' type='button' class='btn btn-warning'>Editar</a>
                {/if}
            </h1>

            <div>
                <a class="historial" href="home">Home></a>
                <a class="historial" href="home/{$product->categoria}">{$product->categoria}</a>
            </div>
            <h2>$ {$product->precio|number_format:2:",":"."}</h2>
            {if $product->stock>0}
                <h5>Stock: {$product->stock}</h5>
                <a class="shadow-sm btn btn-primary" href="vender/{$iditem}">Comprar</a>
            {else}
                <h5>Stock agotado</h5>
            {/if}
        </div>
    </div>
</div>
<br>
<h2>Especificaciones:</h2>
<table class="table table-striped especificaciones">
    <tbody>
        {for $i=0 to $esp_cant-1}
            <tr>
                <td>
                    {$esp[$i]}
                </td>
                <td>
                    {if !empty($esp_data[$i])}
                        {$esp_data[$i]}
                    {else}
                        -
                    {/if}
                </td>
            </tr>
        {/for}
    </tbody>
</table>



{include file="footer.tpl"}