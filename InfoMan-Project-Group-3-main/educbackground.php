<?php
session_start();
if (isset($_POST["next2"]) || isset($_POST["back1"])) {
    $_SESSION["Assistance_Applied"] = $_POST["Assistance_Applied"];

    $_SESSION["School_Name_ES"] = $_POST["School_Name_ES"];
    $_SESSION["Ave_Grade_ES"] = $_POST["Ave_Grade_ES"];
    $_SESSION["Ranking_ES"] = $_POST["Ranking_ES"];
    $_SESSION["Year_Grad_ES"] = $_POST["Year_Grad_ES"];

    $_SESSION["School_Name_JHS"] = $_POST["School_Name_JHS"];
    $_SESSION["Ave_Grade_JHS"] = $_POST["Ave_Grade_JHS"];
    $_SESSION["Ranking_JHS"] = $_POST["Ranking_JHS"];
    $_SESSION["Year_Grad_JHS"] = $_POST["Year_Grad_JHS"];

    $_SESSION["School_Name_SHS"] = $_POST["School_Name_SHS"];
    $_SESSION["Ave_Grade_SHS"] = $_POST["Ave_Grade_SHS"];
    $_SESSION["Ranking_SHS"] = $_POST["Ranking_SHS"];
    $_SESSION["Year_Grad_SHS"] = $_POST["Year_Grad_SHS"];

    $_SESSION["School_Name_UDG"] = $_POST["School_Name_UDG"];
    $_SESSION["Ave_Grade_UDG"] = $_POST["Ave_Grade_UDG"];
    $_SESSION["Ranking_UDG"] = $_POST["Ranking_UDG"];
    $_SESSION["Year_Grad_UDG"] = $_POST["Year_Grad_UDG"];

    $_SESSION["School_Name_MT"] = $_POST["School_Name_MT"];
    $_SESSION["Ave_Grade_MT"] = $_POST["Ave_Grade_MT"];
    $_SESSION["Ranking_MT"] = $_POST["Ranking_MT"];
    $_SESSION["Year_Grad_MT"] = $_POST["Year_Grad_MT"];

    if (isset($_POST["next2"])) {
        header("Location: preference.php");
        exit();
    } elseif (isset($_POST["back1"])) {
        header("Location: parentinfo.php");
        exit();
    }
}

$servername = "localhost";
$username = "root";
$password = "polo0210";
$dbname = "main database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getSchoolChoices($conn, $levelCondition) {
    $stmt = $conn->prepare("SELECT school_code, school_name FROM schooldetails WHERE $levelCondition ORDER BY school_name ASC");
    $stmt->execute();
    return $stmt->get_result();
}

$elemchoice = getSchoolChoices($conn, "schoollevel LIKE 'ELEM%'");
$jhschoice = getSchoolChoices($conn, "schoollevel LIKE '%HS%' OR schoollevel = 'TERTIARY'");
$shschoice = getSchoolChoices($conn, "schoollevel LIKE '%HS%' OR schoollevel = 'TERTIARY'");
$undergradchoice = getSchoolChoices($conn, "schoollevel = 'TERTIARY'");
$masterschoice = getSchoolChoices($conn, "schoollevel = 'TERTIARY'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NCIP Educational Assistance - Educational Background</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="educationaldesign.css">
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
                <li class="active">
                    <span class="icon">📄</span>
                    <span>Educational<br>Background</span>
                </li>
                <li>
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
                <div class="step active">3</div>
                <div class="step-line"></div>
                <div class="step">4</div>
                <div class="step-line"></div>
                <div class="step">5</div>
                <span class="step-label">Educational Background</span>
            </div>

            <div class="form-card">
                <p class="required-text">Fields marked with a red asterisk (<span class="required">*</span>) are required.<br> <strong>Note:</strong> Please fill in your educational background up to the level just below what you're applying for.</p>
                <form method="POST" action="educbackground.php">
                    <div class="form-row">
                        <div class="form-group full-width">
                            <select id="assistanceType" name="Assistance_Applied" required>
                                <option value="" disabled selected>Assistance Applied</option>
                                <option value="College" <?= (isset($_SESSION['Assistance_Applied']) && $_SESSION['Assistance_Applied'] === 'College') ? 'selected' : '' ?>>College</option>
                                <option value="Masters" <?= (isset($_SESSION['Assistance_Applied']) && $_SESSION['Assistance_Applied'] === 'Masters') ? 'selected' : '' ?>>Master's</option>
                                <option value="PHD" <?= (isset($_SESSION['Assistance_Applied']) && $_SESSION['Assistance_Applied'] === 'PHD') ? 'selected' : '' ?>>PhD/Doctorate</option>
                            </select>
                            <span class="required">*</span>
                        </div>
                    </div>

                    <!-- Elementary School -->
                    <div class="form-row">
                        <div class="form-group">
                            <select name="School_Name_ES" required>
                                <option value="" disabled <?= !isset($_SESSION["School_Name_ES"]) ? 'selected' : '' ?>>Elementary School</option>
                                <?php while ($row = $elemchoice->fetch_assoc()): ?>
                                    <option value="<?= (htmlspecialchars($row['school_name'])) ?>" 
                                        <?= (isset($_SESSION["School_Name_ES"]) && $_SESSION["School_Name_ES"] == $row['school_name']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['school_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>        
                        </div>
                        <div class="form-group">
                            <input type="number" name="Year_Grad_ES" min="1900" max="2099" placeholder="Year Graduated" required
                                value="<?= isset($_SESSION["Year_Grad_ES"]) ? htmlspecialchars($_SESSION["Year_Grad_ES"]) : '' ?>">
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <input type="number" name="Ave_Grade_ES" min="75" max="100" step="0.01" placeholder="Average Grade" required
                                value="<?= isset($_SESSION["Ave_Grade_ES"]) ? htmlspecialchars($_SESSION["Ave_Grade_ES"]) : '' ?>">
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <select name="Ranking_ES" required>
                                <option value="" disabled selected>Rank</option>
                                <option value="Highest" <?= (isset($_SESSION['Ranking_ES']) && $_SESSION['Ranking_ES'] === 'Highest') ? 'selected' : '' ?>>With Highest Honors</option>
                                <option value="High" <?= (isset($_SESSION['Ranking_ES']) && $_SESSION['Ranking_ES'] === 'High') ? 'selected' : '' ?>>With High Honors</option>
                                <option value="Honors" <?= (isset($_SESSION['Ranking_ES']) && $_SESSION['Ranking_ES'] === 'Honors') ? 'selected' : '' ?>>With Honors</option>
                                <option value="NA" <?= (isset($_SESSION['Ranking_ES']) && $_SESSION['Ranking_ES'] === 'NA') ? 'selected' : '' ?>>N/A</option>
                            </select>
                            <span class="required">*</span>
                        </div>
                    </div>

                    <!-- Junior High School -->
                    <div class="form-row">
                        <div class="form-group">
                            <select name="School_Name_JHS" required>
                                <option value="" disabled <?= !isset($_SESSION["School_Name_JHS"]) ? 'selected' : '' ?>>Junior High School</option>
                                <?php while ($row = $jhschoice->fetch_assoc()): ?>
                                    <option value="<?= (htmlspecialchars($row['school_name'])) ?>"
                                        <?= isset($_SESSION["School_Name_JHS"]) && $_SESSION["School_Name_JHS"] == $row['school_name'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['school_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" name="Year_Grad_JHS" min="1900" max="2099" placeholder="Year Graduated" required
                                value="<?= isset($_SESSION["Year_Grad_JHS"]) ? htmlspecialchars($_SESSION["Year_Grad_JHS"]) : '' ?>">
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <input type="number" name="Ave_Grade_JHS" min="75" max="100" step="0.01" placeholder="Average Grade" required
                                value="<?= isset($_SESSION["Ave_Grade_JHS"]) ? htmlspecialchars($_SESSION["Ave_Grade_JHS"]) : '' ?>">
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <select name="Ranking_JHS" required>
                                <option value="" disabled selected>Rank</option>
                                <option value="Highest" <?= (isset($_SESSION['Ranking_JHS']) && $_SESSION['Ranking_JHS'] === 'Highest') ? 'selected' : '' ?>>With Highest Honors</option>
                                <option value="High" <?= (isset($_SESSION['Ranking_JHS']) && $_SESSION['Ranking_JHS'] === 'High') ? 'selected' : '' ?>>With High Honors</option>
                                <option value="Honors" <?= (isset($_SESSION['Ranking_JHS']) && $_SESSION['Ranking_JHS'] === 'Honors') ? 'selected' : '' ?>>With Honors</option>
                                <option value="NA" <?= (isset($_SESSION['Ranking_JHS']) && $_SESSION['Ranking_JHS'] === 'NA') ? 'selected' : '' ?>>N/A</option>
                            </select>
                            <span class="required">*</span>
                        </div>
                    </div>

                    <!-- Senior High School -->
                    <div class="form-row">
                        <div class="form-group">
                            <select name="School_Name_SHS" required>
                                <option value="" disabled <?= !isset($_SESSION["School_Name_SHS"]) ? 'selected' : '' ?>>Senior High School</option>
                                <?php while ($row = $shschoice->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($row['school_name']) ?>"
                                        <?= (isset($_SESSION["School_Name_SHS"]) && $_SESSION["School_Name_SHS"] === $row['school_name']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['school_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>    
                        <div class="form-group">
                            <input type="number" name="Year_Grad_SHS" min="1900" max="2099" placeholder="Year Graduated" required
                                value="<?= isset($_SESSION["Year_Grad_SHS"]) ? htmlspecialchars($_SESSION["Year_Grad_SHS"]) : '' ?>">
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <input type="number" name="Ave_Grade_SHS" min="75" max="100" step="0.01" placeholder="Average Grade" required
                                value="<?= isset($_SESSION["Ave_Grade_SHS"]) ? htmlspecialchars($_SESSION["Ave_Grade_SHS"]) : '' ?>">
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <select name="Ranking_SHS" required>
                                <option value="" disabled selected>Rank</option>
                                <option value="Highest" <?= (isset($_SESSION['Ranking_SHS']) && $_SESSION['Ranking_SHS'] === 'Highest') ? 'selected' : '' ?>>With Highest Honors</option>
                                <option value="High" <?= (isset($_SESSION['Ranking_SHS']) && $_SESSION['Ranking_SHS'] === 'High') ? 'selected' : '' ?>>With High Honors</option>
                                <option value="Honors" <?= (isset($_SESSION['Ranking_SHS']) && $_SESSION['Ranking_SHS'] === 'Honors') ? 'selected' : '' ?>>With Honors</option>
                                <option value="NA" <?= (isset($_SESSION['Ranking_SHS']) && $_SESSION['Ranking_SHS'] === 'NA') ? 'selected' : '' ?>>N/A</option>
                                </select>
                            <span class="required">*</span>
                        </div>
                    </div>

                    <!-- College (Undergraduate) -->
                    <div class="form-row">
                        <div class="form-group">
                            <select name="School_Name_UDG" >
                                <option value="" disabled <?= !isset($_SESSION["School_Name_UDG"]) ? 'selected' : '' ?>>Undergraduate</option>
                                <?php while ($row = $undergradchoice->fetch_assoc()): ?>
                                    <option value="<?= (htmlspecialchars($row['school_name'])) ?>"
                                        <?= (isset($_SESSION["School_Name_UDG"]) && $_SESSION["School_Name_UDG"] === $row['school_name']) ? 'selected' : '' ?>> 
                                        <?= htmlspecialchars($row['school_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" name="Year_Grad_UDG" min="1900" max="2099" placeholder="Year Graduated" 
                              value="<?= isset($_SESSION["Year_Grad_UDG"]) ? htmlspecialchars($_SESSION["Year_Grad_UDG"]) : '' ?>">
                            <span class="required"></span>
                        </div>
                        <div class="form-group">
                            <input type="number" name="Ave_Grade_UDG" min="1" max="5" step="0.01" placeholder="Average Grade" 
                             value="<?= isset($_SESSION["Ave_Grade_UDG"]) ? htmlspecialchars($_SESSION["Ave_Grade_UDG"]) : '' ?>">
                            <span class="required"></span>
                        </div>
                        <div class="form-group">
                            <select name="Ranking_UDG" >
                                <option value="" disabled selected>Rank</option>
                                <option value="Highest" <?= (isset($_SESSION['Ranking_UDG']) && $_SESSION['Ranking_UDG'] === 'Highest') ? 'selected' : '' ?>>With Highest Honors</option>
                                <option value="High" <?= (isset($_SESSION['Ranking_UDG']) && $_SESSION['Ranking_UDG'] === 'High') ? 'selected' : '' ?>>With High Honors</option>
                                <option value="Honors" <?= (isset($_SESSION['Ranking_UDG']) && $_SESSION['Ranking_UDG'] === 'Honors') ? 'selected' : '' ?>>With Honors</option>
                                <option value="NA" <?= (isset($_SESSION['Ranking_UDG']) && $_SESSION['Ranking_UDG'] === 'NA') ? 'selected' : '' ?>>N/A</option>
                            </select>
                            <span class="required"></span>
                        </div>
                    </div>

                    <!-- Master's Degree -->
                    <div class="form-row">
                        <div class="form-group">
                            <select name="School_Name_MT" >
                                <option value="" disabled selected>Master's Degree</option>
                                <?php while ($row = $masterschoice->fetch_assoc()): ?>
                                    <option value="<?= (htmlspecialchars($row['school_name'])) ?>"
                                        <?= (isset($_SESSION["School_Name_UDG"]) && $_SESSION["School_Name_UDG"] === $row['school_name']) ? 'selected' : '' ?>> 
                                        <?= htmlspecialchars($row['school_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" name="Year_Grad_MT" min="1900" max="2099" placeholder="Year Graduated" 
                            value="<?= isset($_SESSION["Year_Grad_MT"]) ? htmlspecialchars($_SESSION["Year_Grad_MT"]) : '' ?>">
                            <span class="required"></span>
                        </div>
                        <div class="form-group">
                            <input type="number" name="Ave_Grade_MT" min="1" max="5" step="0.01" placeholder="Average Grade" 
                            value="<?= isset($_SESSION["Ave_Grade_MT"]) ? htmlspecialchars($_SESSION["Ave_Grade_MT"]) : '' ?>">
                            <span class="required"></span>
                        </div>
                        <div class="form-group">
                            <select name="Ranking_MT" >
                                <option value="" disabled selected>Rank</option>
                                <option value="Highest" <?= (isset($_SESSION['Ranking_MT']) && $_SESSION['Ranking_MT'] === 'Highest') ? 'selected' : '' ?>>With Highest Honors</option>
                                <option value="High" <?= (isset($_SESSION['Ranking_MT']) && $_SESSION['Ranking_MT'] === 'High') ? 'selected' : '' ?>>With High Honors</option>
                                <option value="Honors" <?= (isset($_SESSION['Ranking_MT']) && $_SESSION['Ranking_MT'] === 'Honors') ? 'selected' : '' ?>>With Honors</option>
                                <option value="NA" <?= (isset($_SESSION['Ranking_MT']) && $_SESSION['Ranking_MT'] === 'NA') ? 'selected' : '' ?>>N/A</option>
                            </select>
                            <span class="required"></span>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" name="back1" formnovalidate class="back-btn">Back</button>
                        <button type="submit" name="next2" class="next-btn">Next</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>  