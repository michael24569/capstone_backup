<?php
session_start();

require_once 'security_check.php';
checkAdminAccess();

require("db-connection.php");

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

    // Fetch search query
    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $sql = "SELECT * FROM staff";
    
    if ($searchQuery != '') {
        $sql .= " WHERE fullname LIKE '%$searchQuery%'";
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $newStatus = mysqli_real_escape_string($conn, $_POST['status']);

    // Update the status in the database
    $sql = "UPDATE staff SET accountStatus = '$newStatus' WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff Accounts</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Michroma&display=swap">

    <link rel="stylesheet" href="style1.css">
</head>
<body style="background: #071c14;">

<?php include 'admin_sidebar.php'; ?>


    <div id="statusAccount" class="center_record">
        <div class="table-responsive">
            <h1 id="header1">Manage  Accounts</h1>
            <br>
            <a href="register.php" class="btn btn-primary btn-add">Add new staff account</a>
                <br>
                
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search Staff" value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <br>
                    <button class='btn btn-search' type="submit">Search</button>
                    <div class="emailUpdate">
                    <a href="admin_emailUpdate.php" class="btn btn-search">Update my Email</a>
                    </div>
                </div>
            </form>

            <table class="styled-table text-center">
                <thead>
                    <tr class="bg-dark text-black">
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Account Status</th>
                        <th>Action</th>           
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo strtolower(htmlspecialchars($row['fullname'])); ?></td>
                        <td><?php echo strtolower(htmlspecialchars($row['username'])); ?></td>
                        <td><?php echo strtolower(htmlspecialchars($row['email'])); ?></td>
                        <td id="status-<?php echo $row['id']; ?>"><?php echo strtolower(htmlspecialchars($row['accountStatus'])); ?></td>
<td class="action-button">
    <button 
        id="status-btn-<?php echo $row['id']; ?>" 
        class="btn btn-primary <?php echo $row['accountStatus'] == 'Active' ? 'btn-red' : 'btn-green'; ?>" 
        onclick="updateStatus(<?php echo $row['id']; ?>, '<?php echo $row['accountStatus']; ?>')">
        <?php echo $row['accountStatus'] == 'Active' ? 'Deactivate' : 'Activate'; ?>
    </button>
</td>

                    </tr>
                    <tr class="divider-row">
                        <td colspan="4"></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>
    <script>
function updateStatus(id, currentStatus) {
    const newStatus = currentStatus === 'Active' ? 'Inactive' : 'Active';

    // Send AJAX request to update status
    fetch('statusCondition.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&status=${newStatus}`
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'success') {
            // Update the status text and button text without reloading
            document.getElementById(`status-${id}`).textContent = newStatus;
            const button = document.getElementById(`status-btn-${id}`);

            // Update button text
            button.textContent = newStatus === 'Active' ? 'Deactivate' : 'Activate';

            // Update the button's color based on new status
            if (newStatus === 'Active') {
                button.classList.remove('btn-green');
                button.classList.add('btn-red');
            } else {
                button.classList.remove('btn-red');
                button.classList.add('btn-green');
            }

            // Update the onclick attribute with the new status
            button.setAttribute('onclick', `updateStatus(${id}, '${newStatus}')`);
        } else {
            alert('Failed to update status');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
<style>
    .btn-green {
  background-color: #4CAF50;
  justify-content: center;
  display: inline-block;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  text-align: center;
}
.btn-red {
  background-color: #f44336;
  justify-content: center;
  display: inline-block;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  text-align: center;
}
.emailUpdate{
    justify-content: flex-end;
    display: flex;
   margin-left: 950px;
}
.input-group {
    display: flex;
    
}
</style>
    
</body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>
