<?php
session_start();
if (isset($_POST["next"])) {
    $_SESSION["FirstName"] = $_POST["FirstName"];
    $_SESSION["MidName"] = $_POST["MidName"];
    $_SESSION["LastName"] = $_POST["LastName"];
    $_SESSION["Suffix"] = $_POST["Suffix"];
    $_SESSION["BirthDate"] = $_POST["BirthDate"];
    $_SESSION["BirthPlace"] = $_POST["BirthPlace"];
    $_SESSION["Sex"] = $_POST["Sex"];
    $_SESSION["EthnoGroupStudent"] = $_POST["EthnoGroupStudent"];
    $_SESSION["EmailAdd"] = $_POST["EmailAdd"];
    $_SESSION["ContactNo"] = $_POST["ContactNo"];
    $_SESSION["LRN"] = $_POST["LRN"];
    $_SESSION["CivilStat"] = $_POST["CivilStat"];
    $_SESSION["Perma_Stud_Add"] = $_POST["Perma_Stud_Add"]; 
    $_SESSION["Current_Stud_Add"] = $_POST["Current_Stud_Add"]; 

    header("Location: parentinfo.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NCIP Educational Assistance - Personal Information</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="personaldesign.css">
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img src="src/img_logo.png" alt="NCIP Logo" class="logo">
        </a></a>
        <div class="header-text">
            <div class="registration-process">Registration Process</div>
            <div class="main-title">NCIP Educational Assistance</div>
        </div>
    </header>

    <div class="main-container">
        <nav class="sidebar">
            <ul>
                <li class="active">
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
                <li>
                    <span class="icon">🔍</span>
                    <span>View and<br>Submit</span>
                </li>
            </ul>
        </nav>

        <main class="content">
            <div class="stepper">
                <div class="step active">1</div>
                <div class="step-line"></div>
                <div class="step">2</div>
                <div class="step-line"></div>
                <div class="step">3</div>
                <div class="step-line"></div>
                <div class="step">4</div>
                <div class="step-line"></div>
                <div class="step">5</div>
                <span class="step-label">Personal Information</span>
            </div>

            <div class="form-card">
            <form method="POST" action="personalinfo.php">
                <div class="form-row">
                    <input type="text" name="FirstName" placeholder="First Name" required
                        value="<?= isset($_SESSION['FirstName']) ? htmlspecialchars($_SESSION['FirstName']) : '' ?>">
                    <input type="text" name="MidName" placeholder="Middle Name" required
                        value="<?= isset($_SESSION['MidName']) ? htmlspecialchars($_SESSION['MidName']) : '' ?>">
                    <input type="text" name="LastName" placeholder="Last Name" required
                        value="<?= isset($_SESSION['LastName']) ? htmlspecialchars($_SESSION['LastName']) : '' ?>">
                    <input type="text" name="Suffix" placeholder="Suffix (e.g.: III, Jr.)" class="suffix-input"
                        value="<?= isset($_SESSION['Suffix']) ? htmlspecialchars($_SESSION['Suffix']) : '' ?>">
                </div>
                <div class="form-row">
                    <input type="date" name="BirthDate" placeholder="Birth Date" required
                        value="<?= isset($_SESSION['BirthDate']) ? htmlspecialchars($_SESSION['BirthDate']) : '' ?>">
                    <input type="text" name="BirthPlace" placeholder="Birth Place" required
                        value="<?= isset($_SESSION['BirthPlace']) ? htmlspecialchars($_SESSION['BirthPlace']) : '' ?>">
                    <select name="Sex" required>
                        <option value="" selected disabled hidden >Sex</option>
                        <option value="male" <?= (isset($_SESSION['Sex']) && $_SESSION['Sex'] === 'male') ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= (isset($_SESSION['Sex']) && $_SESSION['Sex'] === 'female') ? 'selected' : '' ?>>Female</option>
                    </select>
                    <select name="EthnoGroupStudent" required>
                        <option value="" selected disabled hidden >Ethnic Group</option>
                        <option value="group1" <?= (isset($_SESSION['EthnoGroupStudent']) && $_SESSION['EthnoGroupStudent'] === 'group1') ? 'selected' : '' ?>>Group 1</option>
                        <option value="group2" <?= (isset($_SESSION['EthnoGroupStudent']) && $_SESSION['EthnoGroupStudent'] === 'group2') ? 'selected' : '' ?>>Group 2</option>
                    </select>
                </div>
                <div class="form-row">
                    <input type="email" name="EmailAdd" placeholder="E-mail Address" required
                        value="<?= isset($_SESSION['EmailAdd']) ? htmlspecialchars($_SESSION['EmailAdd']) : '' ?>">
                    <input type="text" name="ContactNo" placeholder="Contact Number" required
                        value="<?= isset($_SESSION['ContactNo']) ? htmlspecialchars($_SESSION['ContactNo']) : '' ?>">
                    <input type="text" name="LRN" placeholder="DepEd LRN Number" required
                        value="<?= isset($_SESSION['LRN']) ? htmlspecialchars($_SESSION['LRN']) : '' ?>">
                    <select name="CivilStat" required>
                        <option value="" selected disabled hidden >Civil Status</option>
                        <option value="single" <?= (isset($_SESSION['CivilStat']) && $_SESSION['CivilStat'] === 'single') ? 'selected' : '' ?>>Single</option>
                        <option value="married" <?= (isset($_SESSION['CivilStat']) && $_SESSION['CivilStat'] === 'married') ? 'selected' : '' ?>>Married</option>
                        <option value="widowed" <?= (isset($_SESSION['CivilStat']) && $_SESSION['CivilStat'] === 'widowed') ? 'selected' : '' ?>>Widowed</option>
                        <option value="separated" <?= (isset($_SESSION['CivilStat']) && $_SESSION['CivilStat'] === 'separated') ? 'selected' : '' ?>>Separated</option>
                    </select>
                </div>
                <div class="form-row">
                    <input type="text" name="Perma_Stud_Add" placeholder="Permanent Student Address" required
                        value="<?= isset($_SESSION['Perma_Stud_Add']) ? htmlspecialchars($_SESSION['Perma_Stud_Add']) : '' ?>">
                    <input type="text" name="Current_Stud_Add" placeholder="Current Student Address" required
                        value="<?= isset($_SESSION['Current_Stud_Add']) ? htmlspecialchars($_SESSION['Current_Stud_Add']) : '' ?>">
                </div>
                <button type="submit" name="next" class="next-btn">Next</button>
            </form>
        </div>
    </main>
</body>
</html>