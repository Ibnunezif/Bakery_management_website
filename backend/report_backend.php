<?php

function monthlyRevenueReport($bakeryName,$conn){
$query="SELECT 
    YEAR(sales.salesDate) AS year,
    MONTH(sales.salesDate) AS month,
    SUM(sales.salePrice * sales.soldQuantity) AS totalRevenue,
    (SELECT SUM(users.Salary) FROM users WHERE users.bakeryName = '$bakeryName') AS totalSalaries,
    SUM(sales.salePrice * sales.soldQuantity) - (SELECT SUM(users.Salary) FROM users WHERE users.bakeryName = '$bakeryName') AS netRevenue
FROM 
    sales
JOIN 
    users ON sales.userId = users.userId
WHERE 
    users.bakeryName = '$bakeryName'
GROUP BY 
    YEAR(sales.salesDate), MONTH(sales.salesDate)
ORDER BY 
    YEAR(sales.salesDate) DESC, MONTH(sales.salesDate) DESC;";

$result = $conn -> query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}else{
    echo "Query executed successfully.";
    $monthlyRevenue = [];
while ($row = $result->fetch_assoc()) {
    $monthlyRevenue[] = $row;
}
return $monthlyRevenue;
}

}

?>