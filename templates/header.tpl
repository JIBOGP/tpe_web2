<header>
  <nav class="navbar navbar-expand-lg bg-primary fake-nav">
    <div class="container-fluid">
      <span class="navbar-brand">Fake nav</span>
    </div>
  </nav>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
      <span class="navbar-brand">Tienda</span>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
        aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="home">Home</a>
          </li>
          <li class="nav-item dropdown">
            <span class="nav-link dropdown-toggle user-select-none text-white" id="navbarScrollingDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Categorias
            </span>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
              {if isset($categorias)}
                {foreach from=$categorias item=$categoria}
                  <li class="nav-item">
                    <div class="btn-group fill-available">
                      <a class="dropdown-item {if $categoria->categoria|lower==$selected|lower}bg-primary text-white{/if}"
                        href="home/{$categoria->categoria}">
                        {$categoria->categoria}
                      </a>
                      {if isset($smarty.session.ID_USER)}
                        <a class="dropdown-item bg-warning text-white" href="editcategoryform/{$categoria->categoria}">
                          Editar
                        </a>
                        <a class="dropdown-item bg-danger text-white" href="delcategory/{$categoria->categoria}">
                          Eliminar
                        </a>
                      {/if}
                    </div>
                  </li>
                  {if !$categoria@last}
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                  {/if}
                {/foreach}
              {/if}
              {if isset($smarty.session.ID_USER)}
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li class="nav-item">
                  <a class="dropdown-item text-center" href="formcategory/{$specification_default}">+</a>
                </li>
              {/if}
            </ul>
          </li>
        </ul>
        <div class="d-flex">
          {if isset($smarty.session.ID_USER)}
            <a class="nav-link  text-white" href="logout">Log out: {$smarty.session.USERNAME}</a>
          {else}
            <a class="nav-link  text-white" href="login">Log in</a>
          {/if}
        </div>
      </div>
    </div>
  </nav>
</header>