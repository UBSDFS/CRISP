<?php
class UserModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUserByEmail(string $email)
    {
        $sql = "SELECT user_id, first_name, last_name, email, password_hash, role FROM users WHERE email = ?";

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
}
