
<?php
require_once 'config/database.php';
require_once 'classes/Student.php';

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

include 'includes/header.php';
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Student Details</h1>
        <a href="index.php" class="btn btn-secondary">Back to List</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <?php if ($studentData['image']): ?>
                    <img src="uploads/<?php echo htmlspecialchars($studentData['image']); ?>" 
                         alt="Student Image" 
                         class="img-fluid rounded">
                <?php else: ?>
                    <div class="alert alert-info">No image available</div>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <table class="table">
                    <tr>
                        <th width="150">Name:</th>
                        <td><?php echo htmlspecialchars($studentData['name']); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($studentData['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td><?php echo nl2br(htmlspecialchars($studentData['address'])); ?></td>
                    </tr>
                    <tr>
                        <th>Class:</th>
                        <td><?php echo htmlspecialchars($studentData['class_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td><?php echo date('F j, Y g:i A', strtotime($studentData['created_at'])); ?></td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="edit.php?id=<?php echo $studentData['id']; ?>" 
                       class="btn btn-warning">Edit Student</a>
                    <a href="delete.php?id=<?php echo $studentData['id']; ?>" 
                       class="btn btn-danger" 
                       onclick="return confirm('Are you sure you want to delete this student?')">
                        Delete Student
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
