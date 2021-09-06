<main class="content">
    <?php
        renderTitle(
            'Relatório Mensal',
            'Acompanhe seu saldo de horas',
            'calendar'
        );
    ?>

    <div>
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
                <?php foreach($report as $registry): ?>
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