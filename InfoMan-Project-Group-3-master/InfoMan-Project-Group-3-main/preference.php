<?php
session_start();
if (isset($_POST["next3"]) || isset($_POST["back2"])) {
$_SESSION["First_School_Choice"] = $_POST["First_School_Choice"];
$_SESSION["First_Degree_Choice"] = $_POST["First_Degree_Choice"];
$_SESSION["Second_School_Choice"] = $_POST["Second_School_Choice"];
$_SESSION["Second_Degree_Choice"] = $_POST["Second_Degree_Choice"];
$_SESSION["Third_School_Choice"] = $_POST["Third_School_Choice"];
$_SESSION["Third_Degree_Choice"] = $_POST["Third_Degree_Choice"];

    if (isset($_POST["next3"])) {
        header("Location: submit.php");
        exit();
    } elseif (isset($_POST["back2"])) {
        header("Location: educbackground.php");
        exit();
    }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scholarship";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getPreferredSchool($conn, $levelCondition) {
    $stmt = $conn->prepare("SELECT school_code, school_name FROM schooldetails WHERE $levelCondition ORDER BY school_name ASC");
    $stmt->execute();
    return $stmt->get_result();
}

$preferredSchool1 = getPreferredSchool($conn, "schoollevel = 'TERTIARY'");
$preferredSchool2 = getPreferredSchool($conn, "schoollevel = 'TERTIARY'");
$preferredSchool3 = getPreferredSchool($conn, "schoollevel = 'TERTIARY'");

function getPreferredPrograms($conn, $level) {
    $stmt = $conn->prepare("SELECT degcode, degreeprogram FROM degree_program WHERE deglevel = ? ORDER BY degreeprogram ASC");
    $stmt->bind_param("s", $level);
    $stmt->execute();
    return $stmt->get_result();
}

$level = '';
if (isset($_SESSION["Assistance_Applied"])) {
    if ($_SESSION["Assistance_Applied"] == "College") {
        $level = 'Undergrad';
    } elseif ($_SESSION["Assistance_Applied"] == "Masters") {
        $level = 'Masters';
    } elseif ($_SESSION["Assistance_Applied"] == "PHD") {
        $level = 'Phd';
    }
}

$preferredProgram1 = ($level !== '') ? getPreferredPrograms($conn, $level) : null;
$preferredProgram2 = ($level !== '') ? getPreferredPrograms($conn, $level) : null;
$preferredProgram3 = ($level !== '') ? getPreferredPrograms($conn, $level) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NCIP Educational Assistance - Degree and School Preference</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="degreedesign.css">
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
                <li class="active">
                    <span class="icon">✎</span>
                    <span>Degree<br>and School<br>Preference</span>
                </li>
                <li>
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
                <div class="step active">4</div>
                <div class="step-line"></div>
                <div class="step">5</div>
                <span class="step-label">Degree and School Preference</span>
            </div>

            <div class="form-card">
                <form action="preference.php" method="POST">

                    <!-- Priority 1 -->
                    <div class="priority-section">
                        <h2>Priority 1:</h2>
                        <div class="preference-row">
                            <div class="form-group">
                                <label>Preferred School</label>
                                <select name="First_School_Choice" required>
                                    <option value="" disabled <?= !isset($_SESSION["First_School_Choice"]) ? 'selected' : '' ?>>First Choice</option>
                                    <?php while ($row = $preferredSchool1->fetch_assoc()): ?>
                                        <option value="<?= htmlspecialchars($row['school_name']) ?>" 
                                            <?= (isset($_SESSION["First_School_Choice"]) && $_SESSION["First_School_Choice"] === $row['school_name']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row['school_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Preferred Program</label>
                                <select name="First_Degree_Choice" required>
                                    <option value="" disabled <?= !isset($_SESSION["First_Degree_Choice"]) ? 'selected' : '' ?>>First Choice</option>
                                    <?php if ($preferredProgram1): ?>
                                        <?php while ($row = $preferredProgram1->fetch_assoc()): ?>
                                            <option value="<?= htmlspecialchars($row['degreeprogram']) ?>" 
                                                <?= (isset($_SESSION["First_Degree_Choice"]) && $_SESSION["First_Degree_Choice"] === $row['degreeprogram']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($row['degreeprogram']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Priority 2 -->
                    <div class="priority-section">
                        <h2>Priority 2:</h2>
                        <div class="preference-row">
                            <div class="form-group">
                                <label>Preferred School</label>
                                <select name="Second_School_Choice" required>
                                    <option value="" disabled <?= !isset($_SESSION["Second_School_Choice"]) ? 'selected' : '' ?>>Second Choice</option>
                                    <?php while ($row = $preferredSchool2->fetch_assoc()): ?>
                                        <option value="<?= htmlspecialchars($row['school_name']) ?>" 
                                            <?= (isset($_SESSION["Second_School_Choice"]) && $_SESSION["Second_School_Choice"] === $row['school_name']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row['school_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Preferred Program</label>
                                <select name="Second_Degree_Choice" required>
                                    <option value="" disabled <?= !isset($_SESSION["Second_Degree_Choice"]) ? 'selected' : '' ?>>Second Choice</option>
                                    <?php if ($preferredProgram2): ?>
                                        <?php while ($row = $preferredProgram2->fetch_assoc()): ?>
                                            <option value="<?= htmlspecialchars($row['degreeprogram']) ?>" 
                                                <?= (isset($_SESSION["Second_Degree_Choice"]) && $_SESSION["Second_Degree_Choice"] === $row['degreeprogram']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($row['degreeprogram']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Priority 3 -->
                    <div class="priority-section">
                        <h2>Priority 3:</h2>
                        <div class="preference-row">
                            <div class="form-group">
                                <label>Preferred School</label>
                                <select name="Third_School_Choice" required>
                                    <option value="" disabled <?= !isset($_SESSION["Third_School_Choice"]) ? 'selected' : '' ?>>Third Choice</option>
                                    <?php while ($row = $preferredSchool3->fetch_assoc()): ?>
                                        <option value="<?= htmlspecialchars($row['school_name']) ?>" 
                                            <?= (isset($_SESSION["Third_School_Choice"]) && $_SESSION["Third_School_Choice"] === $row['school_name']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row['school_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Preferred Program</label>
                                <select name="Third_Degree_Choice" required>
                                    <option value="" disabled <?= !isset($_SESSION["Third_Degree_Choice"]) ? 'selected' : '' ?>>Third Choice</option>
                                    <?php if ($preferredProgram3): ?>
                                        <?php while ($row = $preferredProgram3->fetch_assoc()): ?>
                                            <option value="<?= htmlspecialchars($row['degreeprogram']) ?>" 
                                                <?= (isset($_SESSION["Third_Degree_Choice"]) && $_SESSION["Third_Degree_Choice"] === $row['degreeprogram']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($row['degreeprogram']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" name="back2" formnovalidate class="back-btn">Back</button>
                        <button type="submit" name="next3" class="next-btn">Next</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
