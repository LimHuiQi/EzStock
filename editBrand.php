<?php
// editBrand.php
include 'dbconnect.php'; // This includes the mysqli connection

// Check if 'brandName' is provided in the URL
if (isset($_GET['brandName'])) {
    $brandName = $_GET['brandName'];

    // Prepare SQL statement to fetch the brand details
    $stmt = $conn->prepare("SELECT * FROM tbl_brands WHERE brand_name = ?");
    $stmt->bind_param("s", $brandName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $brand = $result->fetch_assoc();
        // Form to edit the brand
        echo "<style>
        form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #ffffff; /* Assuming a light background */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Adding shadow for depth */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Font style similar to brands.html */
        }
        input[type='text'], textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 8px;
            margin-bottom: 16px;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background: #f9f9f9; /* Light background for inputs */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Consistent font style */
        }
        input[type='submit'] {
            width: 100%;
            background-color: #4a148c; /* Primary button color */
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }
        input[type='submit']:hover {
            background-color: #6a1b9a; /* Darker shade for hover state */
        }
      </style>";
        echo "<form action='updateBrand.php' method='post'>";
        echo "<input type='hidden' name='original_brand_name' value='" . htmlspecialchars($brand['brand_name']) . "'>"; // Hidden field for the original brand name
        echo "Brand Name: <input type='text' name='brand_name' value='" . htmlspecialchars($brand['brand_name']) . "' required><br>";
        echo "Brand Description: <textarea name='brand_desc' required>" . htmlspecialchars($brand['brand_desc']) . "</textarea><br>";
        echo "Brand Status: <select name='brand_status' required>";
        echo "<option value='Active'" . ($brand['brand_status'] == 'Active' ? ' selected' : '') . ">Active</option>";
        echo "<option value='Inactive'" . ($brand['brand_status'] == 'Inactive' ? ' selected' : '') . ">Inactive</option>";
        echo "</select><br>";
        echo "<input type='submit' value='Update Brand'>";
        echo "</form>";
    } else {
        echo "No brand found with the name: " . htmlspecialchars($brandName);
    }
    $stmt->close();
} else {
    echo "Brand name not provided.";
}
$conn->close();
?>