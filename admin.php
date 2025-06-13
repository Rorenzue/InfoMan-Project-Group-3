<?php
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "polo0210"; 
    $dbname = "main database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize messages
    $error_message = "";
    $success_message = "";

    if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
        $appli_num = (int)$_GET['delete'];
        
        // Start transaction for data integrity
        $conn->begin_transaction();
        
        try {
            // Get LRN from appli_details before deleting
            $get_lrn = "SELECT LRN FROM appli_details WHERE Appli_Num = ?";
            $stmt_lrn = $conn->prepare($get_lrn);
            
            if (!$stmt_lrn) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            
            $stmt_lrn->bind_param("i", $appli_num);
            $stmt_lrn->execute();
            $result_lrn = $stmt_lrn->get_result();
            
            if ($result_lrn->num_rows > 0) {
                $lrn_row = $result_lrn->fetch_assoc();
                $lrn = $lrn_row['LRN'];
                
                // Delete from prioritylist first 
                $delete_priority = "DELETE FROM prioritylist WHERE Appli_Num = ?";
                $stmt1 = $conn->prepare($delete_priority);
                if (!$stmt1) {
                    throw new Exception("Prepare failed for prioritylist: " . $conn->error);
                }
                $stmt1->bind_param("i", $appli_num);
                if (!$stmt1->execute()) {
                    throw new Exception("Delete from prioritylist failed: " . $stmt1->error);
                }
                
                // Delete from appli_details
                $delete_details = "DELETE FROM appli_details WHERE Appli_Num = ?";
                $stmt2 = $conn->prepare($delete_details);
                if (!$stmt2) {
                    throw new Exception("Prepare failed for appli_details: " . $conn->error);
                }
                $stmt2->bind_param("i", $appli_num);
                if (!$stmt2->execute()) {
                    throw new Exception("Delete from appli_details failed: " . $stmt2->error);
                }
                
                // Delete from educ_bg
                $delete_educ = "DELETE FROM educ_bg WHERE LRN = ?";
                $stmt3 = $conn->prepare($delete_educ);
                if (!$stmt3) {
                    throw new Exception("Prepare failed for educ_bg: " . $conn->error);
                }
                $stmt3->bind_param("s", $lrn);
                if (!$stmt3->execute()) {
                    throw new Exception("Delete from educ_bg failed: " . $stmt3->error);
                }
                
                // Delete from appli_profile
                $delete_profile = "DELETE FROM appli_profile WHERE LRN = ?";
                $stmt4 = $conn->prepare($delete_profile);
                if (!$stmt4) {
                    throw new Exception("Prepare failed for appli_profile: " . $conn->error);
                }
                $stmt4->bind_param("s", $lrn);
                if (!$stmt4->execute()) {
                    throw new Exception("Delete from appli_profile failed: " . $stmt4->error);
                }
                
                // Close all statements
                $stmt_lrn->close();
                $stmt1->close();
                $stmt2->close();
                $stmt3->close();
                $stmt4->close();
                
                // Commit transaction
                $conn->commit();
                
                // Redirect to prevent re-execution on page refresh
                header("Location: " . strtok($_SERVER["REQUEST_URI"], '?') . "?deleted=1");
                exit();
                
            } else {
                throw new Exception("Applicant not found");
            }
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            $error_message = "Error deleting applicant: " . $e->getMessage();
        }
    }

    // Check for success message from redirect
    if (isset($_GET['deleted']) && $_GET['deleted'] == '1') {
        $success_message = "Applicant deleted successfully!";
    }

    // Update the preview query to include status
    $preview = "SELECT ad.Appli_Num, 
                   CONCAT(ap.FirstName, ' ', 
                          CASE WHEN ap.MidName != '-' THEN CONCAT(ap.MidName, ' ') ELSE '' END,
                          ap.LastName, 
                          CASE WHEN ap.Suffix IS NOT NULL THEN CONCAT(' ', ap.Suffix) ELSE '' END) AS FullName, 
                   ad.Assistance_Type,
                   COALESCE(ad.status, 'None') as status
            FROM appli_details ad
            INNER JOIN appli_profile ap ON ad.LRN = ap.LRN";
    $adminview = $conn->query($preview);

    if (!$adminview) {
        die("Query failed: " . $conn->error);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Applicants' Overview</title>
    <link rel="stylesheet" href="admin.css">
    <script>
        function confirmDelete(appliNum, fullName) {
            if (confirm("Are you sure you want to delete applicant: " + fullName + "?")) {
                window.location.href = "?delete=" + appliNum;
            }
        }

        function updateStatus(appliNum) {
            // Get row data
            const row = document.querySelector(`tr[data-appli-num="${appliNum}"]`);
            const name = row.querySelector('td:nth-child(2)').textContent;
            const currentStatus = row.querySelector('td:nth-child(4)').textContent;

            // Create and append modal HTML
            document.body.insertAdjacentHTML('beforeend', `
                <div class="modal-backdrop"></div>
                <div class="modal-container">
                    <div class="modal-header">
                        <h3>Update Status</h3>
                        <button class="close-button" onclick="closeModal()">&times;</button>
                    </div>
                    <div class="modal-content">
                        <div class="modal-row">
                            <span class="modal-label">Applicant Number:</span>
                            <span class="modal-value">${appliNum}</span>
                        </div>
                        <div class="modal-row">
                            <span class="modal-label">Name:</span>
                            <span class="modal-value">${name}</span>
                        </div>
                        <div class="modal-row">
                            <span class="modal-label">Current Status:</span>
                            <span class="modal-value">
                                <span class="status-badge">${currentStatus}</span>
                            </span>
                        </div>
                    </div>
                    <div class="modal-buttons">
                        <button class="approve-btn" onclick="updateApplicationStatus(${appliNum}, 'Approved')">Approve</button>
                        <button class="decline-btn" onclick="updateApplicationStatus(${appliNum}, 'Declined')">Decline</button>
                    </div>
                </div>
            `);
        }

        function closeModal() {
            const modal = document.querySelector('.modal-container');
            const backdrop = document.querySelector('.modal-backdrop');
            
            if (modal) modal.remove();
            if (backdrop) backdrop.remove();
        }

        function updateApplicationStatus(appliNum, status) {
            fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `appli_num=${appliNum}&status=${status}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the status in the table
                    const row = document.querySelector(`tr[data-appli-num="${appliNum}"]`);
                    if (row) {
                        row.querySelector('td:nth-child(4)').textContent = status;
                    }
                    closeModal();
                } else {
                    alert('Failed to update status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating status');
            });
        }

        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "login.php";
            }
        }
    </script>
    <style>
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-view, .btn-status, .btn-delete {
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-view {
            background-color: #007bff;
            color: white;
        }

        .btn-status {
            background-color: #ffc107;
            color: black;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-view:hover, .btn-status:hover, .btn-delete:hover {
            opacity: 0.8;
        }

        /* Modal styles */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .modal-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 400px;
            padding: 20px;
        }

        .modal-header {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-content {
            padding: 15px;
        }

        .modal-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        .modal-label {
            font-weight: bold;
            color: #333;
        }

        .modal-value {
            color: #555;
        }

        .modal-buttons {
            padding: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
            border-top: 1px solid #ddd;
        }

        .approve-btn, .decline-btn {
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .approve-btn {
            background-color: #28a745;
            color: white;
        }

        .decline-btn {
            background-color: #dc3545;
            color: white;
        }

        .logout-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .logout-btn {
            background-color: #FFCD5F;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-family: 'Lexend', sans-serif;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color:rgb(163, 15, 15);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Applicants' Overview</h1>
        
        <!-- Display success or error messages -->
        <?php if (!empty($success_message)): ?>
            <div class="success-message" style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 4px;">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Applicant Number</th>
                        <th>Name</th>
                        <th>Assistance Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="applicantsTableBody">
                    <!-- Data will be populated from database -->
                    <?php
                    if ($adminview && $adminview->num_rows > 0) {
                        while($row = $adminview->fetch_assoc()) {
                            echo "<tr data-appli-num='" . htmlspecialchars($row['Appli_Num']) . "'>
                                    <td>" . htmlspecialchars($row['Appli_Num']) . "</td>
                                    <td>" . htmlspecialchars($row['FullName']) . "</td>
                                    <td>" . htmlspecialchars($row['Assistance_Type']) . "</td>
                                    <td>" . htmlspecialchars($row['status']) . "</td>
                                    <td class='action-buttons'>
                                        <a href='view_applicant.php?id=" . urlencode($row['Appli_Num']) . "' class='btn-view'>View</a>
                                        <a href='javascript:void(0)' onclick='updateStatus(" . htmlspecialchars($row['Appli_Num']) . ")' class='btn-status'>Status</a>
                                        <a href='javascript:void(0)' onclick=\"confirmDelete(" . htmlspecialchars($row['Appli_Num']) . ", '" . htmlspecialchars($row['FullName'], ENT_QUOTES) . "')\" class='btn-delete'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No applicants found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="logout-container">
        <a href="#" onclick="confirmLogout()" class="logout-btn">Logout</a>
    </div>
</body>
</html>