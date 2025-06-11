<?php
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = ""; // **Security Note**: Store passwords securely (e.g., in environment variables)
    $dbname = "scholarship";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $preview = "SELECT Appli_Num, CONCAT(FirstName, ' ', MidName, ' ', LastName, ' ', Suffix) AS FullName, Assistance_Type
                FROM appli_details, appli_profile";
    $adminview = $conn->query($preview);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Applicants' Overview</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <h1>Applicants' Overview</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Applicant Number</th>
                        <th>Name</th>
                        <th>Assistance Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="applicantsTableBody">
                    <!-- Data will be populated from database -->
                    <?php
                    if ($adminview && $adminview->num_rows > 0) {
                        while($row = $adminview->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['Appli_Num']}</td>
                                    <td>{$row['FullName']}</td>
                                    <td>{$row['Assistance_Type']}</td>
                                    <td><a href='view_applicant.php?id={$row['Appli_Num']}'>View</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No applicants found.</td></tr>";
                    }
                    ?>
                    </tbody>
            </table>
        </div>
    </div>
</body>
</html>