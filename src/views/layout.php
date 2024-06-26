<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>

    <link href="https://fonts.bunny.net" rel="preconnect">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Books</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if ($hasUser): ?>

                        <?php if ($isAdmin): ?>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Admin</button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo $host ?>/admin/create_book">New Book</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo $host ?>/admin/users">Users</a>
                                    </li>
                                </ul>
                            </div>
                        <?php endif ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $host ?>/user/books">My Books</a>
                        </li>
                        <li class="nav-item">
                            <form style="display: inline-block;" action="<?php echo $host ?>/user/logout" method="POST">
                                <input name="_csrf" type="hidden" value="<?php echo \BooksSystem\Core\App::csrfToken() ?>">
                                <button class="nav-link" type="submit">Logout</button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $host ?>/user/create">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $host ?>/user/login">Login</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <?php require_once $path ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let locHref = $(location).attr('href'),
                target = `a[href$='${locHref}']`,
                navLink = $('.nav-link');

            navLink.removeClass('active');
            let menuLink = navLink.closest(target);
            
            menuLink.addClass('active');
        });
    </script>
</body>
</html>