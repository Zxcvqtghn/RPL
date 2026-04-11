<?php

require_once __DIR__ . '/../config/database.php';

// Start session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Login user dengan username dan password
 * @param string $username
 * @param string $password
 * @return array ['success' => bool, 'message' => string, 'role' => string]
 */
function login($username, $password)
{
    $db = getDB();

    // Prepared statement untuk keamanan
    $stmt = $db->prepare("SELECT id_user, username, password, nama, role, gambar FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (md5($password) === $user['password']) {
            // Set session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['gambar'] = $user['gambar'];
            $_SESSION['logged_in'] = true;

            $stmt->close();
            $db->close();

            return [
                'success' => true,
                'message' => 'Login berhasil!',
                'role' => $user['role']
            ];
        } else {
            $stmt->close();
            $db->close();
            return [
                'success' => false,
                'message' => 'Password salah!'
            ];
        }
    } else {
        $stmt->close();
        $db->close();
        return [
            'success' => false,
            'message' => 'Username tidak ditemukan!'
        ];
    }
}

/**
 * Logout user
 */
function logout()
{
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}

/**
 * Check apakah user sudah login
 * @return bool
 */
function isLoggedIn()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Check apakah user adalah admin
 * @return bool
 */
function isAdmin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';
}

/**
 * Check apakah user adalah writer
 * @return bool
 */
function isWriter()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Writer';
}

/**
 * Redirect jika belum login
 * @param string $redirect_to
 */
function requireLogin($redirect_to = '../login.php')
{
    if (!isLoggedIn()) {
        header("Location: $redirect_to");
        exit();
    }
}

/**
 * Redirect jika bukan admin (untuk halaman admin only)
 * @param string $redirect_to
 */
function requireAdmin($redirect_to = 'index.php')
{
    requireLogin();
    if (!isAdmin()) {
        header("Location: $redirect_to");
        exit();
    }
}

/**
 * Get current logged in user data
 * @return array
 */
function getCurrentUser(): array|null
{
    if (!isLoggedIn()) {
        return null;
    }

    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'nama' => $_SESSION['nama'] ?? null,
        'role' => $_SESSION['role'] ?? null,
        'gambar' => $_SESSION['gambar'] ?? 'default.jpg'
    ];
}
?>