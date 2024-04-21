<h1 class="text-center">User Books list</h1>
<?php foreach ($books as $book): ?>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php self::encode($book->getName()) ?></h5>
                <p class="card-text"><?php echo $book->getDescription() ?></p>
                <form style="display: inline-block;" method="POST" action="<?php echo $host . '/user/remove-book/' . $book->getId() ?>">
                    <input name="_csrf" type="hidden" value="<?php echo \BooksSystem\Core\App::csrfToken() ?>">
                    <button type="submit" class="btn btn-danger">Remove</button>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>