<div class="col-4 mx-auto">
    <h1 class="mt-5 text-center">Register new user</h1>

    <?php if (count($model->getErrors())) : ?>
        <div class="alert alert-danger">
            <ul class=mb-0>
                <li>
                <?php echo $model->getErrors('</li><li>') ?>
                </li>
            </ul>
        </div>
    <?php endif ?>

    <form class="mt-3" action="<?php echo \BooksSystem\Core\App::host() ?>/user/store" method="POST">
        <input name="_csrf" type="hidden" value="<?php echo \BooksSystem\Core\App::csrfToken() ?>">

        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" name="firstName" value="<?php echo $model->getFirstName() ?>" class="form-control" id="firstName">
        </div>

        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" name="lastName" value="<?php echo $model->getLastName() ?>" class="form-control" id="lastName">
        </div>

        <div class="mb-3">
            <label for="eamil" class="form-label">Email</label>
            <input type="text" name="email" value="<?php echo $model->getEmail() ?>" class="form-control" id="email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" value="" class="form-control" id="password">
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>