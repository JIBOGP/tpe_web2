{if $count>0}
    <p class="mt-3 ms-4"><small>Mostrando {$count} productos</small></p>
{else}
    <p class="mt-3 ms-4"><small>No se han encontrado productos</small></p>
{/if}

<div class="row row-cols-1 row-cols-md-5 g-4 m-2">
    {if isset($smarty.session.ID_USER)}
        <div class="col">
            <div class="card">
                <a href='seleccionar_categoria' type='button' class="card-body text-center fs-1">+</a>
            </div>
        </div>
    {/if}
    {foreach from=$products item=$product}
        <div class="col">
            <div class="card {if $product->stock<1}sin_stock{/if}">
                {if file_exists($product->imagen)}
                    <img src="{$product->imagen}" class="card-img-top p-2" display="{$product->nombre}" alt="{$product->nombre}">
                {else}
                    <img src="app/views/image_error.jpg" class="card-img-top p-2" placeholder="{$product->nombre}" alt="{$product->nombre}">
                {/if}
                <div class="card-body">
                    <h5 class="card-title">{$product->nombre}</h5>
                    <p class="card-text">$ {$product->precio|number_format:2:",":"."}</p>
                    <a href="verproducto/{$product->id_producto}" class="shadow-sm btn btn-primary">Mas información</a>
                    {if isset($smarty.session.ID_USER)}
                        <div class="btn-group admin_product">
                            <a href='delproduct/{$product->id_producto}' type='button' class='btn btn-danger'>Borrar</a>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    {/foreach}
</div>

{include file="footer.tpl"}