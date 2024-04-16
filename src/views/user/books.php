<h1 class="text-center">User Books list</h1>
<?php foreach ($books as $book): ?>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php self::encode($book->getName()) ?></h5>
                <p class="card-text"><?php echo $book->getDescription() ?></p>
            </div>
        </div>
    </div>
<?php endforeach ?>