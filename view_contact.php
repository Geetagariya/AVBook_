<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
// check connection
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

// fetch data
$query = "SELECT * FROM contact";
$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .delete-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .delete-btn:hover {
            background: #cc0000;
        }
        
        /* Popup Styles - Improved */
        #deletePopup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-in-out;
        }
        
        #popupContent {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transform: scale(0.8);
            animation: popupSlideIn 0.3s ease-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes popupSlideIn {
            to {
                transform: scale(1);
            }
        }
        
        .popup-title {
            color: #d32f2f;
            margin: 0 0 15px 0;
            font-size: 24px;
        }
        
        .popup-message {
            color: #333;
            margin-bottom: 25px;
            font-size: 16px;
            line-height: 1.5;
        }
        
        .btn-yes {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        
        .btn-yes:hover {
            background: #b71c1c;
        }
        
        .btn-no {
            background: #757575;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        
        .btn-no:hover {
            background: #424242;
        }
    </style>
</head>
<body>

<h2>Contact Messages</h2>

<table>
<tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Mobile</th>
    <th>Email</th>
    <th>Message</th>
    <th>Action</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($result)){
?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['first_name']; ?></td>   
    <td><?php echo $row['last_name']; ?></td> 
    <td><?php echo $row['mobile']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['message']; ?></td>
    
    <td>
        <button class="delete-btn" onclick="openPopup(<?php echo $row['id']; ?>)">
            Delete
        </button>
    </td>
</tr>
<?php } ?>

</table>

<!-- IMPROVED DELETE POPUP -->
<div id="deletePopup">
    <div id="popupContent">
        <h3 class="popup-title">Confirm Delete</h3>
        <p class="popup-message">Are you sure you want to delete this contact? This action cannot be undone.</p>
        
        <a id="confirmDelete" href="#" class="btn-yes">Yes, Delete</a>
        <button onclick="closePopup()" class="btn-no">No, Cancel</button>
    </div>
</div>

<script>
let currentId = null;

function openPopup(id) {
    currentId = id;
    document.getElementById("deletePopup").style.display = "flex";
    document.getElementById("confirmDelete").href = "delete_contact.php?id=" + id;
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function closePopup() {
    document.getElementById("deletePopup").style.display = "none";
    currentId = null;
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
}

// Close popup when clicking outside
document.getElementById("deletePopup").addEventListener('click', function(e) {
    if (e.target === this) {
        closePopup();
    }
});

// Close with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePopup();
    }
});
</script>

</body>
</html>

<?php
mysqli_close($conn);
?>