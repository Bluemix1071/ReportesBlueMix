<?php
$conn = new mysqli('127.0.0.1', 'cflores', 'bmiX_2021', 'db_bluemix');
if ($conn->connect_error) die('FAIL CONNECTION');

// 1. Check if role exists
$res = $conn->query("SELECT id FROM roles WHERE name = 'Sucursal' AND guard_name = 'web'");
if ($res->num_rows == 0) {
    // 2. Insert Role
    $conn->query("INSERT INTO roles (name, guard_name, created_at, updated_at) VALUES ('Sucursal', 'web', NOW(), NOW())");
    $role_id = $conn->insert_id;
    echo "Created Role ID: $role_id\n";
} else {
    $row = $res->fetch_assoc();
    $role_id = $row['id'];
    echo "Role already exists ID: $role_id\n";
}

// 3. Get permission ID for 'Sucursal'
$res = $conn->query("SELECT id FROM permissions WHERE name = 'Sucursal' AND guard_name = 'web'");
if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $perm_id = $row['id'];
    echo "Permission ID: $perm_id\n";
    
    // 4. Link Role and Permission
    $res_link = $conn->query("SELECT * FROM role_has_permissions WHERE permission_id = $perm_id AND role_id = $role_id");
    if ($res_link->num_rows == 0) {
        $conn->query("INSERT INTO role_has_permissions (permission_id, role_id) VALUES ($perm_id, $role_id)");
        echo "Linked Permission to Role\n";
    } else {
        echo "Already linked\n";
    }
} else {
    echo "Permission 'Sucursal' NOT FOUND\n";
}
echo "OK";
