<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
// Fetch all notes
$query = "SELECT * FROM notes ORDER BY branch, semester, title ASC";
$result = mysqli_query($conn, $query);
$notes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $notes[] = $row;
}

// Grouping Logic
$grouped = [];
foreach ($notes as $note) {
    $branch = ucfirst(trim($note['branch']));
    
    if (strtolower($branch) === 'pharmacy') {
        $level = ($note['semester'] == 1) ? "1st Year" : "2nd Year";
    } else {
        $level = "Semester " . $note['semester'];
    }
    
    if (!isset($grouped[$branch])) {
        $grouped[$branch] = [];
    }
    if (!isset($grouped[$branch][$level])) {
        $grouped[$branch][$level] = [];
    }
    $grouped[$branch][$level][] = $note;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ðŸ“š All Notes - AVBook</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            padding: 20px;
            color: #1e293b;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
        }
        .header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
        }
        .search-box {
            width: 100%;
            max-width: 520px;
            padding: 15px 20px;
            border: 2px solid #cbd5e1;
            border-radius: 12px;
            font-size: 1.1rem;
            margin: 20px 0;
        }
        .accordion {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .item {
            background: linear-gradient(90deg, #1e40af, #2563eb);
            color: white;
            padding: 18px 24px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            font-size: 1.18rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
        }
        .item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
        }
        .content {
            display: none;
            background: white;
            margin-top: 6px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .sub-level {
            padding: 16px 24px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sub-content {
            display: none;
            padding: 10px 0;
        }
        .note-row {
            padding: 14px 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }
        .note-row:hover {
            background: #f0f9ff;
        }
        .note-title {
            font-weight: 500;
            flex: 1;
        }
        .btns {
            display: flex;
            gap: 8px;
        }
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            cursor: pointer;
        }
        .edit-btn { background: #64748b; color: white; }
        .download-btn { background: #1e40af; color: white; }
        .delete-btn { background: #ef4444; color: white; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>ðŸ“š All Notes</h1>
        <div style="font-size:1.1rem;">
            Total Notes: <strong><?php echo count($notes); ?></strong>
        </div>
    </div>

    <input type="text" id="searchInput" class="search-box" placeholder="ðŸ” Search by title, branch or semester...">

    <div class="accordion">
        <!-- First Year -->
        <div class="item" onclick="toggle(this)">
            <span><i class="fas fa-book"></i> First Year</span>
            <i class="fas fa-plus"></i>
        </div>
        <div class="content">
            <p style="padding:40px 20px; text-align:center; color:#94a3b8; font-style:italic;">
                Common First Year notes will appear here
            </p>
        </div>

        <?php foreach ($grouped as $branch => $levels): ?>
        <div class="item" onclick="toggle(this)">
            <span>
                <?php 
                $icon = match(strtolower($branch)) {
                    'pharmacy' => 'fas fa-pills',
                    'civil engineering' => 'fas fa-building',
                    'mechanical engineering' => 'fas fa-cogs',
                    'electrical engineering' => 'fas fa-bolt',
                    'electronic engineering', 'electronics engineering' => 'fas fa-microchip',
                    'information technology' => 'fas fa-laptop-code',
                    default => 'fas fa-graduation-cap'
                };
                ?>
                <i class="<?php echo $icon; ?>"></i> <?php echo $branch; ?>
            </span>
            <i class="fas fa-plus"></i>
        </div>
        <div class="content">
            <?php foreach ($levels as $level => $levelNotes): ?>
            <div class="sub-level" onclick="toggleSub(this)">
                <span><?php echo $level; ?> (<?php echo count($levelNotes); ?> notes)</span>
                <i class="fas fa-plus"></i>
            </div>
            <div class="sub-content">
                <?php foreach ($levelNotes as $note): ?>
                <div class="note-row" data-title="<?php echo strtolower(htmlspecialchars($note['title'])); ?>">
                    <div class="note-title">
                        <?php echo htmlspecialchars($note['title']); ?>
                    </div>
                    <div class="btns">
                        <a href="edit_note.php?id=<?php echo $note['id']; ?>" class="btn edit-btn">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?php echo $note['file_path']; ?>" class="btn download-btn" download>
                            <i class="fas fa-download"></i> Download
                        </a>
                        <button onclick="confirmDelete(<?php echo $note['id']; ?>)" class="btn delete-btn">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
// Toggle Main Items (Branch / First Year)
function toggle(el) {
    const content = el.nextElementSibling;
    content.style.display = (content.style.display === 'block') ? 'none' : 'block';
    const icon = el.querySelector('i:last-child');
    icon.classList.toggle('fa-plus');
    icon.classList.toggle('fa-minus');
}

// Toggle Sub Levels (Semester / Year)
function toggleSub(el) {
    const content = el.nextElementSibling;
    content.style.display = (content.style.display === 'block') ? 'none' : 'block';
    const icon = el.querySelector('i');
    icon.classList.toggle('fa-plus');
    icon.classList.toggle('fa-minus');
}

// Search Functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const term = this.value.toLowerCase().trim();
    
    document.querySelectorAll('.note-row').forEach(row => {
        const title = row.getAttribute('data-title');
        if (title.includes(term)) {
            row.style.display = 'flex';
            let sub = row.parentElement;
            if (sub) sub.style.display = 'block';
            let main = sub ? sub.parentElement : null;
            if (main) main.style.display = 'block';
        } else {
            row.style.display = 'none';
        }
    });
});

function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This note will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `?delete=${id}`;
        }
    });
}
</script>

<?php
// Delete Handler
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $getTitle = mysqli_query($conn, "SELECT title FROM notes WHERE id = '$id'");
    $titleRow = mysqli_fetch_assoc($getTitle);
    $noteTitle = $titleRow ? $titleRow['title'] : 'Note';

    if (mysqli_query($conn, "DELETE FROM notes WHERE id = '$id'")) {
        echo "<script>
            Swal.fire({
                title: 'Deleted!',
                text: '$noteTitle has been deleted successfully.',
                icon: 'success',
                timer: 2500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'view_notes.php';
            });
        </script>";
    }
}
mysqli_close($conn);
?>
</body>
</html>