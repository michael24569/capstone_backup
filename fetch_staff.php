<?php 
// search.php
session_start(); 
require_once 'security_check.php'; 
checkAdminAccess(); 
require("db-connection.php");  

if (isset($_GET['search'])) {     
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']);     
    $sql = "SELECT * FROM staff";          
    
    if ($searchQuery != '') {         
        $sql .= " WHERE fullname LIKE '%$searchQuery%'";     
    }      
    
    $result = mysqli_query($conn, $sql);          
    
    if (!$result) {         
        die(json_encode(['error' => mysqli_error($conn)]));     
    }      
    
    $output = '';
    
    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {         
            $output .= '<tr>';         
            $output .= '<td>' . ucwords(strtolower(htmlspecialchars($row['fullname']))) . '</td>';         
            $output .= '<td>' . ucwords(strtolower(htmlspecialchars($row['username']))) . '</td>';         
            $output .= '<td id="status-' . $row['id'] . '">' . ucwords(strtolower(htmlspecialchars($row['accountStatus']))) . '</td>';         
            $output .= '<td class="action-buttons">';         
            $output .= '<a href="edit_staff.php?id=' . $row['id'] . '" class="btn btn-green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="input-icon"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>Edit</a>';         
            $output .= '<button id="status-btn-' . $row['id'] . '" class="btn ' . ($row['accountStatus'] == 'Active' ? 'btn-red' : 'btn-green') . '" onclick="updateStatus(' . $row['id'] . ', \'' . $row['accountStatus'] . '\')">';         
            if ($row['accountStatus'] == 'Active') {             
                $output .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="input-icon"><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128l-192 0c-70.7 0-128-57.3-128-128s57.3-128 128-128l192 0zM576 256c0-106-86-192-192-192L192 64C86 64 0 150 0 256S86 448 192 448l192 0c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>Deactivate';         
            } else {             
                $output .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="input-icon"><path d="M192 64C86 64 0 150 0 256S86 448 192 448l192 0c106 0 192-86 192-192s-86-192-192-192L192 64zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>Activate';         
            }         
            $output .= '</button></td></tr>';         
            $output .= '<tr class="divider-row"><td colspan="4"></td></tr>';     
        }
    } else {
        // No results found message
        $output .= '<tr>';
        $output .= '<td colspan="4" style="text-align: center; padding: 20px; font-size: 16px; color: #666;">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                <line x1="11" y1="8" x2="11" y2="14"></line>
                                <line x1="8" y1="11" x2="14" y2="11"></line>
                            </svg>
                            <span>No staff account registered with the name "' . htmlspecialchars($searchQuery) . '"</span>
                        </div>
                    </td>';
        $output .= '</tr>';
    }
    
    echo $output;     
    exit; 
} 
?>