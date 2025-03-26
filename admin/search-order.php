<?php
$mysqli = require __DIR__ . "../../database.php";

$search_order_id = isset($_GET['search_order_id']) ? $_GET['search_order_id'] : '';

$sql = "SELECT 
            od.order_id, od.order_date,
            CONCAT(u.firstname, ' ', u.lastname) AS full_name,
            SUM(od.quantity) AS total_quantity,
            SUM(od.subtotal) AS total_cost,
            u.user_id
        FROM 
            order_data od
        JOIN 
            user u ON od.user_id = u.user_id";

if (!empty($search_order_id) && $search_order_id !== 'all') {
    $sql .= " WHERE od.order_id = ?";
}

$sql .= " GROUP BY od.order_id, full_name
          ORDER BY od.order_date DESC";

$stmt = $mysqli->prepare($sql);

if (!empty($search_order_id) && $search_order_id !== 'all') {
    $stmt->bind_param("s", $search_order_id);
}

$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Invalid query: " . $mysqli->error);
}

while ($row = $result->fetch_assoc()) {
    echo "
    <tr>
        <td>{$row['order_id']}</td>
        <td>{$row['full_name']}</td>
        <td>{$row['total_quantity']}</td>
        <td>₱" . number_format($row['total_cost'], 2) . "</td>
        <td>{$row['order_date']}</td>
        <td>
            <button class='successPay' data-order-id='{$row['order_id']}'>Paid</button>
            <button class='cancelOrder' data-order-id='{$row['order_id']}'>Cancel</button>
        </td>
    </tr>";
}
?>