<?php
require_once __DIR__ . '/includes/db_connection.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("No applicant ID provided");
}

// Sanitize input
$appli_num = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if ($appli_num === false) {
    die("Invalid applicant ID: " . htmlspecialchars($_GET['id']));
}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

error_log("Processing Appli_Num: " . $appli_num);

$query = "SELECT 
            ap.*,
            ad.Appli_Num,
            ad.Assistance_Type,

            CONCAT_WS('|', s_es.School_Name, eb_es.Year_Grad, eb_es.Ave_Grade, eb_es.ranking) AS Elementary_Details,
            CONCAT_WS('|', s_jhs.School_Name, eb_jhs.Year_Grad, eb_jhs.Ave_Grade, eb_jhs.ranking) AS JHS_Details,
            CONCAT_WS('|', s_shs.School_Name, eb_shs.Year_Grad, eb_shs.Ave_Grade, eb_shs.ranking) AS SHS_Details,

            GROUP_CONCAT(
                IF(pl.PrioNum = 1, CONCAT_WS('|', s2.School_Name, dp.DegreeProgram), NULL)
            ) AS First_Choice,
            GROUP_CONCAT(
                IF(pl.PrioNum = 2, CONCAT_WS('|', s2.School_Name, dp.DegreeProgram), NULL)
            ) AS Second_Choice,
            GROUP_CONCAT(
                IF(pl.PrioNum = 3, CONCAT_WS('|', s2.School_Name, dp.DegreeProgram), NULL)
            ) AS Third_Choice

        FROM appli_details ad
        LEFT JOIN appli_profile ap ON ad.LRN = ap.LRN

        LEFT JOIN educ_bg eb_es ON ap.LRN = eb_es.LRN AND eb_es.Educ_Background = 'ES'
        LEFT JOIN schooldetails s_es ON eb_es.SchoolCode = s_es.School_Code

        LEFT JOIN educ_bg eb_jhs ON ap.LRN = eb_jhs.LRN AND eb_jhs.Educ_Background = 'JHS'
        LEFT JOIN schooldetails s_jhs ON eb_jhs.SchoolCode = s_jhs.School_Code

        LEFT JOIN educ_bg eb_shs ON ap.LRN = eb_shs.LRN AND eb_shs.Educ_Background = 'SHS'
        LEFT JOIN schooldetails s_shs ON eb_shs.SchoolCode = s_shs.School_Code

        LEFT JOIN educ_bg eb_udg ON ap.LRN = eb_udg.LRN AND eb_udg.Educ_Background = 'UDG'
     LEFT JOIN schooldetails s_udg ON eb_udg.SchoolCode = s_udg.School_Code

        LEFT JOIN prioritylist pl ON ad.Appli_Num = pl.Appli_Num
        LEFT JOIN schooldetails s2 ON pl.School_Code = s2.School_Code
        LEFT JOIN degree_program dp ON pl.DegCode = dp.DegCode

        WHERE ad.Appli_Num = ?
        GROUP BY ad.Appli_Num, ad.Assistance_Type, ap.LRN";


try {
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        error_log("Query preparation failed: " . $conn->error);
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $appli_num);
    $stmt->execute();
    $result = $stmt->get_result();
    error_log("Rows returned: " . $result->num_rows);
    $applicant = $result->fetch_assoc();

    $stmt->close();
} catch (Exception $e) {
    error_log("Error executing query: " . $e->getMessage());
    die("Error executing query: " . $e->getMessage());
}

if (!$applicant) {
    die("Applicant not found for Appli_Num: " . $appli_num);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applicant Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #1B2738; /* Dark blue background */
            color: #fff;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background-color: #1B2738;
            padding: 15px;
            border-radius: 4px;
            color: white;
        }
        .back-btn {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .section {
            margin-bottom: 30px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #1B2738;
        }
        .section-header {
            font-size: 16px;
            color: #1B2738;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .info-field {
            border: 1px solid #e0e0e0;
            padding: 8px 12px;
            border-radius: 4px;
            background-color: #f8f9fa;
            margin-bottom: 15px;
        }
        .info-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 14px;
            color: #333;
        }
        .subsection-title {
            font-size: 16px;
            color: #1B2738;
            margin: 15px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        h1 {
            color: white;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="admin.php" class="back-btn">Back to Overview</a>
            <h1><?php echo htmlspecialchars($applicant['FirstName'] . ' ' . $applicant['LastName']); ?></h1>
        </div>

        <div class="section">
            <div class="section-header">Applicant Number</div>
            <div class="info-grid">
                <div class="info-field full-width">
                    <div class="info-label">Applicant Number</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['Appli_Num']); ?></div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">Assistance Applied & Type</div>
            <div class="info-grid">
                <div class="info-field">
                    <div class="info-label">Assistance Applied</div>
                    <div class="info-value">College</div>
                </div>
                <div class="info-field">
                    <div class="info-label">Assistance Type</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['Assistance_Type']); ?></div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">Personal Information</div>
            <div class="info-grid">
                <div class="info-field">
                    <div class="info-label">First Name</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['FirstName']); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Middle Name</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['MidName']); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Last Name</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['LastName']); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Suffix (e.g.: III, Jr)</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['Suffix'] ?? 'N/A'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Birth Date</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['BirthDate']); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Birth Place</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['BirthPlace']); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Sex</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['Sex']); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Civil Status</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['CivilStat']); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Contact Number</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['ContactNo']); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Email Address</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['EmailAdd']); ?></div>
                </div>
                <div class="info-field full-width">
                    <div class="info-label">Permanent Student Address</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['Perma_Stud_Add']); ?></div>
                </div>
                <div class="info-field full-width">
                    <div class="info-label">Current Student Address</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['Current_Stud_Add']); ?></div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Parent Information</div>
            <div class="info-grid">
                <div class="info-field full-width">
                    <div class="info-label">Full Name</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['ParentName'] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Educational Attainment</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['ParentEduc'] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Ethnic Group</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['EthnoGroupPrt'] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field full-width">
                    <div class="info-label">Current Address</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['Parent_Add'] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Life Status</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['PLifeStatus'] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Primary Occupation</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['ParentPrimaryOccu'] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field full-width">
                    <div class="info-label">Office Address</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['ParentOfficeAdd'] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Annual Income</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['Parent_Income'] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">ITR Year</div>
                    <div class="info-value"><?php echo htmlspecialchars($applicant['ITR_Year'] ?? 'Not provided'); ?></div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Educational Background</div>
            <?php
            $elementary_details = explode('|', $applicant['Elementary_Details'] ?? '||||');
            $jhs_details = explode('|', $applicant['JHS_Details'] ?? '||||');
            $shs_details = explode('|', $applicant['SHS_Details'] ?? '||||');
            ?>
            
            <!-- Elementary School -->
            <h3 class="subsection-title">Elementary School</h3>
            <div class="info-grid">
                <div class="info-field">
                    <div class="info-label">School Name</div>
                    <div class="info-value"><?php echo htmlspecialchars($elementary_details[0] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Year Graduated</div>
                    <div class="info-value"><?php echo htmlspecialchars($elementary_details[1] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Average Grade</div>
                    <div class="info-value"><?php echo htmlspecialchars($elementary_details[2] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Ranking</div>
                    <div class="info-value"><?php echo htmlspecialchars($elementary_details[3] ?? 'Not provided'); ?></div>
                </div>
            </div>

            <!-- Junior High School -->
            <h3 class="subsection-title">Junior High School</h3>
            <div class="info-grid">
                <div class="info-field">
                    <div class="info-label">School Name</div>
                    <div class="info-value"><?php echo htmlspecialchars($jhs_details[0] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Year Graduated</div>
                    <div class="info-value"><?php echo htmlspecialchars($jhs_details[1] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Average Grade</div>
                    <div class="info-value"><?php echo htmlspecialchars($jhs_details[2] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Ranking</div>
                    <div class="info-value"><?php echo htmlspecialchars($jhs_details[3] ?? 'Not provided'); ?></div>
                </div>
            </div>

            <!-- Senior High School -->
            <h3 class="subsection-title">Senior High School</h3>
            <div class="info-grid">
                <div class="info-field">
                    <div class="info-label">School Name</div>
                    <div class="info-value"><?php echo htmlspecialchars($shs_details[0] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Year Graduated</div>
                    <div class="info-value"><?php echo htmlspecialchars($shs_details[1] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Average Grade</div>
                    <div class="info-value"><?php echo htmlspecialchars($shs_details[2] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Ranking</div>
                    <div class="info-value"><?php echo htmlspecialchars($shs_details[3] ?? 'Not provided'); ?></div>
                </div>
            </div>
        </div>

        <?php
        // Parse the choices
        $first_choice = explode('|', $applicant['First_Choice'] ?? '|');
        $second_choice = explode('|', $applicant['Second_Choice'] ?? '|');
        $third_choice = explode('|', $applicant['Third_Choice'] ?? '|');
        ?>

        <div class="section">
            <div class="section-title">Degree and School Preference</div>
            
            <!-- Priority 1 -->
            <h3 class="subsection-title">Priority 1:</h3>
            <div class="info-grid">
                <div class="info-field">
                    <div class="info-label">Preferred School</div>
                    <div class="info-value"><?php echo htmlspecialchars($first_choice[0] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">School Address</div>
                    <div class="info-value">Anonas Street, Sta. Mesa, Manila</div>
                </div>
                <div class="info-field">
                    <div class="info-label">School Type</div>
                    <div class="info-value">SUC Main</div>
                </div>
                <div class="info-field">
                    <div class="info-label">Preferred Program</div>
                    <div class="info-value"><?php echo htmlspecialchars($first_choice[1] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Duration (in years)</div>
                    <div class="info-value">4</div>
                </div>
            </div>

            <!-- Priority 2 -->
            <h3 class="subsection-title">Priority 2:</h3>
            <div class="info-grid">
                <div class="info-field">
                    <div class="info-label">Preferred School</div>
                    <div class="info-value"><?php echo htmlspecialchars($second_choice[0] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">School Address</div>
                    <div class="info-value">Diliman, Quezon City, Metro Manila</div>
                </div>
                <div class="info-field">
                    <div class="info-label">School Type</div>
                    <div class="info-value">SUC Main</div>
                </div>
                <div class="info-field">
                    <div class="info-label">Preferred Program</div>
                    <div class="info-value"><?php echo htmlspecialchars($second_choice[1] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Duration (in years)</div>
                    <div class="info-value">5</div>
                </div>
            </div>

            <!-- Priority 3 -->
            <h3 class="subsection-title">Priority 3:</h3>
            <div class="info-grid">
                <div class="info-field">
                    <div class="info-label">Preferred School</div>
                    <div class="info-value"><?php echo htmlspecialchars($third_choice[0] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">School Address</div>
                    <div class="info-value">Los Baños, Laguna</div>
                </div>
                <div class="info-field">
                    <div class="info-label">School Type</div>
                    <div class="info-value">SUC Satellite</div>
                </div>
                <div class="info-field">
                    <div class="info-label">Preferred Program</div>
                    <div class="info-value"><?php echo htmlspecialchars($third_choice[1] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-field">
                    <div class="info-label">Duration (in years)</div>
                    <div class="info-value">3</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>