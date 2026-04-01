<?php
$conn = mysqli_connect("localhost","root","","avbook_db",3307);

if(!$conn){
    die("Connection Failed");
}

// Get all notes with proper numbering
$query = "SELECT * FROM notes ORDER BY id ASC";
$result = mysqli_query($conn, $query);
$notes = [];
$counter = 1;

while($row = mysqli_fetch_assoc($result)){
    $row['display_id'] = $counter++;
    $notes[] = $row;
}

// Stats calculation
$total_notes = count($notes);
$branches = array_unique(array_column($notes, 'branch'));
$total_branches = count($branches);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>📚 All Notes - AVBook</title>

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<!-- Google Fonts - Inter for Professional Look -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    background: #f8fafc;
    color: #1e293b;
    line-height: 1.6;
}

.container-main {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

.page-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 3rem;
    margin: 2rem 0;
    box-shadow: 0 25px 70px rgba(0,0,0,0.08);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 2rem;
}

.header-title {
    display: flex;
    align-items: center;
    gap: 15px;
    font-size: 2.8rem;
    font-weight: 700;
    color: #0f172a;
}

.header-title i {
    color: #1d4ed8;
    font-size: 3.2rem;
}

.stats-bar {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.stat-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.5rem 2rem;
    text-align: center;
    min-width: 150px;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.stat-card:hover {
    border-color: #1d4ed8;
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(29,78,216,0.15);
}

.stat-number {
    font-size: 2.2rem;
    font-weight: 700;
    color: #1d4ed8;
    display: block;
}

.stat-label {
    font-size: 0.95rem;
    color: #64748b;
    margin-top: 5px;
    font-weight: 500;
}

/* Search Section */
.search-section {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 3rem;
    box-shadow: 0 20px 60px rgba(0,0,0,0.08);
}

.search-input {
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    padding: 20px 28px;
    font-size: 1.1rem;
    background: #fafbfc;
    transition: all 0.3s ease;
    width: 100%;
    font-family: 'Inter', sans-serif;
}

.search-input:focus {
    border-color: #1d4ed8;
    box-shadow: 0 0 0 4px rgba(29,78,216,0.1);
    background: #ffffff;
    outline: none;
    transform: translateY(-2px);
}

.notes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
    gap: 2.5rem;
}

.note-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 2.5rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.08);
}

.note-card:hover {
    border-color: #1d4ed8;
    box-shadow: 0 35px 80px rgba(29,78,216,0.15);
    transform: translateY(-12px);
}

.note-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #1d4ed8, #1e40af);
}

.note-id {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    color: white;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    box-shadow: 0 10px 25px rgba(29,78,216,0.3);
    transition: all 0.3s ease;
}

.note-card:hover .note-id {
    transform: scale(1.1);
}

.note-title {
    font-size: 1.45rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 1.5rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.note-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2rem;
}

.meta-tag {
    background: #f8fafc;
    color: #475569;
    padding: 0.75rem 1.25rem;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.note-card:hover .meta-tag {
    background: #f1f5f9;
    border-color: #cbd5e0;
}

.btn-custom {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    border: none;
    border-radius: 16px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(107,114,128,0.3);
    color: white;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
}

.btn-custom:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    box-shadow: 0 15px 35px rgba(107,114,128,0.4);
    transform: translateY(-3px);
    color: white !important;
}

.btn-primary-custom {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    border: none;
    border-radius: 16px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(29,78,216,0.3);
    color: white;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
}

.btn-primary-custom:hover {
    background: linear-gradient(135deg, #1e40af, #1d4ed8);
    box-shadow: 0 15px 35px rgba(29,78,216,0.4);
    transform: translateY(-3px);
    color: white !important;
}

.btn-danger-custom {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    border-radius: 16px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(239,68,68,0.3);
    color: white;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
}

.btn-danger-custom:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    box-shadow: 0 15px 35px rgba(239,68,68,0.4);
    transform: translateY(-3px);
    color: white !important;
}

.btn-group {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.empty-state {
    text-align: center;
    padding: 6rem 2rem;
    color: #64748b;
    grid-column: 1 / -1;
}

.empty-icon {
    font-size: 6rem;
    color: #cbd5e0;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .notes-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .stats-bar {
        justify-content: center;
    }
    
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-custom, .btn-primary-custom, .btn-danger-custom {
        justify-content: center;
    }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.note-card {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
    animation-fill-mode: forwards;
}
</style>
</head>

<body>
<div class="container-main">
    <div class="page-header">
        <div class="header-content">
            <div class="header-title">
                <i class="fas fa-book-reader"></i>
                All Notes
            </div>
            <div class="stats-bar">
                <div class="stat-card">
                    <span class="stat-number"><?php echo $total_notes; ?></span>
                    <span class="stat-label">Total Notes</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number"><?php echo $total_branches; ?></span>
                    <span class="stat-label">Branches</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="search-section">
        <input type="text" class="search-input" id="searchInput" 
               placeholder="🔍 Search by title, branch, semester or type...">
    </div>

    <div class="notes-grid" id="notesGrid">
        <?php if(empty($notes)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b;">
                    No notes available
                </h2>
                <p style="font-size: 1.2rem;">Notes will appear here once uploaded.</p>
            </div>
        <?php else: ?>
            <?php foreach($notes as $index => $note): ?>
            <div class="note-card" 
                 data-title="<?php echo strtolower($note['title']); ?>" 
                 data-branch="<?php echo strtolower($note['branch']); ?>" 
                 data-semester="<?php echo strtolower($note['semester']); ?>"
                 style="animation-delay: <?php echo $index * 0.1; ?>s;">
                
                <div class="note-id">#<?php echo $note['display_id']; ?></div>
                
                <h3 class="note-title"><?php echo htmlspecialchars($note['title']); ?></h3>
                
                <div class="note-meta">
                    <span class="meta-tag">
                        <i class="fas fa-university"></i><?php echo ucfirst($note['branch']); ?>
                    </span>
                    <span class="meta-tag">
                        <i class="fas fa-calendar-alt"></i>Sem <?php echo $note['semester']; ?>
                    </span>
                    <span class="meta-tag">
                        <i class="fas fa-file-alt"></i><?php echo strtoupper($note['type']); ?>
                    </span>
                </div>
                
                <div class="btn-group">
                    <!-- ✅ FIXED EDIT BUTTON WITH PROPER HOVER -->
                    <a href="edit_note.php?id=<?php echo $note['id']; ?>" class="btn-custom">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo $note['file_path']; ?>" class="btn-primary-custom" download>
                        <i class="fas fa-download"></i> Download
                    </a>
                    <button class="btn-danger-custom" onclick="confirmDelete(<?php echo $note['id']; ?>)">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    const cards = document.querySelectorAll('.note-card');
    
    cards.forEach(card => {
        const title = card.dataset.title;
        const branch = card.dataset.branch;
        const semester = card.dataset.semester;
        
        const matches = title.includes(searchTerm) || 
                       branch.includes(searchTerm) || 
                       semester.includes(searchTerm);
        
        if(matches) {
            card.style.display = 'block';
            card.style.opacity = '0';
            setTimeout(() => {
                card.style.transition = 'all 0.4s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 10);
        } else {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.display = 'none';
            }, 300);
        }
    });
});

// Delete Confirmation
function confirmDelete(id) {
    Swal.fire({
        title: 'Confirm Delete',
        html: `
            <div style="text-align: left; padding: 1rem 0;">
                <p style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">
                    <i class="fas fa-exclamation-triangle" style="color: #f59e0b; margin-right: 0.5rem;"></i>
                    Are you sure you want to delete this note?
                </p>
                <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 0;">
                    This action cannot be undone.
                </p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-trash me-1"></i> Delete',
        cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#808080',
        buttonsStyling: true,
        reverseButtons: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `?delete=${id}`;
        }
    });
}
</script>

<?php
// Delete Handler
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    
    $note_query = "SELECT title FROM notes WHERE id='$id'";
    $note_result = mysqli_query($conn, $note_query);
    $note_title = '';
    
    if($note_row = mysqli_fetch_assoc($note_result)) {
        $note_title = $note_row['title'];
    }
    
    $delete = "DELETE FROM notes WHERE id='$id'";
    if(mysqli_query($conn, $delete)){
        echo "
        <script>
        Swal.fire({
            title: 'Deleted Successfully!',
            html: '<strong>&quot;$note_title&quot;</strong> has been deleted permanently.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#10b981',
            timer: 2500,
            timerProgressBar: true
        }).then(()=>{
            window.location.href='view_notes.php';
        });
        </script>
        ";
    } else {
        echo "
        <script>
        Swal.fire({
            title: 'Error!',
            text: 'Failed to delete note. Please try again.',
            icon: 'error',
            confirmButtonColor: '#ef4444'
        });
        </script>
        ";
    }
}
?>

</body>
</html>