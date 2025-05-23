<?php
session_start();
require("db-connection.php");

require_once 'security_check.php';
checkAdminAccess();


if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $sql = "SELECT * FROM archive";
    
    if ($searchQuery != '') {
        $sql .= " WHERE Lot_No LIKE '%$searchQuery%' 
                  OR mem_lots LIKE '%$searchQuery%' 
                  OR mem_sts LIKE '%$searchQuery%' 
                  OR LO_name LIKE '%$searchQuery%'";
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive section</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Michroma&display=swap">
    <link rel="stylesheet" href="style1.css">
</head>
<body style="background: #071c14;">

<?php include 'admin_sidebar.php'; ?>

    <div id="recordsContent" class="center_record">
        <div class="table-responsive">
        <h1 id="header1">Archive Section</h1>
            <br>
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <br>
                    <button class='btn btn-search' type="submit">Search</button>
                </div>
            </form>

            <table class="styled-table text-center">
                <thead>
                    <tr class="bg-dark text-black">
                        <th>Lot No.</th>
                        <th>Memorial Lots</th>
                        <th>Memorial Name</th>
                        <th>Lot owner</th>
                        <th>Address</th>                  
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo strtolower(htmlspecialchars($row['Lot_No'])); ?></td>
                        <td><?php echo strtolower(htmlspecialchars($row['mem_lots'])); ?></td>
                        <td><?php echo strtolower(htmlspecialchars($row['mem_sts'])); ?></td>
                        <td><?php echo strtolower(htmlspecialchars($row['LO_name'])); ?></td>
                        <td><?php echo strtolower(htmlspecialchars($row['mem_address'])); ?></td>
                    </tr>
                    <tr class="divider-row">
                        <td colspan="6"></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>
    
</body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>
