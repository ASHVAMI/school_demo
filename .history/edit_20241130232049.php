// edit.php
<?php
require_once 'config/database.php';
require_once 'classes/Student.php';
require_once 'classes/ClassRoom.php';
require_once 'includes/utilities.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$student = new Student($pdo);
$classroom = new ClassRoom($pdo);

$studentData = $student->getStudent($_GET['id']);
$classes = $classroom->getAllClasses();

if (!$studentData) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'address' => $_POST['address'] ?? '',
        'class_id' => $_POST['class_id'] ?? ''
    ];
    
    $errors = validateStudent($data);
    
    $image_name = $studentData['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_result = uploadImage($_FILES['image']);
        if ($upload_result['success']) {
            // Delete old image if exists
            if ($image_name) {
                deleteImage($image_name);
            }
            $image_name = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['error'];
        }
    }
    
    if (empty($errors)) {
        if ($student->updateStudent(
            $_GET['id'],
            $data['name'],
            $data['email'],
            $data['address'],
            $data['class_id'],
            $image_name
        )) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Error updating student";
        }
    }
}

include 'includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <h1>Edit Student</h1>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" 
                               class="form-control" 
                               id="name" 
                               name="name" 
                               value="<?php echo htmlspecialchars($studentData['name']); ?>" 
                               required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control" 
                               id="email" 
                               name="email" 
                               value="<?php echo htmlspecialchars($studentData['email']); ?>" 
                               required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" 
                                  id="address" 
                                  name="address" 
                                  rows="3"><?php echo htmlspecialchars($studentData['address']); ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-control" id="class_id" name="class_id" required>
                            <option value="">Select Class</option>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?php echo $class['class_id']; ?>" 
                                        <?php echo ($class['class_id'] == $studentData['class_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($class['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label">Current Image</label>
                        <?php if ($studentData['image']): ?>
                            <img src="uploads/<?php echo htmlspecialchars($studentData['image']); ?>" 
                                 alt="Current Image" 
                                 class="img-fluid rounded mb-2">
                        <?php else: ?>
                            <div class="alert alert-info">No image uploaded</div>
                        <?php endif; ?>
                        
                        <input type="file" class="form-control mt-2" id="image" name="image">
                        <small class="form-text text-muted">Leave empty to keep current image</small>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update Student</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
