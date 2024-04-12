<div class="col-4 mx-auto">
    <h1 class="mt-5 text-center">Register new user</h1>

    <form class="mt-3" action="" method="POST">
        <input name="csrf" type="hidden" value="">

        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" name="firstName" value="" class="form-control" id="firstName">
        </div>

        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" name="lastName" value="" class="form-control" id="lastName">
        </div>

        <div class="mb-3">
            <label for="eamil" class="form-label">Email</label>
            <input type="text" name="email" value="" class="form-control" id="email">
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