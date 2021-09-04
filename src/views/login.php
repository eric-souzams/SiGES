<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/comum.css">
    <link rel="stylesheet" href="css/login.css">

    <title>::. SiGES .::</title>
</head>

<body>
    <form class="form-login" action="#" method="post">
        <div class="card login-card">
            <div class="card-header font-weight-bold">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                </svg>
                <span class="siges-name ml-2">
                    Si.G.E.S - Sistema de Gerenciamento de Entrada e Saida
                </span>
            </div>
            <div class="card-body">
                <?php include(TEMPLATE_PATH . '/messages.php') ?>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-control <?= isset($errors['email']) && $errors['email'] ? 'is-invalid' : '' ?>" 
                        placeholder="Digite seu e-mail" 
                        value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" 
                        autofocus
                    >
                    <div class="invalid-feedback">
                        <?= isset($errors['email']) ? $errors['email'] : ''?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-control <?= isset($errors['password']) && $errors['password'] ? 'is-invalid' : '' ?>" 
                        placeholder="Digite sua senha"
                    >
                    <div class="invalid-feedback">
                        <?= isset($errors['password']) ? $errors['password'] : ''?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-xl btn-primary btn-custom">Entrar</button>
            </div>
        </div>
    </form>
</body>

</html>