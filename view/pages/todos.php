<?php
//if (isset($_SESSION['user'])){
//    header('Location: /login');
//}
//?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c4497f215d.js" crossorigin="anonymous"></script>
    <title>TODO App</title>
    <title>To-do List</title>
    <style>
        .status {
            text-decoration: line-through;
        }
    </style>
</head>
<body>
<?php
require 'view/partials/navbar.php';
?>
<div class="container mt-4">
    <h1 class="mt-5">To-do List</h1>
    <form action="/todos" method="POST" class="mb-3">
        <div class="input-group">
            <input type="hidden" name="action" value="add">
            <input type="text" name="title" class="form-control" placeholder="New to-do" required>
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Add</button>
            </div>
        </div>
    </form>
    <ul class="list-group">
        <?php global $todos ?>
        <?php foreach ($todos as $todo): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <form action="/toggle" method="POST" class="mr-3">
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">
                    <input type="checkbox"
                           onChange="this.form.submit()" <?php if ($todo['status']) echo 'checked'; ?>>
                </form>
                <span class="<?php echo $todo['status'] ? 'status' : ''; ?>">
                    <?php echo htmlspecialchars($todo['title']); ?>
                </span>
                <a href="/delete?id=<?php echo $todo['id']; ?>"
                   class="btn btn-danger btn-sm">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>