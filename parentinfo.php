<?php
session_start();
if(isset($_POST["back"]) || isset($_POST["next1"])) {
    $_SESSION["ParentName"] = $_POST["ParentName"];
    $_SESSION["ParentEduc"] = $_POST["ParentEduc"];
    $_SESSION["EthnoGroupPrt"] = $_POST["EthnoGroupPrt"];
    $_SESSION["Parent_Add"] = $_POST["Parent_Add"];
    $_SESSION["PLifeStatus"] = $_POST["PLifeStatus"];
    $_SESSION["ParentPrimaryOccu"] = $_POST["ParentPrimaryOccu"];
    $_SESSION["ParentOfficeAdd"] = $_POST["ParentOfficeAdd"];
    $_SESSION["Parent_Income"] = $_POST["Parent_Income"];
    $_SESSION["ITR_Year"] = $_POST["ITR_Year"];

    if (isset($_POST["next1"])) {
        header("Location: educbackground.php");
        exit();
    } elseif (isset($_POST["back"])) {
        header("Location: personalinfo.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>NCIP Educational Assistance - Parent's Information</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="parentdesign.css" />
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img src="src/img_logo.png" alt="NCIP Logo" class="logo" />
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
                <li class="active">
                    <span class="icon">👥</span>
                    <span>Parent</span>
                </li>
                <li>
                    <span class="icon">📄</span>
                    <span>Educational<br />Background</span>
                </li>
                <li>
                    <span class="icon">✎</span>
                    <span>Degree<br />and School<br />Preference</span>
                </li>
                <li>
                    <span class="icon">🔍</span>
                    <span>View and<br />Submit</span>
                </li>
            </ul>
        </nav>

        <main class="content">
            <div class="stepper">
                <div class="step completed">
                    <span class="checkmark">✓</span>
                </div>
                <div class="step-line"></div>
                <div class="step active">2</div>
                <div class="step-line"></div>
                <div class="step">3</div>
                <div class="step-line"></div>
                <div class="step">4</div>
                <div class="step-line"></div>
                <div class="step">5</div>
                <span class="step-label">Parent's Information</span>
            </div>

            <div class="form-card">
                <form method="POST" action="parentinfo.php">
                    <div class="form-row">
                        <input type="text" name="ParentName" placeholder="Full Name" required
                             value="<?= isset($_SESSION["ParentName"]) ? htmlspecialchars($_SESSION["ParentName"]) : '' ?>"/>

                        <select name="ParentEduc" required>
                            <option value="" disabled selected hidden <?= isset($_SESSION['ParentEduc']) ? 'selected' : '' ?>>Educational Attainment</option>
                            <option value="Elementary" <?= (isset($_SESSION['ParentEduc']) && $_SESSION['ParentEduc'] === 'Elementary') ? 'selected' : '' ?>>Elementary</option>
                            <option value="Highschool" <?= (isset($_SESSION['ParentEduc']) && $_SESSION['ParentEduc'] === 'Highschool') ? 'selected' : '' ?>>High School</option>
                            <option value="College" <?= (isset($_SESSION['ParentEduc']) && $_SESSION['ParentEduc'] === 'College') ? 'selected' : '' ?>>College</option>
                            <option value="Graduate" <?= (isset($_SESSION['ParentEduc']) && $_SESSION['ParentEduc'] === 'Graduate') ? 'selected' : '' ?>>Graduate School</option>
                        </select>

                        <select name="EthnoGroupPrt" required>
                            <option value="" disabled selected hidden <?= isset($_SESSION['EthnoGroupPrt']) ? 'selected' : '' ?>>Ethnic Group</option>
                            <option value="Group1" <?= (isset($_SESSION['EthnoGroupPrt']) && $_SESSION['EthnoGroupPrt'] === 'Group1') ? 'selected' : '' ?>>Group 1</option>
                            <option value="Group2" <?= (isset($_SESSION['EthnoGroupPrt']) && $_SESSION['EthnoGroupPrt'] === 'Group2') ? 'selected' : '' ?>>Group 2</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <input
                            type="text" name="Parent_Add" placeholder="Current Address" required
                                value="<?= isset($_SESSION["Parent_Add"]) ? htmlspecialchars($_SESSION["Parent_Add"]) : '' ?>"/>

                        <select name="PLifeStatus" required>
                            <option value="" disabled selected hidden <?= isset($_SESSION['PLifeStatus']) ? 'selected' : '' ?>>Life Status</option>
                            <option value="Living" <?= (isset($_SESSION['PLifeStatus']) && $_SESSION['PLifeStatus'] === 'Living') ? 'selected' : '' ?>>Living</option>
                            <option value="Deceased" <?= (isset($_SESSION['PLifeStatus']) && $_SESSION['PLifeStatus'] === 'Deceased') ? 'selected' : '' ?>>Deceased</option>
                        </select>

                        <input type="text" name="ParentPrimaryOccu" placeholder="Primary Occupation" required
                                value="<?= isset($_SESSION['ParentPrimaryOccu']) ? htmlspecialchars($_SESSION['ParentPrimaryOccu']) : '' ?>"/>
                    </div>

                    <div class="form-row">
                        <input type="text" name="ParentOfficeAdd" placeholder="Office Address"
                                value="<?= isset($_SESSION["ParentOfficeAdd"]) ? htmlspecialchars($_SESSION["ParentOfficeAdd"]) : '' ?>"/>

                        <select name="Parent_Income" required>
                            <option value="" disabled selected hidden <?= isset($_SESSION['Parent_Income']) ? 'selected' : '' ?>>Annual Income</option>
                            <option value="Below_50k" <?= (isset($_SESSION['Parent_Income']) && $_SESSION['Parent_Income'] === 'Below_50k') ? 'selected' : '' ?>>Below ₱50,000</option>
                            <option value="50k_100k" <?= (isset($_SESSION['Parent_Income']) && $_SESSION['Parent_Income'] === '50k_100k') ? 'selected' : '' ?>>₱50,000 - ₱100,000</option>
                            <option value="100k_200k" <?= (isset($_SESSION['Parent_Income']) && $_SESSION['Parent_Income'] === '100k_200k') ? 'selected' : '' ?>>₱100,000 - ₱200,000</option>
                            <option value="Above_200k" <?= (isset($_SESSION['Parent_Income']) && $_SESSION['Parent_Income'] === 'Above_200k') ? 'selected' : '' ?>>Above ₱200,000</option>
                        </select>

                        <input type="text" name="ITR_Year"placeholder="ITR Year" required
                                value="<?= isset($_SESSION["ITR_Year"]) ? htmlspecialchars($_SESSION["ITR_Year"]) : '' ?>"/>
                    </div>

                    <div class="button-group">
                        <button type="submit" name="back" formnovalidate class="back-btn">Back</button>
                        <button type="submit" name="next1" class="next-btn">Next</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
