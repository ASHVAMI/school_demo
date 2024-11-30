
<?php
require_once 'config/database.php';
require_once 'classes/Student.php';

$student = new Student($pdo);
$students = $student->getAllStudents();
include 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Students</h1>
    <a href="create.php" class="btn btn-primary">Add New Student</a>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Class</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td>
                    <?php if ($student['image']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" 
                             alt="Student Image" class="img-thumbnail" style="width: 50px;">
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($student['name']); ?></td>
                <td><?php echo htmlspecialchars($student['email']); ?></td>
                <td><?php echo htmlspecialchars($student['class_name']); ?></td>
                <td><?php echo date('Y-m-d', strtotime($student['created_at'])); ?></td>
                <td>
                    <a href="view.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-info">View</a>
                    <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?php echo $student['id']; ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
