<?php

include '../components/connect.php';
require '../admin/CheckPermission.php';

session_start();

$admin_id = $_SESSION['admin']['id'];
$module = "AUTH";
$perm_id = 10;

$valid = isset($_SESSION["admin"]["permissions"][$module]) ;

if($valid === false){
   exit("Tài khoản không có quyền sử dụng chức năng này");
}

if ($_AD->check($module, $perm_id) === false) {
    exit("Tài khoản không có quyền sử dụng chức năng này");
}

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['submit'])) {

    $role_name = $_POST['name'];
    $role_name = filter_var($role_name, FILTER_SANITIZE_STRING);

    $select_role = $conn->prepare("SELECT * FROM  `roles` WHERE `role_name` = ? ");
    $select_role->execute([$role_name]);

    if ($select_role->rowCount() > 0) {
        $message[] = 'Name already exists!';
    } else {
        $insert_role = $conn->prepare("INSERT INTO `roles` (role_name) VALUES(?)");
        $insert_role->execute([$role_name]);
        $select_role = $conn->prepare("SELECT * FROM  `roles` WHERE `role_name` = ? ");
        $select_role->execute([$role_name]);
        if ($select_role->rowCount() > 0) {
            $fetch_role = $select_role->fetch(PDO::FETCH_ASSOC);
        }
        $config_user = isset($_POST['1']) ? $_POST['1'] : "";
        $config_admin = isset($_POST['2']) ? $_POST['2'] : "";
        $update_profile = isset($_POST['3']) ? $_POST['3'] : "";
        $config_register = isset($_POST['4']) ? $_POST['4'] : "";
        $config_product = isset($_POST['5']) ? $_POST['5'] : "";
        $update_product = isset($_POST['6']) ? $_POST['6'] : "";
        $config_messenger = isset($_POST['7']) ? $_POST['7'] : "";
        $config_order = isset($_POST['8']) ? $_POST['8'] : "";
        $auth = isset($_POST['9']) ? $_POST['9'] : "";
        $insert_auth = isset($_POST['10']) ? $_POST['10'] : "";
        $update_auth = isset($_POST['11']) ? $_POST['11'] : "";
        $update_category = isset($_POST['12']) ? $_POST['12'] : "";

        $selected = [$config_user, $config_admin, $update_profile, $config_register, $config_product, $update_product, $config_messenger, $config_order, $auth, $insert_auth, $update_auth, $update_category];
        
        foreach ($selected as $value) {
            if ($value != "") {
                $insert_roles_permissions = $conn->prepare("INSERT INTO `roles_permissions` (role_id,perm_id) VALUES(?,?)");
                $insert_roles_permissions->execute([$fetch_role['role_id'], $value]);
            }
        }
        $message[] = 'Đã tạo mới 1 nhóm quyền ' .$role_name;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admins accounts</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <!-- admins accounts section starts  -->

    <section class="form-container">

        <form action="" method="POST">
            <h1 class="heading">Create role</h1>
            <input type="text" name="name" maxlength="50" required placeholder="Tên chức vụ" class="box">
            <?php
            $perm_mod = ["USR", "ADMIN", "PRODU", "MESS", "ORDER", "AUTH"];
            $perm_title = ["Khách hàng", "Quản trị viên", "Sản Phẩm", "Thông báo", "Hóa đơn", "Phân quyền"];
            ?>
            <div class="select">
                <?php
                for ($i = 0; $i < sizeof($perm_mod); $i++) {
                    $select_permission = $conn->prepare("SELECT `perm_id`, `perm_desc` FROM `permissions` WHERE `perm_mod`= '$perm_mod[$i]'");
                    $select_permission->execute();
                ?>
                    <h3><?= $perm_title[$i] ?></h3>
                    <div class="box-select">

                        <?php
                        if ($select_permission->rowCount() > 0) {
                            while ($fetch_perm = $select_permission->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                <p><?= $fetch_perm['perm_desc']; ?>
                                    <input type="checkbox" name=<?= $fetch_perm['perm_id']; ?> value=<?= $fetch_perm['perm_id']; ?>>
                                </p>
                        <?php
                            }
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
            <input type="submit" value="Create" name="submit" class="btn">
        </form>

    </section>

    <!-- admins accounts section ends -->




















    <!-- custom js file link  -->
    <script src="../js/admin_script.js"></script>

</body>

</html>