<?php
session_start(); // Ensure session is started
?>
<?php
// Include config file
require_once "../config.php";

// Initialize variables for form validation and item data
$staff_id = $staff_name = $role = $account_id="";
$staff_id_err = "";

// Check if item_id is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $staff_id = $_GET['id'];

    // Retrieve item details based on item_id
    $sql = "SELECT * FROM staffs WHERE staff_id = ?";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_staff_id);
        $param_staff_id = $staff_id;
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $staff_name = $row['staff_name'];
                $role = $row['role'];
                // $item_category = $row['item_category'];
                // $item_price = $row['item_price'];
                // $item_description = $row['item_description'];
            } else {
                echo "Staff not found.";
                exit();
            }
        } else {
            echo "Error retrieving item details.";
            exit();
        }
     
    }
}

// Process form submission when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // echo "Received POST data: <pre>";
//print_r($_POST);
//echo "</pre>";
    // Validate and sanitize input
    $staff_name = trim($_POST["staff_name"]);
    $role = trim($_POST["role"]);
    // $item_category = trim($_POST["item_category"]);
    // $item_price = floatval($_POST["item_price"]); // Convert to float
    // $item_description = $_POST["item_description"];

    // Update the item in the database
    $update_sql = "UPDATE staffs SET staff_name='$staff_name', role='$role' WHERE staff_id='$staff_id' ";
    $resultStaff = mysqli_query($link, $update_sql);
    
        if ($resultStaff) {
            // Item updated successfully
          
           header("Location: ../panel/staff-panel.php");
           echo 'success';
            exit();
        } else {
            echo "Error updating item: ";
        }

       
    }
    
    /*
     $result_tables = mysqli_query($link, $select_query_tables);
                                $resultCheckTables = mysqli_num_rows($result_tables);
                                if ($resultCheckTables > 0) {
                                    while ($row = mysqli_fetch_assoc($result_tables)) {
                                        echo '<option value="' . $row['table_id'] . '">For ' . $row['capacity'] . ' people. (Table Id: ' . $row['table_id'] . ')</option>';
                                    }
                                }  else {
                                    echo '<option disabled>No tables available, please choose another time.</option>';
                                    echo '<script>alert("No reservation tables found for the selected time. Please choose another time.");</script>';
                                }
     */

    // Close the database connection
    

?>

<!-- Create your HTML form for updating the item details -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <title>Update Staff</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: black;
            color: white;
        }

        .login-container {
            padding: 50px; /* Adjust the padding as needed */
            border-radius: 10px; /* Add rounded corners */
            margin: 100px auto; /* Center the container horizontally */
            max-width: 500px; /* Set a maximum width for the container */
        }

      

    



    </style>
</head>
<body>
     <div class="login-container">
        <div class="login_wrapper">
   
    <div class="wrapper">
    <h2 style="text-align: center;">Update Staff</h2>
    <h5>Admin Credentials needed to Edit Staff</h5>
    <form action="" method="post" >
        <div class="form-group">
            <label for="staff_name"  class="form-label" >Staff Name:</label>
            <input type="text" name="staff_name" id="staff_name" class="form-control" value="<?php echo htmlspecialchars($staff_name); ?>" required>
        </div>
        <div class="form-group">
            <label for="role"  class="form-label">role:</label>
            <input type="text" name="role" id="role" class="form-control" value="<?php echo htmlspecialchars($role); ?>" required>
        </div>
        <!-- <div class="form-group"  class="form-label">
            <label for="item_category" >Item Category:</label>
            <input type="text" name="item_category" id="item_category" class="form-control" placeholder="Main Dish/ Side Dish/ Drinks" value="<?php echo htmlspecialchars($item_category); ?>" required>
        </div>
        <div class="form-group" class="form-label">
            <label for="item_price">Item Price:</label>
            <input type="number" min=0.01 step="0.01" name="item_price" id="item_price" placeholder="Enter Item Price"class="form-control" value="<?php echo htmlspecialchars($item_price);?>" required>
        </div>
        <div class="form-group" >
            <label for="item_description" class="form-label" >Item Description:</label>
            <textarea name="item_description" id="item_description" placeholder="The dish...." required class="form-control"> <?php echo htmlspecialchars($item_description); ?> </textarea>
      
        </div> -->
        <br>
        <input type="hidden" name="staff_id" value="   class="form-control">
        <button class="btn btn-light" type="submit" name="submit" value="submit">Update</button>
        <a class="btn btn-danger" href="../panel/staff-panel.php" >Cancel</a>
    </form>
    </div>
        </div>
    </div>
</body>
</html>