// delete.php
<?php
require_once 'config/database.php';
require_once 'classes/Student.php';
require_once 'includes/utilities.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$student = new Student($pdo);
$studentData = $student->getStudent($_GET['id']);

if (!$studentData) {
    header("Location: index.php");
    exit;
}

// If confirmation is received
if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    // Delete the image file if it exists
    if ($studentData['image']) {
        deleteImage($studentData['image']);
    }
    
    // Delete the student record
    if ($student->deleteStudent($_GET['id'])) {
        header("Location: index.php");
        exit;
    }
}

include 'includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <h1>Delete Student</h1>
    </div>
    <div class="card-body">
        <p class="alert alert-danger">
            Are you sure you want to delete the student "<?php echo htmlspecialchars($studentData['name']); ?>"?
            This action cannot be undone.
        </p>
        
        <form method="post">
            <input type="hidden" name="confirm" value="yes">
            <button type="submit" class="btn btn-danger">Yes, Delete Student</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
