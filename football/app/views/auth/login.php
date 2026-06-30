<?php
declare(strict_types=1);
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="p-4 bg-white rounded shadow border-0">
        <h1 class="h3 fw-bold text-center text-primary mb-2">
            Welcome Back
        </h1>

        <p class="text-center text-muted mb-4">
           Sign in to access your Football Management dashboard.
        </p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars((string)$error); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="./index.php?r=login">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(CSRF::token()); ?>">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input 
                        class="form-control"
                        type="email"
                        name="email"
                        placeholder="Enter your email address"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input
                        class="form-control"
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        required>
                </div>
                <button class="btn btn-primary w-100 fw-semibold py-2" type="submit">
                    Sign In
                </button>
            </form>
            <p class="text-center text-muted small mb-3">
                Don't have an account? Choose one of the options below.
            </p>
            <hr>

            <div class="d-flex gap-2 flex-wrap">
                <a class="btn btn-outline-secondary flex-fill" href="./index.php?r=register-player">Register as Player</a>
                <a class="btn btn-outline-secondary flex-fill" href="./index.php?r=register-manager">Register as Manager</a>
                <a class="btn btn-outline-secondary flex-fill" href="./index.php?r=register-presedient">Register as Presedient</a>
            </div>
        </div>
    </div>
</div>

