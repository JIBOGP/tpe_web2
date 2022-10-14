<!DOCTYPE html>
<html lang="en" class="form-login">

<head>
    <base href="{BASE_URL}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>TPE WEB2</title>
</head>

<body class="form-login form-login-body">
    <div class="container form-centered">
        <form action="verify" method="POST" class="">
            <h1>{$titulo}</h1>

            <div class="form-group">
                <label>Nombre de usuario</label>
                <input type="text" required="required" name="username" class="form-control"
                    placeholder="Ingresar nombre">
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" required="required" name="password" class="form-control"
                    placeholder="Ingresar contraseña">
            </div>

            {if $error}
                <div class="alert alert-danger" role="alert">
                    {$error}
                </div>
            {/if}

            <button type="submit" class="btn btn-primary mt-2">Ingresar</button>
            <a href='home' class="btn btn-danger mt-2">Salir</a>
        </form>
    </div>
{include 'templates/footer.tpl'}