<div class="col-4 mx-auto">
    <h1 class="mt-5 text-center"><?php echo $label ?></h1>

    <?php if (count($model->getErrors())) : ?>
        <div class="alert alert-danger">
            <ul class=mb-0>
                <li>
                <?php echo $model->getErrors('</li><li>') ?>
                </li>
            </ul>
        </div>
    <?php endif ?>

    <form class="mt-3" action="<?php echo $host . $action ?>" method="POST">
        <input name="_csrf" type="hidden" value="<?php echo \BooksSystem\Core\App::csrfToken() ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" value="<?php self::encode($model->getName()) ?>" class="form-control" id="name">
        </div>

        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" name="isbn" value="<?php self::encode($model->getIsbn()) ?>" class="form-control" id="isbn">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="3"><?php self::encode($model->getDescription()) ?></textarea>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>