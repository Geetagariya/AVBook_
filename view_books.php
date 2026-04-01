<?php
$conn = mysqli_connect("localhost","root","","avbook_db",3307);

// DELETE BOOK with status
$delete_status = '';
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    if(mysqli_query($conn, "DELETE FROM books WHERE id=$id")){
        $delete_status = 'success';
    } else {
        $delete_status = 'error';
    }
}

// DATA - Serial wise
$result = mysqli_query($conn, "SELECT * FROM books ORDER BY id ASC");
$total_books = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Library Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Poppins',sans-serif;background:white;min-height:100vh;padding:20px;}
        .container{max-width:1400px;margin:0 auto;}
        .header{text-align:center;margin-bottom:30px;color:#000080;}
        .header h1{font-size:2.5rem;margin-bottom:10px;background:#00008B;-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
        .header p{font-size:1.1rem;opacity:0.9;}
        
        /* SEARCH BAR BACK */
        .controls{
            background:rgba(255,255,255,0.1);backdrop-filter:blur(20px);border-radius:20px;
            padding:25px;margin-bottom:30px;border:1px solid rgba(255,255,255,0.2);
        }
        .search-box{position:relative;max-width:500px;margin:0 auto 20px;}
        .search-box input{
            width:100%;padding:15px 20px 15px 50px;border:none;border-radius:50px;
            font-size:16px;background:rgba(255,255,255,0.95);backdrop-filter:blur(10px);
            box-shadow:0 8px 32px rgba(0,0,0,0.2);transition:all 0.3s;color:#1e3c72;
        }
        .search-box input:focus{outline:none;transform:translateY(-2px);box-shadow:0 12px 40px rgba(30,60,114,0.4);}
        .search-box i{position:absolute;left:20px;top:50%;transform:translateY(-50%);color:#1e3c72;}
        
        .table-container{background:rgba(255,255,255,0.98);backdrop-filter:blur(20px);border-radius:25px;overflow:hidden;box-shadow:0 25px 70px rgba(0,0,0,0.3);}
        table{width:100%;border-collapse:collapse;}
        th{background:linear-gradient(135deg,#1e3c72 0%,#2a5298 100%);color:white;padding:20px;text-align:left;font-weight:600;}
        td{padding:20px;border-bottom:1px solid rgba(0,0,0,0.05);transition:all 0.3s ease;}
        tr:hover{background:linear-gradient(135deg,rgba(30,60,114,0.08) 0%,rgba(42,82,152,0.08) 100%);transform:scale(1.01);box-shadow:0 10px 30px rgba(30,60,114,0.2);}
        .pdf-link,.delete-link{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:25px;text-decoration:none;font-weight:500;color:white;transition:all 0.3s;}
        .pdf-link{background:linear-gradient(135deg,#10b981,#059669);}
        .delete-link{background:linear-gradient(135deg,#ef4444,#dc2626);cursor:pointer;}
        .pdf-link:hover,.delete-link:hover{transform:translateY(-3px);box-shadow:0 10px 25px rgba(0,0,0,0.3);}
        .book-image{width:80px;height:60px;object-fit:cover;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,0.2);transition:all 0.3s;}
        .book-image:hover{transform:scale(1.1);box-shadow:0 15px 35px rgba(0,0,0,0.3);}
        .modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);backdrop-filter:blur(15px);z-index:2000;align-items:center;justify-content:center;}
        .modal-content{background:white;padding:40px;border-radius:25px;text-align:center;box-shadow:0 25px 70px rgba(0,0,0,0.4);max-width:400px;width:90%;transform:scale(0.7);animation:modalPop 0.4s ease forwards;}
        @keyframes modalPop{to{transform:scale(1);}}
        .success-icon{font-size:4rem;color:#10b981;margin-bottom:20px;}
        .error-icon{font-size:4rem;color:#ef4444;margin-bottom:20px;}
        .modal h3{color:#1f2937;margin-bottom:15px;font-size:1.5rem;}
        #confirmBox{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);backdrop-filter:blur(15px);z-index:1500;align-items:center;justify-content:center;}
        .confirm-content{background:white;padding:40px;border-radius:25px;text-align:center;max-width:400px;width:90%;box-shadow:0 25px 70px rgba(0,0,0,0.4);transform:scale(0.7);animation:modalPop 0.4s ease forwards;}
        .confirm-content h3{color:#1f2937;margin:20px 0 15px;font-size:1.5rem;}
        .confirm-content p{color:#6b7280;margin-bottom:30px;font-size:16px;}
        .confirm-content button{margin:10px;padding:12px 25px;border:none;border-radius:25px;cursor:pointer;font-weight:500;font-size:16px;min-width:120px;transition:all 0.3s;}
        .delete-btn{background:linear-gradient(135deg,#ef4444,#dc2626);color:white;}
        .delete-btn:hover{transform:translateY(-2px);box-shadow:0 10px 25px rgba(239,68,68,0.4);}
        .cancel-btn{background:linear-gradient(135deg,#6b7280,#4b5563);color:white;}
        .cancel-btn:hover{transform:translateY(-2px);box-shadow:0 10px 25px rgba(107,114,128,0.4);}
        @media(max-width:768px){.container{padding:10px;}.header h1{font-size:2rem;}}
    </style>
</head>
<body>
    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-check-circle success-icon"></i>
            <h3>✅ Book Deleted Successfully!</h3>
            <p>Library updated!</p>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <h3>❌ Delete Failed!</h3>
            <p>Please try again.</p>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1><i class="fas fa-book-open"></i> Library Books</h1>
            <p>Total: <strong><?php echo $total_books; ?></strong> Books</p>
        </div>

        <!-- ✅ SEARCH BAR ADDED BACK -->
        <div class="controls">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="🔍 Search by title, author or branch..." onkeyup="searchTable()">
            </div>
        </div>

        <div class="table-container">
            <table id="booksTable">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> ID</th>
                        <th><i class="fas fa-book"></i> Title</th>
                        <th><i class="fas fa-user"></i> Author</th>
                        <th><i class="fas fa-building"></i> Branch</th>
                        <th><i class="fas fa-file-pdf"></i> PDF</th>
                        <th><i class="fas fa-image"></i> Image</th>
                        <th><i class="fas fa-cogs"></i> Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    mysqli_data_seek($result, 0);
                    if($total_books > 0) {
                        while($row = mysqli_fetch_assoc($result)) { 
                    ?>
                    <tr>
                        <td><strong>#<?php echo $row['id']; ?></strong></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                        <td><span style="background:rgba(30,60,114,0.2);padding:6px 14px;border-radius:20px;color:#1e3c72;font-weight:500;"><?php echo htmlspecialchars($row['branch']); ?></span></td>
                        <td><a href="PDF/book_pdf/<?php echo $row['branch']; ?>/<?php echo $row['file']; ?>" target="_blank" class="pdf-link"><i class="fas fa-eye"></i> View</a></td>
                        <td><?php if($row['image']!=''): ?><img src="images/books/<?php echo $row['image']; ?>" class="book-image"><?php else: ?><span style="color:#9ca3af;font-style:italic;">No Image</span><?php endif; ?></td>
						<td>
    <!-- EDIT BUTTON -->
    <a href="edit_book.php?id=<?php echo $row['id']; ?>" 
       style="background:linear-gradient(135deg,#f59e0b,#d97706);color:white;padding:10px 20px;border-radius:25px;text-decoration:none;margin-right:10px;display:inline-block;">
        <i class="fas fa-edit"></i> Edit
    </a>
                        <a href="#" onclick="confirmDelete(<?php echo $row['id']; ?>)" class="delete-link"><i class="fas fa-trash"></i> Delete</a></td>
                    </tr>
                    <?php }} else { ?>
                    <tr><td colspan="7" style="padding:60px;color:#9ca3af;text-align:center;"><i class="fas fa-books" style="font-size:4rem;margin-bottom:20px;opacity:0.5;"></i><br>No Books</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 🔥 DOUBLE CONFIRM POPUP -->
    <div id="confirmBox">
        <div class="confirm-content">
            <i class="fas fa-exclamation-triangle" style="font-size:3rem;color:#f59e0b;margin-bottom:20px;"></i>
            <h3>🗑️ Confirm Delete?</h3>
            <p>Are you <strong>SURE</strong> you want to delete this book?<br><small>This action <strong>CANNOT</strong> be undone!</small></p>
            <button class="delete-btn" onclick="deleteBook()">🗑️ Yes, Delete Forever</button>
            <button class="cancel-btn" onclick="closeBox()">❌ Cancel</button>
        </div>
    </div>

    <script>
        let deleteId = null;

        // ✅ AUTO SHOW DELETE MODAL
        <?php if($delete_status=='success'): ?>
            setTimeout(() => document.getElementById('successModal').style.display='flex', 100);
            setTimeout(() => {
    window.location.href = "view_books.php";
}, 2500);
        <?php elseif($delete_status=='error'): ?>
            setTimeout(() => document.getElementById('errorModal').style.display='flex', 100);
            setTimeout(() => location.reload(), 3000);
        <?php endif; ?>

        // 🔍 LIVE SEARCH
        function searchTable(){
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#booksTable tbody tr');
            rows.forEach(row => {
                let visible = false;
                row.querySelectorAll('td').forEach(td => {
                    if(td.textContent.toLowerCase().includes(input)) visible = true;
                });
                row.style.display = visible ? '' : 'none';
            });
        }

        // DOUBLE CONFIRM
        function confirmDelete(id){
            deleteId = id;
            document.getElementById('confirmBox').style.display = 'flex';
        }
        function closeBox(){ document.getElementById('confirmBox').style.display = 'none'; }
        function deleteBook(){ window.location.href = '?delete='+deleteId; }

        
		
		// Close modals (FIXED)
['successModal','errorModal','confirmBox'].forEach(id => {
    document.getElementById(id).onclick = e => {
        if(e.target === document.getElementById(id)){
            document.getElementById(id).style.display='none';
        }
    }
});

        // NO REVEAL EFFECT - Simple hover only
        document.addEventListener('DOMContentLoaded', () => {
            // Only hover effects, no staggered animation
        });
    </script>
</body>
</html>