<?php
// testing code

$servername = "localhost";  
$username = "root";
$password = "";
$dbname = "bakery_ecom";

$yourDbConnection = mysqli_connect($servername, $username, $password, $dbname);

if (!$yourDbConnection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];

    $insertProductQuery = "INSERT INTO products (product_name) VALUES ('$productName')";
    mysqli_query($yourDbConnection, $insertProductQuery);

    $getProductId = "SELECT product_id FROM products WHERE product_name = '$productName'";
    $resultProductId = mysqli_query($yourDbConnection, $getProductId);
    $rowProductId = mysqli_fetch_assoc($resultProductId);
    $productId = $rowProductId['product_id'];

    $selectedSizes = $_POST['sizes']; 
    $selectedColors = $_POST['themes']; 
    $selectedFlavours = $_POST['flavors']; 

    foreach($selectedFlavours as $flavour){
        $selectFlavourQuery = "SELECT flavour_id FROM flavours WHERE flavour_name = '$flavour'";
        $resultFlavourId = mysqli_query($yourDbConnection, $selectFlavourQuery);
        $rowFlavourId = mysqli_fetch_assoc($resultFlavourId);
        $flavourId = $rowFlavourId['flavour_id'];

        foreach ($selectedSizes as $size){
            $selectSizeQuery = "SELECT size_id FROM sizes WHERE size_name = '$size'";
            $resultSizeId = mysqli_query($yourDbConnection, $selectSizeQuery);
            $rowSizeId = mysqli_fetch_assoc($resultSizeId);
            $sizeId = $rowSizeId['size_id'];

            foreach ($selectedColors as $theme) {
                $selectThemeQuery = "SELECT theme_id FROM themes WHERE theme_name = '$theme'";
                $resultThemeId = mysqli_query($yourDbConnection, $selectThemeQuery);
                $rowThemeId = mysqli_fetch_assoc($resultThemeId);
                $themeId = $rowThemeId['theme_id'];
                
                $insertItemQuery = "INSERT INTO items(product_id,flavour_id,size_id,theme_id) VALUES ('$productId','$flavourId', '$sizeId', '$themeId')";
                mysqli_query($yourDbConnection, $insertItemQuery);
            }
        }
    }
    echo "Product added successfully!";
}
?>
