<div class="col-4 mx-auto">
    <h1 class="mt-5 text-center">Login</h1>

    <?php if (count($model->getErrors())) : ?>
        <div class="alert alert-danger">
            <ul class=mb-0>
                <li>
                <?php echo $model->getErrors('</li><li>') ?>
                </li>
            </ul>
        </div>
    <?php endif ?>

    <form class="mt-3" action="<?php echo \BooksSystem\Core\App::host() ?>/user/login_user" method="POST">
        <input name="_csrf" type="hidden" value="<?php echo \BooksSystem\Core\App::csrfToken() ?>">

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" value="<?php echo $model->getEmail() ?>" class="form-control" id="email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" value="" class="form-control" id="password">
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
</div>