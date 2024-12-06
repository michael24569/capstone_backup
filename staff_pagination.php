<?php
require("db-connection.php");

// Pagination settings
$records_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page-1) * $records_per_page;

// Sanitize search input
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Get total number of records
$total_query = "SELECT COUNT(*) as total FROM records";
if ($searchQuery != '') {
    $total_query .= " WHERE Lot_No LIKE '%$searchQuery%' OR mem_lots LIKE '%$searchQuery%' 
                     OR mem_sts LIKE '%$searchQuery%' OR LO_name LIKE '%$searchQuery%'";
}
$result = mysqli_query($conn, $total_query);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];
$total_pages = ceil($total_records / $records_per_page);

// Get records for current page
$query = "SELECT * FROM records";
if ($searchQuery != '') {
    $query .= " WHERE Lot_No LIKE '%$searchQuery%' OR mem_lots LIKE '%$searchQuery%' 
               OR mem_sts LIKE '%$searchQuery%' OR LO_name LIKE '%$searchQuery%'";
}
$query .= " LIMIT $start_from, $records_per_page";
$result = mysqli_query($conn, $query);

// Prepare response
$response = [
    'records' => '',
    'pagination_info' => '',
    'pagination_links' => ''
];

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
        $recordsHTML .= '<a class="btn btn-edit" href="update.php?id='.$row['id'].'">Edit</a>';
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
    $paginationHTML .= '<a href="?page=1'.($searchQuery ? '&search='.urlencode($searchQuery) : '').'" '.
                       ($page <= 1 ? 'class="disabled"' : '').'>First</a>';
    
    // Previous page link
    $paginationHTML .= '<a href="?page='.($page-1).($searchQuery ? '&search='.urlencode($searchQuery) : '').'" '.
                       ($page <= 1 ? 'class="disabled"' : '').'>←</a>';
    
    // Page number links
    for($i = max(1, $page-2); $i <= min($total_pages, $page+2); $i++) {
        $paginationHTML .= '<a href="?page='.$i.($searchQuery ? '&search='.urlencode($searchQuery) : '').'" '.
                           ($page == $i ? 'class="active"' : '').'>'.$i.'</a>';
    }
    
    // Next page link
    $paginationHTML .= '<a href="?page='.($page+1).($searchQuery ? '&search='.urlencode($searchQuery) : '').'" '.
                       ($page >= $total_pages ? 'class="disabled"' : '').'>→</a>';
    
    // Last page link
    $paginationHTML .= '<a href="?page='.$total_pages.($searchQuery ? '&search='.urlencode($searchQuery) : '').'" '.
                       ($page >= $total_pages ? 'class="disabled"' : '').'>Last</a>';
    
    $response['pagination_links'] = $paginationHTML;
}

// Set content type to JSON
header('Content-Type: application/json');

// Output JSON response
echo json_encode($response);