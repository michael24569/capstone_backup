<?php 
require("db-connection.php");  // Pagination settings 
$records_per_page = 7; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$start_from = ($page-1) * $records_per_page;  

// Sanitize search input and search field
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$searchField = isset($_GET['field']) ? mysqli_real_escape_string($conn, $_GET['field']) : 'Lot_No';

// Get total number of records
$total_query = "SELECT COUNT(*) as total FROM records";
if ($searchQuery != '') {
    // Use the selected field for searching
    $total_query .= " WHERE $searchField LIKE '%$searchQuery%'";
} 

$result = mysqli_query($conn, $total_query); 
$row = mysqli_fetch_assoc($result); 
$total_records = $row['total']; 
$total_pages = ceil($total_records / $records_per_page);  

// Get records for current page
$query = "SELECT * FROM records";
if ($searchQuery != '') {
    // Use the selected field for searching
    $query .= " WHERE $searchField LIKE '%$searchQuery%'";
} 
$query .= " LIMIT $start_from, $records_per_page"; 
$result = mysqli_query($conn, $query);  

// Prepare response
$response = [     
    'records' => '',     
    'pagination_info' => '',     
    'pagination_links' => '' 
];  
// Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
// Generate records HTML
if(mysqli_num_rows($result) > 0) {     
    $recordsHTML = '';     
    while($row = mysqli_fetch_assoc($result)) {         
        $recordsHTML .= '<tr data-id="'.$row['id'].'">';         
        $recordsHTML .= '<td>'.htmlspecialchars(ucwords(strtolower($row['Lot_No']))).'</td>';         
        $recordsHTML .= '<td>'.htmlspecialchars(ucwords(strtolower($row['mem_lots']))).'</td>';         
        $recordsHTML .= '<td>'.htmlspecialchars(ucwords(strtolower($row['mem_sts']))).'</td>';         
        $recordsHTML .= '<td>'.htmlspecialchars(ucwords(strtolower($row['LO_name']))).'</td>';         
        $recordsHTML .= '<td>'.htmlspecialchars(ucwords(strtolower($row['mem_address']))).'</td>';         
        $recordsHTML .= '<td class="action-buttons">';         
        $recordsHTML .= '<a class="btn btn-edit" href="admin_update.php?id='.$row['id'].'"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="input-icon"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>Edit</a>';         
        $recordsHTML .= '</td></tr>';         
        $recordsHTML .= '<tr class="divider-row"><td colspan="6"></td></tr>';     
    }     
    $response['records'] = $recordsHTML; 
} else {     
    $response['records'] = '<tr><td colspan="6">No records found</td></tr>'; 
}  

// Generate pagination info
$response['pagination_info'] = "Page $page of $total_pages";  

// Generate pagination links
if($total_pages > 0) {     
    $paginationHTML = '';          
    // First page link     
    $paginationHTML .= '<a href="?page=1'.($searchQuery ? '&search='.urlencode($searchQuery).'&field='.urlencode($searchField) : '').'" '.                        
        ($page <= 1 ? 'class="disabled"' : '').'>First</a>';          
    
    // Previous page link     
    $paginationHTML .= '<a href="?page='.($page-1).($searchQuery ? '&search='.urlencode($searchQuery).'&field='.urlencode($searchField) : '').'" '.                        
        ($page <= 1 ? 'class="disabled"' : '').'>←</a>';          
    
    // Page number links     
    for($i = max(1, $page-2); $i <= min($total_pages, $page+2); $i++) {         
        $paginationHTML .= '<a href="?page='.$i.($searchQuery ? '&search='.urlencode($searchQuery).'&field='.urlencode($searchField) : '').'" '.                            
            ($page == $i ? 'class="active"' : '').'>'.$i.'</a>';     
    }          
    
    // Next page link     
    $paginationHTML .= '<a href="?page='.($page+1).($searchQuery ? '&search='.urlencode($searchQuery).'&field='.urlencode($searchField) : '').'" '.                        
        ($page >= $total_pages ? 'class="disabled"' : '').'>→</a>';          
    
    // Last page link     
    $paginationHTML .= '<a href="?page='.$total_pages.($searchQuery ? '&search='.urlencode($searchQuery).'&field='.urlencode($searchField) : '').'" '.                        
        ($page >= $total_pages ? 'class="disabled"' : '').'>Last</a>';          
    
    $response['pagination_links'] = $paginationHTML; 
}  

// Set content type to JSON 
header('Content-Type: application/json');  

// Output JSON response 
echo json_encode($response);