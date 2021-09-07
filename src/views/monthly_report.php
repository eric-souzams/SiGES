<main class="content">
    <?php
    renderTitle(
        'Relatório Mensal',
        'Acompanhe seu saldo de horas',
        'calendar'
    );
    ?>

    <div>
        <form class="mb-4" action="#" method="post">
            <div class="input-group">
                <?php if($user['is_admin']): ?>
                    <select name="user" class="form-control mr-2">
                        <?php
                        foreach ($users as $user) {
                            $selected = $user['id'] === $selectedUserId ? 'selected' : '';
                            echo "<option value='{$user['id']}' {$selected}>{$user['name']}</option>";
                        }
                        ?>
                    </select>
                <?php endif ?>
                <select name="period" class="form-control">
                    <?php
                    foreach ($periods as $key => $month) {
                        $selected = $key === $selectedPeriod ? 'selected' : '';
                        echo "<option value='{$key}' {$selected}>{$month}</option>";
                    }
                    ?>
                </select>
                <button class="btn btn-primary ml-2">
                    <i>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </i>
                </button>
            </div>
        </form>

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <th>Data</th>
                <th>Entrada 1</th>
                <th>Saída 1</th>
                <th>Entrada 2</th>
                <th>Saída 2</th>
                <th>Saldo de Horas</th>
            </thead>
            <tbody>
                <?php foreach ($report as $registry) : ?>
                    <tr>
                        <td><?= ucfirst(formatDateWithLocale($registry->getValue('work_date'), '%A, %d de %B de %Y')); ?></td>
                        <td><?= $registry->getValue('time1') ?></td>
                        <td><?= $registry->getValue('time2') ?></td>
                        <td><?= $registry->getValue('time3') ?></td>
                        <td><?= $registry->getValue('time4') ?></td>
                        <td><?= $registry->getBalance() ?></td>
                    </tr>
                <?php endforeach ?>
                <tr class="bg-primary text-white">
                    <td>Horas Trabalhadas</td>
                    <td colspan="3"><?= $sumOfWorkedTime ?></td>
                    <td>Saldo Mensal</td>
                    <td><?= $balance ?></td>
                </tr>
            </tbody>
        </table>
    </div>

</main>