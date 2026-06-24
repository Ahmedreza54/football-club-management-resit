<?php
declare(strict_types=1);

final class RBAC
{
    public static function requireRole(array $roles): void
    {
        $u = Auth::user();
        $normalizedRoles = array_map(static fn (string $r): string => Auth::normalizeRole($r), $roles);
        $userRole = isset($u['role']) ? Auth::normalizeRole((string)$u['role']) : null;
        if (!$u || !$userRole || !in_array($userRole, $normalizedRoles, true)) {
            http_response_code(403);
            exit('Forbidden');
        }
    }
}

