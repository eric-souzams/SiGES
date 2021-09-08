<main class="content">
    <?php
    renderTitle(
        'Registrar Ponto',
        'Mantenha seu ponto consistente!',
        'check'
    );
    include(TEMPLATE_PATH . '/messages.php');
    ?>

    <div class="card">
        <div class="card-header">
            <h3><?= $today ?></h3>
            <p class="mb-0">Batimentos de hoje:</p>
        </div>
        <div class="card-body">
            <div class="d-flex m-3 justify-content-around">
                <span class="record">Entrada 1: <?= @$workingHours->getValue('time1') ?? '--:--:--' ?></span>
                <span class="record">Saída 1: <?= @$workingHours->getValue('time2') ?? '--:--:--' ?></span>
            </div>
            <div class="d-flex m-3 justify-content-around">
                <span class="record">Entrada 2: <?= @$workingHours->getValue('time3') ?? '--:--:--' ?></span>
                <span class="record">Saída 2: <?= @$workingHours->getValue('time4') ?? '--:--:--' ?></span>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="innout.php" class="btn btn-success btn-lg">
                <i class="mr-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                        <path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z" />
                    </svg>
                </i>
                Bater o Ponto
            </a>
        </div>
    </div>

    <?php if ($is_admin) : ?>
        <form class="mt-5" action="innout.php" method="post">
            <div class="input-group no-border">
                <input class="form-control" type="text" name="forcedTime" placeholder="Para simular um batimento use o padrão: 00:00:00">
                <button class="btn btn-danger ml-1">
                    Simular Ponto
                </button>
            </div>
        </form>
    <?php endif ?>

</main>