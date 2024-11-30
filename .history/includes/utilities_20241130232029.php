// includes/utilities.php
<?php
function uploadImage($file) {
    if ($file['error'] !== 0) {
        return ['success' => false, 'error' => 'File upload failed'];
    }

    $allowed = ['jpg', 'jpeg', 'png'];
    $file_name = $file['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    if (!in_array($file_ext, $allowed)) {
        return ['success' => false, 'error' => 'Invalid file format'];
    }
    
    $new_name = uniqid() . "." . $file_ext;
    $upload_path = "uploads/" . $new_name;
    
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        return ['success' => true, 'filename' => $new_name];
    }
    
    return ['success' => false, 'error' => 'Failed to move uploaded file'];
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
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($data['class_id'])) {
        $errors[] = "Class is required";
    }
    
    return $errors;
}
?>
