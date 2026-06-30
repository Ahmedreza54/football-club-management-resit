<?php
declare(strict_types=1);

$roleLabel = match ($role) {
    'admin' => 'Presedient',
    'coach' => 'Manager',
    'presedient' => 'Presedient',
    'manager' => 'Manager',
    'player' => 'Player',
    default => 'User',
};

$action = './index.php?r=register-' . $role;
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="p-4 bg-white rounded shadow border-0">
            <h1 class="h3 fw-bold text-center text-success mb-2">
                Create <?= htmlspecialchars($roleLabel); ?> Account
            </h1>

            <p class="text-center text-muted mb-4">
               Complete the form below to join the Football Management System.
            </p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars((string)$error); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($action); ?>">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(CSRF::token()); ?>">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input 
                        class="form-control"
                        type="text"
                        name="name"
                        placeholder="Enter your full name"
                        maxlength="100"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input
                        class="form-control"
                        type="email"
                        name="email"
                        autocomplete="email"
                        placeholder="Enter your email address"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input
                        class="form-control"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        placeholder="Create a secure password"
                        required>
                </div>

                <button class="btn btn-success w-100 fw-bold py-2" type="submit">
                    Create My Account
                </button>
            </form>

            <p class="text-center text-muted small mt-3">
                Already have an account?
                <a href="./index.php?r=login">Sign in here</a>.
            </p>
            </div>
        </div>
    </div>
</div>

