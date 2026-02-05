<?php
class UserModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    // Get user by email using a LEFT JOIN to include customer profile information
    public function getUserByEmail(string $email)
    {
        $sql = "SELECT u.user_id, u.email, u.password_hash, u.role, c.first_name, c.last_name 
                FROM users u
                LEFT JOIN customer_profiles c ON u.user_id = c.user_id
                WHERE u.email = ?";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return null;
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }

        $stmt->close();
    }

    public function registerCustomer(string $email, string $password, string $firstName, string $lastName, string $streetAddress, string $city, string $state, string $zip, string $phone)
    {
        // Start transaction
        $this->db->begin_transaction();

        try {
            // Hash the password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insert into users table
            $userSql = "INSERT INTO users (email, password_hash, role) VALUES (?, ?, 'customer')";
            $userStmt = $this->db->prepare($userSql);
            if (!$userStmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            $userStmt->bind_param("ss", $email, $passwordHash);
            if (!$userStmt->execute()) {
                throw new Exception("Failed to insert user: " . $userStmt->error);
            }

            $userId = $this->db->insert_id;

            // Insert into customer_profiles table
            $profileSql = "INSERT INTO customer_profiles (user_id, first_name, last_name, street_address, city, state, zip, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $profileStmt = $this->db->prepare($profileSql);
            if (!$profileStmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            $profileStmt->bind_param("isssssss", $userId, $firstName, $lastName, $streetAddress, $city, $state, $zip, $phone);
            if (!$profileStmt->execute()) {
                throw new Exception("Failed to insert customer profile: " . $profileStmt->error);
            }

            // Commit transaction
            $this->db->commit();

            $userStmt->close();
            $profileStmt->close();

            return ['success' => true, 'user_id' => $userId];
        } catch (Exception $e) {
            // Rollback on error
            $this->db->rollback();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
