<?php

require_once __DIR__ . '/../config/database.php';


/**
 * Get semua artikel
 * @return array
 */
function getAllArtikel()
{
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM blog ORDER BY tanggal DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
    return $data;
}

/**
 * Get artikel by ID
 * @param int $id
 * @return array|null
 */
function getArtikelById($id)
{
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM blog WHERE id_blog = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $data;
}

/**
 * Get artikel by author (untuk writer)
 * @param string $author
 * @return array
 */
function getArtikelByAuthor($author)
{
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM blog WHERE author = ? ORDER BY tanggal DESC");
    $stmt->bind_param("s", $author);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
    return $data;
}

/**
 * Get user by username
 * @param string $username
 * @return array|null
 */
function getUserByUsername($username)
{
    $db = getDB();
    $stmt = $db->prepare("SELECT username, nama, gambar FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $stmt->close();
    $db->close();

    return $data ?: null;
}

/**
 * Insert artikel baru
 * @param string $author
 * @param string $judul
 * @param string $isi
 * @param string $gambar
 * @return bool
 */
function insertArtikel($author, $judul, $isi, $gambar)
{
    $db = getDB();

    // Generate excerpt (17 kata pertama)
    $excerpt = implode(' ', array_slice(str_word_count($isi, 1), 0, 17)) . '...';
    $tanggal = date('Y-m-d');

    $stmt = $db->prepare("INSERT INTO blog (author, judul, isi, excerpt, gambar, tanggal) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $author, $judul, $isi, $excerpt, $gambar, $tanggal);
    $result = $stmt->execute();
    $stmt->close();
    $db->close();

    return $result;
}

/**
 * Update artikel
 * @param int $id
 * @param string $author
 * @param string $judul
 * @param string $isi
 * @param string $gambar
 * @return bool
 */
function updateArtikel($id, $author, $judul, $isi, $gambar)
{
    $db = getDB();

    // Generate excerpt
    $excerpt = implode(' ', array_slice(str_word_count($isi, 1), 0, 17)) . '...';
    $tanggal = date('Y-m-d');

    $stmt = $db->prepare("UPDATE blog SET author=?, judul=?, isi=?, excerpt=?, gambar=?, tanggal=? WHERE id_blog=?");
    $stmt->bind_param("ssssssi", $author, $judul, $isi, $excerpt, $gambar, $tanggal, $id);
    $result = $stmt->execute();
    $stmt->close();
    $db->close();

    return $result;
}

/**
 * Delete artikel
 * @param int $id
 * @return bool
 */
function deleteArtikel($id)
{
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM blog WHERE id_blog = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    $db->close();
    return $result;
}

/**
 * Count total artikel
 * @return int
 */
function countArtikel()
{
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM blog");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $data['total'];
}

/**
 * Count artikel by author
 * @param string $author
 * @return int
 */
function countArtikelByAuthor($author)
{
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM blog WHERE author = ?");
    $stmt->bind_param("s", $author);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $data['total'];
}

// ============================================
// TESTIMONI FUNCTIONS
// ============================================

/**
 * Get semua testimoni
 * @return array
 */
function getAllTesti()
{
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM testi ORDER BY idTesti DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
    return $data;
}

/**
 * Get testimoni by ID
 * @param int $id
 * @return array|null
 */
function getTestiById($id)
{
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM testi WHERE idTesti = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $data;
}

/**
 * Insert testimoni baru
 * @param string $nama
 * @param string $isi
 * @return bool
 */
function insertTesti($nama, $isi)
{
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO testi (nama, isi) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama, $isi);
    $result = $stmt->execute();
    $stmt->close();
    $db->close();
    return $result;
}

/**
 * Update testimoni
 * @param int $id
 * @param string $nama
 * @param string $isi
 * @return bool
 */
function updateTesti($id, $nama, $isi)
{
    $db = getDB();
    $stmt = $db->prepare("UPDATE testi SET nama=?, isi=? WHERE idTesti=?");
    $stmt->bind_param("ssi", $nama, $isi, $id);
    $result = $stmt->execute();
    $stmt->close();
    $db->close();
    return $result;
}

/**
 * Delete testimoni
 * @param int $id
 * @return bool
 */
function deleteTesti($id)
{
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM testi WHERE idTesti = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    $db->close();
    return $result;
}

/**
 * Count total testimoni
 * @return int
 */
function countTesti()
{
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM testi");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $data['total'];
}

// ============================================
// USER FUNCTIONS
// ============================================

/**
 * Get semua user
 * @return array
 */
function getAllUser()
{
    $db = getDB();
    $stmt = $db->prepare("SELECT id_user, username, nama, role, gambar FROM user ORDER BY id_user DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
    return $data;
}

/**
 * Get user by ID
 * @param int $id
 * @return array|null
 */
function getUserById($id)
{
    $db = getDB();
    $stmt = $db->prepare("SELECT id_user, username, nama, role, gambar FROM user WHERE id_user = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $data;
}

/**
 * Insert user baru
 * @param string $username
 * @param string $password
 * @param string $nama
 * @param string $role
 * @param string $gambar
 * @return bool
 */
function insertUser($username, $password, $nama, $role, $gambar = 'default.jpg')
{
    $db = getDB();
    $passwordHash = md5($password); // MD5 untuk compatibility

    $stmt = $db->prepare("INSERT INTO user (username, password, nama, role, gambar) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $passwordHash, $nama, $role, $gambar);
    $result = $stmt->execute();
    $stmt->close();
    $db->close();
    return $result;
}

/**
 * Update user
 * @param int $id
 * @param string $username
 * @param string $password (optional, kosongkan jika tidak ganti password)
 * @param string $nama
 * @param string $role
 * @param string $gambar
 * @return bool
 */
function updateUser($id, $username, $password, $nama, $role, $gambar)
{
    $db = getDB();

    if (!empty($password)) {
        // Update dengan password baru
        $passwordHash = md5($password);
        $stmt = $db->prepare("UPDATE user SET username=?, password=?, nama=?, role=?, gambar=? WHERE id_user=?");
        $stmt->bind_param("sssssi", $username, $passwordHash, $nama, $role, $gambar, $id);
    } else {
        // Update tanpa ubah password
        $stmt = $db->prepare("UPDATE user SET username=?, nama=?, role=?, gambar=? WHERE id_user=?");
        $stmt->bind_param("ssssi", $username, $nama, $role, $gambar, $id);
    }

    $result = $stmt->execute();
    $stmt->close();
    $db->close();
    return $result;
}

/**
 * Delete user
 * @param int $id
 * @return bool
 */
function deleteUser($id)
{
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM user WHERE id_user = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    $db->close();
    return $result;
}

/**
 * Count total user with role 'User' only
 * @return int
 */
function countUserOnly()
{
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM user WHERE role = 'User'");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $data['total'];
}

/**
 * Count total user (all roles)
 * @return int
 */
function countUser()
{
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM user");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $data['total'];
}

/**
 * Ensure booking table exists
 */
function createBookingTable()
{
    $db = getDB();
    $query = "CREATE TABLE IF NOT EXISTS booking (
        id_booking INT(11) NOT NULL AUTO_INCREMENT,
        user_id INT(11) NOT NULL,
        email VARCHAR(100) NOT NULL,
        nama VARCHAR(100) NOT NULL,
        telepon VARCHAR(20) NOT NULL,
        project_name VARCHAR(255) NOT NULL,
        booking_date DATE NOT NULL,
        address TEXT NOT NULL,
        notes TEXT,
        status VARCHAR(20) NOT NULL DEFAULT 'Pending',
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id_booking)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $db->query($query);
    $db->close();
}

/**
 * Insert booking request
 * @param int $userId
 * @param string $email
 * @param string $nama
 * @param string $telepon
 * @param string $projectName
 * @param string $bookingDate
 * @param string $address
 * @param string $notes
 * @return bool
 */
function insertBooking($userId, $email, $nama, $telepon, $projectName, $bookingDate, $address, $notes)
{
    createBookingTable();
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO booking (user_id, email, nama, telepon, project_name, booking_date, address, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $userId, $email, $nama, $telepon, $projectName, $bookingDate, $address, $notes);
    $result = $stmt->execute();
    $stmt->close();
    $db->close();
    return $result;
}

/**
 * Get bookings for a user
 * @param int $userId
 * @return array
 */
function getBookingsByUser($userId)
{
    createBookingTable();
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM booking WHERE user_id = ? ORDER BY booking_date ASC, created_at DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
    return $data;
}

/**
 * Count bookings for a user
 * @param int $userId
 * @return int
 */
function countBookingsByUser($userId)
{
    createBookingTable();
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM booking WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $data['total'];
}

/**
 * Get all bookings for admin
 * @return array
 */
function getAllBookings()
{
    createBookingTable();
    $db = getDB();
    $stmt = $db->prepare("SELECT b.*, u.nama as user_nama, u.username as user_username, u.gambar as user_gambar FROM booking b JOIN user u ON b.user_id = u.id_user ORDER BY b.created_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
    return $data;
}

/**
 * Count bookings by status
 * @param string $status
 * @return int
 */
function countBookingsByStatus($status)
{
    createBookingTable();
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM booking WHERE status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $data['total'];
}

/**
 * Get recent bookings (limit 5)
 * @return array
 */
function getRecentBookings($limit = 5)
{
    createBookingTable();
    $db = getDB();
    $stmt = $db->prepare("SELECT b.*, u.nama as user_nama, u.gambar as user_gambar FROM booking b JOIN user u ON b.user_id = u.id_user ORDER BY b.created_at DESC LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
    return $data;
}

/**
 * Update booking status
 * @param int $bookingId
 * @param string $status
 * @return bool
 */
function updateBookingStatus($bookingId, $status)
{
    createBookingTable();
    $db = getDB();
    $stmt = $db->prepare("UPDATE booking SET status = ? WHERE id_booking = ?");
    $stmt->bind_param("si", $status, $bookingId);
    $result = $stmt->execute();
    $stmt->close();
    $db->close();
    return $result;
}

/**
 * Count total bookings (all users)
 * @return int
 */
function countTotalBookings()
{
    createBookingTable();
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM booking");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $data['total'];
}

// ============================================
// HELPER FUNCTIONS
// ============================================

/**
 * Format tanggal ke bahasa Indonesia
 * @param string $tanggal
 * @return string
 */
function formatTanggal($tanggal)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $pecah = explode('-', $tanggal);
    return $pecah[2] . ' ' . $bulan[(int) $pecah[1]] . ' ' . $pecah[0];
}

/**
 * Upload gambar
 * @param array $file ($_FILES['nama_input'])
 * @param string $folder (default: '../img/')
 * @return string|false (nama file atau false jika gagal)
 */
function uploadGambar($file, $folder = '../img/')
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    // Allowed extensions
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        return false;
    }

    // Generate unique filename
    $filename = uniqid() . '_' . time() . '.' . $ext;
    $destination = $folder . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $filename;
    }

    return false;
}
?>