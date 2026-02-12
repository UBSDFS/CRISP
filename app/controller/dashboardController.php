<?php

class DashboardController
{
    public function show()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=showLogin');
            exit;
        }

        $role = $_SESSION['role'] ?? 'tech';

        $user = [
            'name' => $_SESSION['name'] ?? 'Ulysses',
            'email' => $_SESSION['email'] ?? 'tech@example.com'
        ];

        $complaints = [];

        switch ($role) {
            case 'customer':
                include_once __DIR__ . '/../views/dashboard/customer.php';
                break;

            case 'tech':
                include_once __DIR__ . '/../views/dashboard/tech.php';

                break;

            case 'admin':
                include_once __DIR__ . '/../views/dashboard/admin.php';
                break;

            default:
                include_once __DIR__ . '/../views/dashboard/customer.php';
                break;
        }
    }
}
