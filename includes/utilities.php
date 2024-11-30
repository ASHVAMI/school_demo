
<?php
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function uploadImage($file) {
    $target_dir = "uploads/";
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $max_size = 5 * 1024 * 1024; // 5MB

    // Validate file type
    if (!in_array($file['type'], $allowed_types)) {
        return [
            'success' => false,
            'message' => 'Only JPG, JPEG & PNG files are allowed'
        ];
    }

    // Validate file size
    if ($file['size'] > $max_size) {
        return [
            'success' => false,
            'message' => 'File size should not exceed 5MB'
        ];
    }

    // Generate unique filename
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $file_name = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $file_name;

    // Upload file
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return [
            'success' => true,
            'filename' => $file_name
        ];
    }

    return [
        'success' => false,
        'message' => 'Failed to upload file'
    ];
}

function deleteImage($filename) {
    $file_path = "uploads/" . $filename;
    if (file_exists($file_path)) {
        return unlink($file_path);
    }
    return false;
}

function validateStudent($data) {
    $errors = [];
    
    if (empty($data['name'])) {
        $errors[] = "Name is required";
    }
    
    if (empty($data['email'])) {
        $errors[] = "Email is required";
    } elseif (!validateEmail($data['email'])) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($data['class_id'])) {
        $errors[] = "Class is required";
    }
    
    return $errors;
}

function flashMessage($message, $type = 'success') {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type
    ];
}

function getFlashMessage() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
