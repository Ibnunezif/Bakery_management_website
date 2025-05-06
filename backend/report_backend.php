<?php

function monthlyRevenueReport($bakeryName, $conn)
{
    $query = "SELECT 
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

    $result = $conn->query($query);
    if (!$result) {
        die("Query failed: " . $conn->error);
    } else {
        echo "Query executed successfully.";
        $monthlyRevenue = [];
        while ($row = $result->fetch_assoc()) {
            $monthlyRevenue[] = $row;
        }
        return $monthlyRevenue;
    }
}


function soldProductReport($bakeryName, $conn)
{
    $query = "
    SELECT 
    product.productType AS productType,
    COALESCE(SUM(product.quantity), 0) AS totalProduced,
    COALESCE(SUM(salesData.totalSold), 0) AS totalSold
FROM 
    product
LEFT JOIN 
    (
        SELECT 
            productName, 
            SUM(soldQuantity) AS totalSold
        FROM 
            sales
        GROUP BY 
            productName
    ) AS salesData
ON 
    product.productType = salesData.productName
WHERE 
    product.userId IN (SELECT userId FROM users WHERE bakeryName = ?)
GROUP BY 
    product.productType;
";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $bakeryName);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}
