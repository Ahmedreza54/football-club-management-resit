<?php
declare(strict_types=1);

// Reset password for EVERY user with role = presedient/admin (fixes login issues
// when you registered a different email or lost the password).
//
// Run:
//   php database/reset_admin_passwords.php
//
// Default password after reset: Presedient123!

require_once __DIR__ . '/../app/lib/Database.php';

$newPassword = $argv[1] ?? 'Presedient123!';
$hash = password_hash($newPassword, PASSWORD_DEFAULT);

$pdo = Database::pdo();

$stmt = $pdo->query("SELECT id, email, name FROM users WHERE role IN ('presedient','admin') ORDER BY id");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($admins === []) {
    echo "No presedient users found. Run: php database/ensure_demo_users.php\n";
    exit(1);
}

echo "Presedient accounts that will get the new password:\n";
foreach ($admins as $a) {
    echo "  - id={$a['id']} email={$a['email']} name={$a['name']}\n";
}

$upd = $pdo->prepare("UPDATE users SET password_hash = :hash WHERE role IN ('presedient','admin')");
$upd->execute(['hash' => $hash]);

echo "\nDone. Log in as ANY of the emails above with password: {$newPassword}\n";
