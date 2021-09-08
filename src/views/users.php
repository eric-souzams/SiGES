<main class="content">
    <?php
    renderTitle(
        'Cadastro de Usuários',
        'Mantenha os dados dos usuários atualizados',
        'users'
    );

    include(TEMPLATE_PATH . "/messages.php");
    ?>

    <a class="btn btn-primary btn-lg p-2 mb-3 new-user" href="save_user.php">Novo Usuário</a>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <th>Ações</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Data de Admissão</th>
            <th>Data de Desligamento</th>
        </thead>

        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td class="actions">
                        <a href="save_user.php?update=<?= $user['id'] ?>" class="btn btn-warning mr-2">
                            <i>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                </svg>
                            </i>
                        </a>
                        <a href="?delete=<?= $user['id'] ?>" class="btn btn-danger">
                            <i>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                            </i>
                        </a>
                    </td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td>
                        <?= (new DateTime($user['start_date']))->format('d/m/Y') ?>
                    </td>
                    <td>
                        <?= ($user['end_date']) ? (new DateTime($user['end_date']))->format('d/m/Y') : $user['end_date'] ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>