
<?php
require_once 'config/database.php';
require_once 'classes/ClassRoom.php';

$classroom = new ClassRoom($pdo);
$classes = $classroom->getAllClasses();

$errors = [];
$success = '';

// Handle class creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create':
            if (!empty($_POST['name'])) {
                if ($classroom->createClass($_POST['name'])) {
                    $success = "Class created successfully";
                    header("Location: classes.php");
                    exit;
                } else {
                    $errors[] = "Error creating class";
                }
            } else {
                $errors[] = "Class name is required";
            }
            break;
            
        case 'update':
            if (!empty($_POST['name']) && !empty($_POST['class_id'])) {
                if ($classroom->updateClass($_POST['class_id'], $_POST['name'])) {
                    $success = "Class updated successfully";
                    header("Location: classes.php");
                    exit;
                } else {
                    $errors[] = "Error updating class";
                }
            }
            break;
            
        case 'delete':
            if (!empty($_POST['class_id'])) {
                if ($classroom->deleteClass($_POST['class_id'])) {
                    $success = "Class deleted successfully";
                    header("Location: classes.php");
                    exit;
                } else {
                    $errors[] = "Error deleting class";
                }
            }
            break;
    }
}

include 'includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <h1>Manage Classes</h1>
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
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <!-- Add New Class Form -->
        <form method="post" class="mb-4">
            <input type="hidden" name="action" value="create">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" 
                           name="name" 
                           class="form-control" 
                           placeholder="Enter new class name" 
                           required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Add New Class</button>
                </div>
            </div>
        </form>

        <!-- Classes List -->
        <table class="table">
            <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($class['name']); ?></td>
                        <td><?php echo date('F j, Y', strtotime($class['created_at'])); ?></td>
                        <td>
                            <button type="button" 
                                    class="btn btn-sm btn-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal<?php echo $class['class_id']; ?>">
                                Edit
                            </button>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="class_id" value="<?php echo $class['class_id']; ?>">
                                <button type="submit" 
                                        class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Are you sure? This will delete all students in this class!')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    
                    <!-- Edit Modal for each class -->
                    <div class="modal fade" id="editModal<?php echo $class['class_id']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="class_id" value="<?php echo $class['class_id']; ?>">
                                    
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Class</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name<?php echo $class['class_id']; ?>" class="form-label">
                                                Class Name
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="name<?php echo $class['class_id']; ?>" 
                                                   name="name" 
                                                   value="<?php echo htmlspecialchars($class['name']); ?>" 
                                                   required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
