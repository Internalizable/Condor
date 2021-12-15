<?php
include ('database/connection.php');

$data = array();
$data['labels'] = array();
$data['chartData'] = array();

$conn = openCon();

$year = date('Y');
$month = date('m');

for($i = 1; $i <= $month; $i++) {
    $dateObj   = DateTime::createFromFormat('!m', $i);
    $monthName = $dateObj->format('F');

    array_push($data['labels'], $monthName);

    $formattedMonth = '';

    if ($i < 10)
        $formattedMonth = "0" . $i;
    else
        $formattedMonth = $i;

    $subdate = $year . '-' . $formattedMonth . '-01';

    $upperDateFormatter = new DateTime( $subdate);
    $upperDate = $upperDateFormatter->format('Y-m-t');

    $query = mysqli_query($conn, "SELECT SUM(quantity * unitPrice) AS price FROM ORDERS WHERE orderDate BETWEEN '$subdate' AND '$upperDate';");

    if($row = mysqli_fetch_array($query)) {
        if($row['price'] == null)
            array_push($data['chartData'], 0);
        else
            array_push($data['chartData'], $row['price']);
    }
}

closeCon($conn);
echo json_encode($data);
?>
