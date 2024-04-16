<h1 class="text-center">Users list</h1>
<table class="table table-striped">
    <tr>
        <th>First name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Is Admin</th>
        <th>Is Active</th>
        <th>Create Time</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php self::encode($user->getFirstName()) ?></td>
            <td><?php self::encode($user->getLastName()) ?></td>
            <td><?php self::encode($user->getEmail()) ?></td>
            <td>
                <form style="display:inline-block" action="<?php echo $host . '/admin/toggle_admin_user/' . $user->getId() ?>" method="POST">
                    <input name="_csrf" type="hidden" value="<?php echo \BooksSystem\Core\App::csrfToken() ?>">
                <input class="form-check-input toggle-user" type="checkbox" value="" <?php echo $user->isAdmin() ? 'checked' : '' ?>>
                </form>
            </td>
            <td>
                <form style="display:inline-block" action="<?php echo $host . '/admin/toggle_active_user/' . $user->getId() ?>" method="POST">
                    <input name="_csrf" type="hidden" value="<?php echo \BooksSystem\Core\App::csrfToken() ?>">
                    <input class="form-check-input toggle-user" type="checkbox" value="" <?php echo $user->isActive() ? 'checked' : '' ?>>
                </form>
            </td>
            <td><?php self::encode($user->getCreateTime()) ?></td>
        </tr>
    <?php endforeach ?>
    </table>

    <script>
        $(document).ready(function () {
            $('.toggle-user').on('change', function (e) {
                $(e.target).closest('form').submit();
            });
        });
    </script>