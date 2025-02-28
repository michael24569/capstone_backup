<?php
session_start();

if (!isset($_GET['file'])) {
    $_SESSION['error'] = 'No file specified.';
    header("Location: admin_backup.php");
    exit();
}

$backup_file_name = urldecode($_GET['file']);

// Set the default backup directory path
$default_backup_directory = 'C:/Users/Lenovo/Downloads/Backup Files';

// Override the backup directory if a different directory is specified in the session
if (isset($_SESSION['alt_backup_directory']) && !empty($_SESSION['alt_backup_directory'])) {
    $backup_directory = $_SESSION['alt_backup_directory'];
} else {
    $backup_directory = $default_backup_directory;
}

// Check if the backup has expired
if (isset($_SESSION['backup_time']) && (time() - $_SESSION['backup_time']) > 30) {
    if (file_exists($backup_file_name)) {
        unlink($backup_file_name);
        $_SESSION['error'] = "Backup file expired and was deleted.";
    }
    header("Location: admin_backup.php");
    exit();
}

// Create backup directory if it doesn't exist
if (!file_exists($backup_directory)) {
    try {
        if (!mkdir($backup_directory, 0777, true)) {
            throw new Exception("Failed to create backup directory");
        }
        // Set proper permissions for the new directory
        chmod($backup_directory, 0777);
    } catch (Exception $e) {
        $_SESSION['error'] = "Failed to create backup directory: " . $e->getMessage();
        header("Location: admin_backup.php");
        exit();
    }
}

// Process the backup file
if (file_exists($backup_file_name) && (time() - $_SESSION['backup_time']) <= 30) {
    $new_file_path = str_replace('\\', '/', $backup_directory . '/' . basename($backup_file_name));
    
    try {
        if (!is_readable($backup_file_name)) {
            throw new Exception("Source file is not readable");
        }
        
        if (!is_writable($backup_directory)) {
            throw new Exception("Backup directory is not writable");
        }
        
        if (copy($backup_file_name, $new_file_path)) {
            unlink($backup_file_name);
            $_SESSION['successful'] = "Database backup successfully saved to " . $backup_directory . "!";
        } else {
            throw new Exception("Failed to copy file");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Backup failed: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "Backup file not found or backup time expired.";
}

header("Location: admin_backup.php");
exit();
?>
