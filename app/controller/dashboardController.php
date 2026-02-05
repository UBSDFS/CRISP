<?php
class DashboardController
{
    //function to show the dashboard view
    public function show()
    {
        $role = $_SESSION['role'] ?? 'customer'; //placeholder for role

        $user = [
            'name' => $_SESSION['name'] ?? 'Customer',
            'email' => $_SESSION['email'] ?? 'customer@example.com'
        ];

        $complaints = []; //will come from complaints model once Db is connected

        // Load the appropriate dashboard view based on role
        switch ($role) {
            case 'customer':
                include_once '../app/views/dashboard/customer.php';
                break;
            case 'technician':
                include_once '../app/views/dashboard/tech.php';
                break;
            case 'admin':
                include_once '../app/views/dashboard/admin.php';
                break;
            default:
                // Default to customer dashboard if role is unknown
                include_once '../app/views/dashboard.php';
                break;
        }
    }
}
