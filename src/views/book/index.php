<h1 class="text-center">Books list</h1>
<?php foreach ($model as $book): ?>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php self::encode($book->getName()) ?></h5>
                <p class="card-text"><?php echo $book->getDescription() ?></p>
                <?php if ($isAdmin): ?>
                    <a class="btn btn-primary" href="<?php echo $host . '/admin/edit_book/' . $book->getId() ?>">Edit</a>
                <?php endif ?>
                <?php if ($hasUser): ?>
                    <form style="display: inline-block;" method="POST" action="<?php echo $host . '/user/add_book/' . $book->getId() ?>">
                        <input name="_csrf" type="hidden" value="<?php echo \BooksSystem\Core\App::csrfToken() ?>">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                <?php endif ?>
            </div>
        </div>
    </div>
<?php endforeach ?>