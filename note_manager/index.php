<?php
require_once 'config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $title = $_POST['title'];
                $content = $_POST['content'];
                $stmt = $pdo->prepare("INSERT INTO notes (title, content, created_at) VALUES (?, ?, NOW())");
                $stmt->execute([$title, $content]);
                $_SESSION['message'] = 'Note added successfully!';
                break;
                
            case 'update':
                $id = $_POST['id'];
                $title = $_POST['title'];
                $content = $_POST['content'];
                $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ?");
                $stmt->execute([$title, $content, $id]);
                $_SESSION['message'] = 'Note updated successfully!';
                break;
                
            case 'delete':
                $id = $_POST['id'];
                $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
                $stmt->execute([$id]);
                $_SESSION['message'] = 'Note deleted successfully!';
                break;

            case 'get_note':
                $id = $_POST['id'];
                $stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
                $stmt->execute([$id]);
                $note = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($note);
                exit;
        }
    }
    header('Location: index.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM notes ORDER BY created_at DESC");
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .note-card {
            margin-bottom: 20px;
        }
        .edit-buttons {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Note Manager</h1>
        
        <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Add New Note</h5>
                <form method="POST" id="noteForm">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id" id="noteId">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Save Note</button>
                    <button type="button" class="btn btn-secondary" id="cancelBtn" style="display: none;" onclick="resetForm()">Cancel</button>
                </form>
            </div>
        </div>

        <div class="row">
            <?php foreach ($notes as $note): ?>
            <div class="col-md-4">
                <div class="card note-card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($note['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($note['content']); ?></p>
                        <p class="text-muted">Created: <?php echo date('m/d/Y H:i', strtotime($note['created_at'])); ?></p>
                        <div class="edit-buttons">
                            <button type="button" class="btn btn-primary btn-sm" onclick="editNote(<?php echo $note['id']; ?>)">Edit</button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $note['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this note?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editNote(id) {
            fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=get_note&id=' + id
            })
            .then(response => response.json())
            .then(note => {
                document.getElementById('noteId').value = note.id;
                document.getElementById('title').value = note.title;
                document.getElementById('content').value = note.content;
                document.getElementById('noteForm').action.value = 'update';
                document.getElementById('submitBtn').textContent = 'Update Note';
                document.getElementById('cancelBtn').style.display = 'inline-block';
            });
        }

        function resetForm() {
            document.getElementById('noteForm').reset();
            document.getElementById('noteId').value = '';
            document.getElementById('noteForm').action.value = 'add';
            document.getElementById('submitBtn').textContent = 'Save Note';
            document.getElementById('cancelBtn').style.display = 'none';
        }

        document.getElementById('noteForm').addEventListener('submit', function(e) {
            const actionInput = this.querySelector('input[name="action"]');
            actionInput.value = document.getElementById('noteId').value ? 'update' : 'add';
        });
    </script>
</body>
</html>
