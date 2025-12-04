<?php
include_once 'config/koneksi.php';

$username = 'admin';
$password = 'password123';

// Test koneksi
echo "Testing Login Debug<br>";
echo "Username: " . $username . "<br>";
echo "Password: " . $password . "<br><br>";

// Query user
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $koneksi->prepare($sql);

if (!$stmt) {
    echo "Prepare error: " . $koneksi->error . "<br>";
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "User found: " . $user['username'] . "<br>";
    echo "User ID: " . $user['id'] . "<br>";
    echo "User Status: " . $user['user_status'] . "<br>";
    echo "Password Hash: " . $user['password'] . "<br><br>";
    
    // Test password verification
    echo "Testing password_verify():<br>";
    $verify = password_verify($password, $user['password']);
    echo "Result: " . ($verify ? "TRUE ✅" : "FALSE ❌") . "<br><br>";
    
    // Test with different methods
    echo "Testing password_verify with trim:<br>";
    $verify2 = password_verify(trim($password), $user['password']);
    echo "Result: " . ($verify2 ? "TRUE ✅" : "FALSE ❌") . "<br><br>";
    
    // Test direct comparison
    echo "Testing direct comparison:<br>";
    if (strcmp(trim($password), 'password123') === 0) {
        echo "String comparison OK ✅<br>";
    }
    
} else {
    echo "User not found ❌<br>";
}

$stmt->close();
?>
