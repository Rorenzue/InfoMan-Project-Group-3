<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // **Security Note**: Store passwords securely (e.g., in environment variables)
$dbname = "scholarship";

// Initialize variables
$success_message = false;
$error_message = "";

// Create database connection
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
} catch (Exception $e) {
    $error_message = "Database connection error: " . $e->getMessage();
}

// Fetch school and degree details for display
$school_details = [
    1 => ['school_name' => $_SESSION["First_School_Choice"] ?? '', 'address' => '-', 'type' => '-'],
    2 => ['school_name' => $_SESSION["Second_School_Choice"] ?? '', 'address' => '-', 'type' => '-'],
    3 => ['school_name' => $_SESSION["Third_School_Choice"] ?? '', 'address' => '-', 'type' => '-']
];

$degree_details = [
    1 => ['degree' => $_SESSION["First_Degree_Choice"] ?? '', 'duration' => '-'],
    2 => ['degree' => $_SESSION["Second_Degree_Choice"] ?? '', 'duration' => '-'],
    3 => ['degree' => $_SESSION["Third_Degree_Choice"] ?? '', 'duration' => '-']
];

$educ_background_details = [
    'ES' => ['school_name' => $_SESSION["School_Name_ES"] ?? '', 'address' => '-', 'type' => '-'],
    'JHS' => ['school_name' => $_SESSION["School_Name_JHS"] ?? '', 'address' => '-', 'type' => '-'],
    'SHS' => ['school_name' => $_SESSION["School_Name_SHS"] ?? '', 'address' => '-', 'type' => '-'],
    'UDG' => ['school_name' => $_SESSION["School_Name_UDG"] ?? '', 'address' => '-', 'type' => '-'],
    'MT' => ['school_name' => $_SESSION["School_Name_MT"] ?? '', 'address' => '-', 'type' => '-']
];

try {
    // Fetch school details (School_Address, School_Type) for priority choices
    foreach ($school_details as $key => &$details) {
        if (!empty($details['school_name'])) {
            $school_query = $conn->prepare("SELECT School_Address, School_Type FROM schooldetails WHERE school_name = ?");
            if ($school_query) {
                $school_query->bind_param("s", $details['school_name']);
                $school_query->execute();
                $school_query->store_result();
                $school_query->bind_result($school_address, $school_type);
                if ($school_query->num_rows > 0 && $school_query->fetch()) {
                    $details['address'] = $school_address ?: '-';
                    $details['type'] = $school_type ?: '-';
                } else {
                    $details['address'] = '-';
                    $details['type'] = '-';
                    error_log("School not found: " . $details['school_name']);
                }
                $school_query->close();
            } else {
                error_log("Prepare failed for school query: " . $conn->error);
            }
        }
    }

    // Fetch school details (School_Address, School_Type) for educational background
    foreach ($educ_background_details as $level => &$details) {
        if (!empty($details['school_name'])) {
            $school_query = $conn->prepare("SELECT School_Address, School_Type FROM schooldetails WHERE school_name = ?");
            if ($school_query) {
                $school_query->bind_param("s", $details['school_name']);
                $school_query->execute();
                $school_query->store_result();
                $school_query->bind_result($school_address, $school_type);
                if ($school_query->num_rows > 0 && $school_query->fetch()) {
                    $details['address'] = $school_address ?: '-';
                    $details['type'] = $school_type ?: '-';
                } else {
                    $details['address'] = '-';
                    $details['type'] = '-';
                    error_log("School not found for $level: " . $details['school_name']);
                }
                $school_query->close();
            } else {
                error_log("Prepare failed for school query for $level: " . $conn->error);
            }
        }
    }

    // Fetch degree durations
    foreach ($degree_details as $key => &$details) {
        if (!empty($details['degree'])) {
            $degree_query = $conn->prepare("SELECT duration FROM degree_program WHERE degreeprogram = ?");
            if ($degree_query) {
                $degree_query->bind_param("s", $details['degree']);
                $degree_query->execute();
                $degree_query->store_result();
                $degree_query->bind_result($duration);
                if ($degree_query->num_rows > 0 && $degree_query->fetch()) {
                    $details['duration'] = $duration ?: '-';
                } else {
                    $details['duration'] = '-';
                    error_log("Degree program not found: " . $details['degree']);
                }
                $degree_query->close();
            } else {
                error_log("Prepare failed for degree query: " . $conn->error);
            }
        }
    }
} catch (Exception $e) {
    $error_message = "Error fetching school or degree details: " . $e->getMessage();
    error_log($error_message);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_application'])) {
    try {
        // Validate required fields
        $required_fields = ['FirstName', 'LastName', 'LRN', 'EmailAdd'];
        foreach ($required_fields as $field) {
            if (empty($_SESSION[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }

        // Additional validation
        if (!filter_var($_SESSION['EmailAdd'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        if (!preg_match('/^\d{12}$/', $_SESSION['LRN'])) { // Assuming LRN is a 12-digit number
            throw new Exception("Invalid LRN format");
        }

        // Begin transaction
        $conn->begin_transaction();

        // Insert into appli_profile
        $FirstName = $_SESSION["FirstName"] ?? '';
        $MidName = $_SESSION["MidName"] ?? '';
        $LastName = $_SESSION["LastName"] ?? '';
        $Suffix = $_SESSION["Suffix"] ?? '';
        $BirthDate = $_SESSION["BirthDate"] ?? '';
        $BirthPlace = $_SESSION["BirthPlace"] ?? '';
        $Sex = $_SESSION["Sex"] ?? '';
        $EthnoGroupStudent = $_SESSION["EthnoGroupStudent"] ?? '';
        $EmailAdd = $_SESSION["EmailAdd"] ?? '';
        $ContactNo = $_SESSION["ContactNo"] ?? '';
        $LRN = $_SESSION["LRN"] ?? '';
        $CivilStat = $_SESSION["CivilStat"] ?? '';
        $Perma_Stud_Add = $_SESSION["Perma_Stud_Add"] ?? '';
        $Current_Stud_Add = $_SESSION["Current_Stud_Add"] ?? '';
        $ParentName = $_SESSION["ParentName"] ?? '';
        $ParentEduc = $_SESSION["ParentEduc"] ?? '';
        $EthnoGroupPrt = $_SESSION["EthnoGroupPrt"] ?? '';
        $Parent_Add = $_SESSION["Parent_Add"] ?? '';
        $PLifeStatus = $_SESSION["PLifeStatus"] ?? '';
        $ParentPrimaryOccu = $_SESSION["ParentPrimaryOccu"] ?? '';
        $ParentOfficeAdd = $_SESSION["ParentOfficeAdd"] ?? '';
        $Parent_Income = $_SESSION["Parent_Income"] ?? '';
        $ITR_Year = $_SESSION["ITR_Year"] ?? '';

        $sql1 = "INSERT INTO appli_profile (
            FirstName, MidName, LastName, Suffix, BirthDate, BirthPlace, Sex, EthnoGroupStudent, 
            EmailAdd, ContactNo, LRN, CivilStat, Perma_Stud_Add, Current_Stud_Add, ParentName, 
            ParentEduc, EthnoGroupPrt, Parent_Add, PLifeStatus, ParentPrimaryOccu, 
            ParentOfficeAdd, Parent_Income, ITR_Year
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt1 = $conn->prepare($sql1);
        if (!$stmt1) {
            throw new Exception("Prepare failed for appli_profile: " . $conn->error);
        }

        $stmt1->bind_param(
            "sssssssssssssssssssssss",
            $FirstName, $MidName, $LastName, $Suffix, $BirthDate, $BirthPlace, $Sex,
            $EthnoGroupStudent, $EmailAdd, $ContactNo, $LRN, $CivilStat, $Perma_Stud_Add,
            $Current_Stud_Add, $ParentName, $ParentEduc, $EthnoGroupPrt, $Parent_Add,
            $PLifeStatus, $ParentPrimaryOccu, $ParentOfficeAdd, $Parent_Income, $ITR_Year
        );

        if (!$stmt1->execute()) {
            throw new Exception("Error inserting into appli_profile: " . $stmt1->error);
        }
        $stmt1->close();

// Insert into educ_bg
$educ_levels = ['ES', 'JHS', 'SHS', 'UDG', 'MT'];
$sql2 = "INSERT INTO educ_bg (LRN, Educ_Background, SchoolCode, Year_Grad, Ave_Grade, ranking)
         VALUES (?, ?, ?, ?, ?, ?)";
$stmt2 = $conn->prepare($sql2);
if (!$stmt2) {
    throw new Exception("Prepare failed for educ_bg: " . $conn->error);
}

$valid_rankings = ['Highest', 'High', 'Honors', 'NA', ''];

foreach ($educ_levels as $level) {
    $school_name = $_SESSION["School_Name_" . $level] ?? '';
    if (empty($school_name)) continue;

    // Retrieve and validate ranking
    $ranking = $_SESSION["Ranking_" . $level] ?? 'NA';
    if (!in_array($ranking, $valid_rankings)) {
        error_log("Invalid ranking for $level: $ranking");
        throw new Exception("Invalid ranking for $level: $ranking");
    }

    // Log for debugging
    error_log("Inserting for $level - Ranking: '$ranking'");

    $school_code = null;
    $school_query = $conn->prepare("SELECT School_Code FROM schooldetails WHERE school_name = ?");
    if ($school_query) {
        $school_query->bind_param("s", $school_name);
        $school_query->execute();
        $school_query->store_result();
        $school_query->bind_result($school_code_result);

        if ($school_query->num_rows > 0 && $school_query->fetch()) {
            $school_code = (int)$school_code_result;
        } else {
            throw new Exception("School not found: $school_name");
        }
        $school_query->close();
    }

    if ($school_code !== null) {
        $lrn = (int)($_SESSION["LRN"] ?? 0);
        $educ_background = $level;
        $year_grad = $_SESSION["Year_Grad_" . $level] ?? '';
        $ave_grade = (float)($_SESSION["Ave_Grade_" . $level] ?? 0.0);

        // Validate data
        if ($lrn === 0) {
            throw new Exception("Invalid LRN for $level");
        }
        if (!in_array($educ_background, $educ_levels)) {
            throw new Exception("Invalid education level: $level");
        }
        if (!empty($year_grad) && !preg_match('/^\d{4}$/', $year_grad)) {
            throw new Exception("Invalid graduation year for $level");
        }
        if ($ave_grade < 0 || $ave_grade > 100) {
            throw new Exception("Invalid average grade for $level");
        }

        $stmt2->bind_param("isisds", $lrn, $educ_background, $school_code, $year_grad, $ave_grade, $ranking);
        if (!$stmt2->execute()) {
            throw new Exception("Error inserting into educ_bg for level $level: " . $stmt2->error);
        }
    }
}
$stmt2->close();

        // Insert into applidetails
        $income_bracket = $_SESSION["Parent_Income"] ?? '';
        $assistance_type = in_array($income_bracket, ['Below_50k', '50k_100k', '100k_200k']) ? "Regular" : "Merit";
        $assistance_applied = $_SESSION["Assistance_Applied"] ?? '';

        $sql3 = "INSERT INTO appli_details (LRN, assistance_type, assistance_applied) 
                 VALUES (?, ?, ?)";
        $stmt3 = $conn->prepare($sql3);
        if (!$stmt3) {
            throw new Exception("Prepare failed for applidetails: " . $conn->error);
        }

        $stmt3->bind_param("sss", $LRN, $assistance_type, $assistance_applied);
        if (!$stmt3->execute()) {
            throw new Exception("Error inserting into applidetails: " . $stmt3->error);
        }
        $stmt3->close();

        // Fetch appli_num
        $appli_num_query = $conn->prepare("SELECT appli_num FROM appli_details WHERE LRN = ?");
        if (!$appli_num_query) {
            throw new Exception("Prepare failed for fetching appli_num: " . $conn->error);
        }

        $appli_num_query->bind_param("s", $LRN);
        $appli_num_query->execute();
        $appli_num_query->bind_result($appli_num);
        if (!$appli_num_query->fetch()) {
            throw new Exception("Error fetching appli_num for LRN: " . $LRN);
        }
        $appli_num_query->close();

        // Insert into prioritylist
        $priority_choices = [
            1 => ['degree' => $_SESSION["First_Degree_Choice"] ?? '', 'school' => $_SESSION["First_School_Choice"] ?? ''],
            2 => ['degree' => $_SESSION["Second_Degree_Choice"] ?? '', 'school' => $_SESSION["Second_School_Choice"] ?? ''],
            3 => ['degree' => $_SESSION["Third_Degree_Choice"] ?? '', 'school' => $_SESSION["Third_School_Choice"] ?? '']
        ];

        $sql4 = "INSERT INTO prioritylist (appli_num, degcode, school_code, prionum) VALUES (?, ?, ?, ?)";
        $stmt4 = $conn->prepare($sql4);
        if (!$stmt4) {
            throw new Exception("Prepare failed for prioritylist: " . $conn->error);
        }

        foreach ($priority_choices as $prio_num => $choice) {
            if (empty($choice['degree']) || empty($choice['school'])) continue;

            $degcode = null;
            $schoolcode = null;

            // Get degcode
            $degree_query = $conn->prepare("SELECT degcode FROM degree_program WHERE degreeprogram = ?");
            if ($degree_query) {
                $degree_query->bind_param("s", $choice['degree']);
                $degree_query->execute();
                $degree_query->bind_result($degcode_result);
                if ($degree_query->fetch()) {
                    $degcode = $degcode_result;
                } else {
                    throw new Exception("Degree program not found: " . $choice['degree']);
                }
                $degree_query->close();
            }

            // Get schoolcode
            $school_query = $conn->prepare("SELECT School_Code FROM schooldetails WHERE school_name = ?");
            if ($school_query) {
                $school_query->bind_param("s", $choice['school']);
                $school_query->execute();
                $school_query->bind_result($schoolcode_result);
                if ($school_query->fetch()) {
                    $schoolcode = $schoolcode_result;
                } else {
                    throw new Exception("School not found: " . $choice['school']);
                }
                $school_query->close();
            }

            if ($degcode && $schoolcode) {
                $stmt4->bind_param("sssi", $appli_num, $degcode, $schoolcode, $prio_num);
                if (!$stmt4->execute()) {
                    throw new Exception("Error inserting into prioritylist for priority $prio_num: " . $stmt4->error);
                }
            }
        }
        $stmt4->close();

        // Commit transaction
        $conn->commit();
        $success_message = true;

        // Clear session data
        session_unset();
        session_destroy();

    } catch (Exception $e) {
        // Roll back transaction on error
        if (isset($conn)) {
            $conn->rollback();
        }
        $error_message = "Application submission failed: " . $e->getMessage();
        error_log($error_message);
    }

    header("Location: confirmation.php");
    exit();
}

// Close database connection
if (isset($conn)) {
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NCIP Educational Assistance - View and Submit</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="viewsubmitdesign.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: none;
            border-radius: 10px;
            width: 400px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal h2 {
            color: #28a745;
            margin-bottom: 15px;
        }

        .modal p {
            margin: 10px 0;
            line-height: 1.5;
        }

        .ok-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }

        .ok-btn:hover {
            background-color: #0056b3;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border: 1px solid #f5c6cb;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .ok-btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img src="src/img_logo.png" alt="NCIP Logo" class="logo">
        </a>
        <div class="header-text">
            <div class="registration-process">Registration Process</div>
            <div class="main-title">NCIP Educational Assistance</div>
        </div>
    </header>

    <div class="main-container">
        <nav class="sidebar">
            <ul>
                <li>
                    <span class="icon">👤</span>
                    <span>Personal</span>
                </li>
                <li>
                    <span class="icon">👥</span>
                    <span>Parent</span>
                </li>
                <li>
                    <span class="icon">📄</span>
                    <span>Educational<br>Background</span>
                </li>
                <li>
                    <span class="icon">✎</span>
                    <span>Degree<br>and School<br>Preference</span>
                </li>
                <li class="active">
                    <span class="icon">🔍</span>
                    <span>View and<br>Submit</span>
                </li>
            </ul>
        </nav>

        <main class="content">
            <div class="stepper">
                <div class="step completed">
                    <span class="checkmark">✓</span>
                </div>
                <div class="step-line"></div>
                <div class="step completed">
                    <span class="checkmark">✓</span>
                </div>
                <div class="step-line"></div>
                <div class="step completed">
                    <span class="checkmark">✓</span>
                </div>
                <div class="step-line"></div>
                <div class="step completed">
                    <span class="checkmark">✓</span>
                </div>
                <div class="step-line"></div>
                <div class="step active">5</div>
                <span class="step-label">View and Submit</span>
            </div>

            <div class="form-card">
                <?php if ($error_message): ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <div class="warning-text">
                    Kindly review all the information provided before submitting. Once submitted, changes can no longer be made.
                </div>

                <section class="info-section">
                    <h2>Assistance Type</h2>
                    <div class="info-field">
                        <span class="field-value"><?php echo htmlspecialchars($_SESSION["Assistance_Applied"] ?? '-'); ?></span>
                    </div>
                </section>

                <section class="info-section">
                    <h2>Personal Information</h2>
                    <div class="info-grid">
                        <div class="info-field">
                            <label>First Name</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["FirstName"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>Middle Name</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["MidName"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>Last Name</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["LastName"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>Suffix (e.g. Jr., Sr.)</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["Suffix"] ?? '-'); ?></span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-field">
                            <label>Birth Date</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["BirthDate"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>Birth Place</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["BirthPlace"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>Sex</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["Sex"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>Ethnic Group</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["EthnoGroupStudent"] ?? '-'); ?></span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-field">
                            <label>Email Address</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["EmailAdd"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>Contact Number</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["ContactNo"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>UMID/LRN Number</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["LRN"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>Civil Status</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["CivilStat"] ?? '-'); ?></span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-field full-width">
                            <label>Permanent Student Address</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["Perma_Stud_Add"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field full-width">
                            <label>Current Student Address</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["Current_Stud_Add"] ?? '-'); ?></span>
                        </div>
                    </div>
                </section>

                <section class="info-section">
                    <h2>Parent Information</h2>
                    <div class="info-grid">
                        <div class="info-field full-width">
                            <label>Full Name</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["ParentName"] ?? '-'); ?></span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-field">
                            <label>Educational Attainment</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["ParentEduc"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>Ethnic Group</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["EthnoGroupPrt"] ?? '-'); ?></span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-field full-width">
                            <label>Current Address</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["Parent_Add"] ?? '-'); ?></span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-field">
                            <label>Life Status</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["PLifeStatus"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>Primary Occupation</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["ParentPrimaryOccu"] ?? '-'); ?></span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-field full-width">
                            <label>Office Address</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["ParentOfficeAdd"] ?? '-'); ?></span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-field">
                            <label>Annual Income</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["Parent_Income"] ?? '-'); ?></span>
                        </div>
                        <div class="info-field">
                            <label>ITR Year</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["ITR_Year"] ?? '-'); ?></span>
                        </div>
                    </div>
                </section>

                <section class="info-section">
                    <h2>Educational Background</h2>
                    <div class="education-grid">
                        <div class="info-field">
                            <label>Assistance Applied</label>
                            <span class="field-value"><?php echo htmlspecialchars($_SESSION["Assistance_Applied"] ?? '-'); ?></span>
                        </div>

                        <div class="education-row">
                            <div class="info-field">
                                <label>Elementary School</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["School_Name_ES"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Year Graduated</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Year_Grad_ES"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Average Grade</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Ave_Grade_ES"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Rank</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Ranking_ES"] ?? '-'); ?></span>
                            </div>
                        </div>
                        <div class="info-field full-width">
                            <label>School Address</label>
                            <span class="field-value"><?php echo htmlspecialchars($educ_background_details['ES']['address']); ?></span>
                        </div>
                        <div class="info-field">
                            <label>School Type</label>
                            <span class="field-value"><?php echo htmlspecialchars($educ_background_details['ES']['type']); ?></span>
                        </div>

                        <div class="education-row">
                            <div class="info-field">
                                <label>Junior High School</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["School_Name_JHS"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Year Graduated</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Year_Grad_JHS"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Average Grade</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Ave_Grade_JHS"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Rank</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Ranking_JHS"] ?? '-'); ?></span>
                            </div>
                        </div>
                        <div class="info-field full-width">
                            <label>School Address</label>
                            <span class="field-value"><?php echo htmlspecialchars($educ_background_details['JHS']['address']); ?></span>
                        </div>
                        <div class="info-field">
                            <label>School Type</label>
                            <span class="field-value"><?php echo htmlspecialchars($educ_background_details['JHS']['type']); ?></span>
                        </div>

                        <div class="education-row">
                            <div class="info-field">
                                <label>Senior High School</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["School_Name_SHS"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Year Graduated</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Year_Grad_SHS"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Average Grade</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Ave_Grade_SHS"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Rank</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Ranking_SHS"] ?? '-'); ?></span>
                            </div>
                        </div>
                        <div class="info-field full-width">
                            <label>School Address</label>
                            <span class="field-value"><?php echo htmlspecialchars($educ_background_details['SHS']['address']); ?></span>
                        </div>
                        <div class="info-field">
                            <label>School Type</label>
                            <span class="field-value"><?php echo htmlspecialchars($educ_background_details['SHS']['type']); ?></span>
                        </div>

                        <div class="education-row">
                            <div class="info-field">
                                <label>College</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["School_Name_UDG"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Year Graduated</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Year_Grad_UDG"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Average Grade</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Ave_Grade_UDG"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Rank</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Ranking_UDG"] ?? '-'); ?></span>
                            </div>
                        </div>
                        <div class="info-field full-width">
                            <label>School Address</label>
                            <span class="field-value"><?php echo htmlspecialchars($educ_background_details['UDG']['address']); ?></span>
                        </div>
                        <div class="info-field">
                            <label>School Type</label>
                            <span class="field-value"><?php echo htmlspecialchars($educ_background_details['UDG']['type']); ?></span>
                        </div>

                        <div class="education-row">
                            <div class="info-field">
                                <label>Masters</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["School_Name_MT"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Year Graduated</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Year_Grad_MT"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Average Grade</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Ave_Grade_MT"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Rank</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Ranking_MT"] ?? '-'); ?></span>
                            </div>
                        </div>
                        <div class="info-field full-width">
                            <label>School Address</label>
                            <span class="field-value"><?php echo htmlspecialchars($educ_background_details['MT']['address']); ?></span>
                        </div>
                        <div class="info-field">
                            <label>School Type</label>
                            <span class="field-value"><?php echo htmlspecialchars($educ_background_details['MT']['type']); ?></span>
                        </div>
                    </div>
                </section>

                <section class="info-section">
                    <h2>Degree and School Preference</h2>
                    <div class="priority-section">
                        <h3>Priority 1:</h3>
                        <div class="school-info-grid">
                            <div class="info-field full-width">
                                <label>Preferred School</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["First_School_Choice"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field full-width">
                                <label>School Address</label>
                                <span class="field-value"><?php echo htmlspecialchars($school_details[1]['address']); ?></span>
                            </div>
                            <div class="info-field">
                                <label>School Type</label>
                                <span class="field-value"><?php echo htmlspecialchars($school_details[1]['type']); ?></span>
                            </div>
                        </div>
                        <div class="program-info-grid">
                            <div class="info-field">
                                <label>Preferred Program</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["First_Degree_Choice"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Duration (in years)</label>
                                <span class="field-value"><?php echo htmlspecialchars($degree_details[1]['duration']); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="priority-section">
                        <h3>Priority 2:</h3>
                        <div class="school-info-grid">
                            <div class="info-field full-width">
                                <label>Preferred School</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Second_School_Choice"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field full-width">
                                <label>School Address</label>
                                <span class="field-value"><?php echo htmlspecialchars($school_details[2]['address']); ?></span>
                            </div>
                            <div class="info-field">
                                <label>School Type</label>
                                <span class="field-value"><?php echo htmlspecialchars($school_details[2]['type']); ?></span>
                            </div>
                        </div>
                        <div class="program-info-grid">
                            <div class="info-field">
                                <label>Preferred Program</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Second_Degree_Choice"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Duration (in years)</label>
                                <span class="field-value"><?php echo htmlspecialchars($degree_details[2]['duration']); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="priority-section">
                        <h3>Priority 3:</h3>
                        <div class="school-info-grid">
                            <div class="info-field full-width">
                                <label>Preferred School</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Third_School_Choice"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field full-width">
                                <label>School Address</label>
                                <span class="field-value"><?php echo htmlspecialchars($school_details[3]['address']); ?></span>
                            </div>
                            <div class="info-field">
                                <label>School Type</label>
                                <span class="field-value"><?php echo htmlspecialchars($school_details[3]['type']); ?></span>
                            </div>
                        </div>
                        <div class="program-info-grid">
                            <div class="info-field">
                                <label>Preferred Program</label>
                                <span class="field-value"><?php echo htmlspecialchars($_SESSION["Third_Degree_Choice"] ?? '-'); ?></span>
                            </div>
                            <div class="info-field">
                                <label>Duration (in years)</label>
                                <span class="field-value"><?php echo htmlspecialchars($degree_details[3]['duration']); ?></span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Educational Background and Degree Preference sections would go here -->
                <!-- Truncated for brevity, but would display session data similarly -->

                <form method="post" action="">
                    <input type="hidden" name="submit_application" value="1">
                    <div class="button-group">
                        <button type="button" class="back-btn" onclick="window.location.href='preference.php'">Back</button>
                        <button type="submit" class="submit-btn">Submit Application</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>