<?php
session_start();

if (!isset($_GET['file'])) {
    $_SESSION['error'] = 'No file specified.';
    header("Location: admin_backup.php");
    exit();
}

$backup_file_name = urldecode($_GET['file']);
$backup_directory = 'C:\Users\user\Downloads\Backup Files'; // Update your backup directory path

// Check if the backup has expired (i.e., 30 seconds after it was created)
if (isset($_SESSION['backup_time']) && (time() - $_SESSION['backup_time']) > 30) {
    if (file_exists($backup_file_name)) {
        unlink($backup_file_name); // Delete the expired file
        $_SESSION['error'] = "Backup file expired and was deleted.";
    }
    header("Location: admin_backup.php");
    exit();
}

// Ensure the backup directory exists
if (!file_exists($backup_directory) && !mkdir($backup_directory, 0777, true)) {
    error_log("Failed to create directory: $backup_directory");
    $_SESSION['error'] = "Failed to create backup directory: " . error_get_last()['message'];
    header("Location: admin_backup.php");
    exit();
}
// Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
// If the backup file exists and the backup time hasn't expired
if (file_exists($backup_file_name) && (time() - $_SESSION['backup_time']) <= 30) {
    $new_file_path = $backup_directory . '/' . basename($backup_file_name);
    if (rename($backup_file_name, $new_file_path)) {
        $_SESSION['successful'] = "Backup file moved to Backup Files.";
    } else {
        error_log("Failed to move backup file: $backup_file_name to $new_file_path");
        $_SESSION['error'] = "Failed to move backup file to Backup Files: " . error_get_last()['message'];
    }
} else {
    $_SESSION['error'] = "Backup file not found or backup time expired.";
}

header("Location: admin_backup.php");
exit();
?>
