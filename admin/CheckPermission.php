<?php
class Admin
{
    // (A) CONSTRUCTOR - CONNECT TO THE DATABASE
    private $pdo = null;
    private $stmt = null;
    public $error;
    function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
            DB_USER,
            DB_PASSWORD,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    // (B) DESTRUCTOR - CLOSE DATABASE CONNECTION
    function __destruct()
    {
        if ($this->stmt !== null) {
            $this->stmt = null;
        }
        if ($this->pdo !== null) {
            $this->pdo = null;
        }
    }

    // (C) RUN SQL QUERY
    function query($sql, $data = null)
    {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($data);
    }
    // (D) LOGIN
    function login($name, $password)
    {
        // (D1) GET USER & CHECK PASSWORD
        $this->query("SELECT * FROM `admin` JOIN `roles` USING (`role_id`) WHERE `name`=?", [$name]);
        $admin = $this->stmt->fetch();
        $valid = is_array($admin);
        if ($valid) {
            $valid = $password == $admin["password"];
        }
        if (!$valid) {
            $this->error = "Invalid name/password";
            return false;
        }

        // (D2) GET PERMISSIONS
        $admin["permissions"] = [];
        $this->query(
            "SELECT * FROM `roles_permissions` r
      LEFT JOIN `permissions` p USING (`perm_id`)
      WHERE r.`role_id`=?",
            [$admin["role_id"]]
        );
        while ($r = $this->stmt->fetch()) {
            if (!isset($admin["permissions"][$r["perm_mod"]])) {
                $admin["permissions"][$r["perm_mod"]] = [];
            }
            $admin["permissions"][$r["perm_mod"]][] = $r["perm_id"];
        }

        // (D3) DONE
        $_SESSION["admin"] = $admin;
        unset($_SESSION["admin"]["password"]);
        return true;
    }
    // (E) CHECK PERMISSION
    function check ($module, $perm) {
        $valid = isset($_SESSION["admin"]);
        if ($valid) { $valid = in_array($perm, $_SESSION["admin"]["permissions"][$module]) ;}
        if ($valid) { return true; }
        else { $this->error = "No permission to access."; return false; }
    }
}

// (I) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "localhost");
define("DB_NAME", "food_db");
define("DB_CHARSET", "utf8mb4");
define("DB_USER", "root");
define("DB_PASSWORD", "");

// (J) START!
$_AD = new Admin();
?>