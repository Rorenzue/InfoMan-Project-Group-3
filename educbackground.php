<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scholarship";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$elemchoice = $conn->query("SELECT school_code, school_name 
                            FROM schooldetails 
                            WHERE schoollevel LIKE 'ELEM%' OR schoollevel = 'TERTIARY'
                            ORDER BY school_name ASC");

$jhschoice = $conn->query("SELECT school_code, school_name 
                            FROM schooldetails 
                            WHERE schoollevel LIKE '%HS%' OR schoollevel = 'TERTIARY'
                            ORDER BY school_name ASC");

$shschoice = $conn->query("SELECT school_code, school_name 
                            FROM schooldetails 
                            WHERE schoollevel LIKE '%HS%' OR schoollevel = 'TERTIARY'
                            ORDER BY school_name ASC");

$undergradchoice = $conn->query("SELECT school_code, school_name 
                            FROM schooldetails 
                            WHERE schoollevel = 'TERTIARY'
                            ORDER BY school_name ASC");

$masterschoice = $conn->query("SELECT school_code, school_name 
                            FROM schooldetails 
                            WHERE schoollevel = 'TERTIARY'
                            ORDER BY school_name ASC");
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
        <a href="index.html">
            <img src="assets/images/img_logo.png" alt="NCIP Logo" class="logo">
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
                <p class="required-text">Fields marked with a red asterisk (<span class="required">*</span>) are required.</p>
                <form method="POST" action="degree.php">
                    <div class="form-row">
                        <div class="form-group full-width">
                            <select id="assistanceType" name="Assistance_Applied" required>
                                <option value="" disabled selected>Assistance Applied</option>
                                <option value="college">College</option>
                                <option value="masters">Master's</option>
                                <option value="phd">PhD/Doctorate</option>
                            </select>
                            <span class="required">*</span>
                        </div>
                    </div>

                    <!-- Elementary School -->
                    <div class="form-row">
                        <div class="form-group">
                            <select required>
                                <option value="" disabled selected>Elementary School</option>
                                <?php while ($row = $elemchoice->fetch_assoc()): ?>
                                    <option value="<?= (htmlspecialchars($row['school_name'])) ?>">
                                        <?= htmlspecialchars($row['school_name']) ?>
                                    </option>
                                <?php endwhile; ?>

                        </div>
                        <div class="form-group">
                            <input type="number" min="1900" max="2099" placeholder="Year Graduated" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <input type="number" min="75" max="100" step="0.01" placeholder="Average Grade" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <select required>
                                <option value="" disabled selected>Rank</option>
                                <option value="highest">With Highest Honors</option>
                                <option value="high">With High Honors</option>
                                <option value="honors">With Honors</option>
                                <option value="na">N/A</option>
                            </select>
                            <span class="required">*</span>
                        </div>
                    </div>

                    <!-- Junior High School -->
                    <div class="form-row">
                        <div class="form-group">
                            <select required>
                                <option value="" disabled selected>Junior High School</option>
                                <?php while ($row = $jhschoice->fetch_assoc()): ?>
                                    <option value="<?= (htmlspecialchars($row['school_name'])) ?>">
                                        <?= htmlspecialchars($row['school_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                        </div>
                        <div class="form-group">
                            <input type="number" min="1900" max="2099" placeholder="Year Graduated" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <input type="number" min="75" max="100" step="0.01" placeholder="Average Grade" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <select required>
                                <option value="" disabled selected>Rank</option>
                                <option value="highest">With Highest Honors</option>
                                <option value="high">With High Honors</option>
                                <option value="honors">With Honors</option>
                                <option value="na">N/A</option>
                            </select>
                            <span class="required">*</span>
                        </div>
                    </div>

                    <!-- Senior High School -->
                    <div class="form-row">
                        <div class="form-group">
                            <select required>
                                <option value="" disabled selected>Senior High School</option>
                                <?php while ($row = $shschoice->fetch_assoc()): ?>
                                    <option value="<?= (htmlspecialchars($row['school_name'])) ?>">
                                        <?= htmlspecialchars($row['school_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                        </div>    
                        <div class="form-group">
                            <input type="number" min="1900" max="2099" placeholder="Year Graduated" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <input type="number" min="75" max="100" step="0.01" placeholder="Average Grade" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <select required>
                                <option value="" disabled selected>Rank</option>
                                <option value="highest">With Highest Honors</option>
                                <option value="high">With High Honors</option>
                                <option value="honors">With Honors</option>
                                <option value="na">N/A</option>
                            </select>
                            <span class="required">*</span>
                        </div>
                    </div>

                    <!-- College (Undergraduate) -->
                    <div class="form-row">
                        <div class="form-group">
                            <select required>
                                <option value="" disabled selected>Undergraduate</option>
                                <?php while ($row = $undergradchoice->fetch_assoc()): ?>
                                    <option value="<?= (htmlspecialchars($row['school_name'])) ?>">
                                        <?= htmlspecialchars($row['school_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                        </div>
                        <div class="form-group">
                            <input type="number" min="1900" max="2099" placeholder="Year Graduated" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <input type="number" min="75" max="100" step="0.01" placeholder="Average Grade" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <select required>
                                <option value="" disabled selected>Rank</option>
                                <option value="highest">With Highest Honors</option>
                                <option value="high">With High Honors</option>
                                <option value="honors">With Honors</option>
                                <option value="na">N/A</option>
                            </select>
                            <span class="required">*</span>
                        </div>
                    </div>

                    <!-- Master's Degree -->
                    <div class="form-row">
                        <div class="form-group">
                            <select required>
                                <option value="" disabled selected>Master's Degree</option>
                                <?php while ($row = $masterschoice->fetch_assoc()): ?>
                                    <option value="<?= (htmlspecialchars($row['school_name'])) ?>">
                                        <?= htmlspecialchars($row['school_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                        </div>
                        <div class="form-group">
                            <input type="number" min="1900" max="2099" placeholder="Year Graduated" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <input type="number" min="75" max="100" step="0.01" placeholder="Average Grade" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <select required>
                                <option value="" disabled selected>Rank</option>
                                <option value="highest">With Highest Honors</option>
                                <option value="high">With High Honors</option>
                                <option value="honors">With Honors</option>
                                <option value="na">N/A</option>
                            </select>
                            <span class="required">*</span>
                        </div>
                    </div>

                    <!-- PhD/Doctorate -->
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" placeholder="PhD/Doctorate" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <input type="number" min="1900" max="2099" placeholder="Year Graduated" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <input type="number" min="75" max="100" step="0.01" placeholder="Average Grade" required>
                            <span class="required">*</span>
                        </div>
                        <div class="form-group">
                            <select required>
                                <option value="" disabled selected>Rank</option>
                                <option value="highest">With Highest Honors</option>
                                <option value="high">With High Honors</option>
                                <option value="honors">With Honors</option>
                                <option value="na">N/A</option>
                            </select>
                            <span class="required">*</span>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="button" class="back-btn" onclick="window.location.href='parentdesign.html'">Back</button>
                        <button type="button" class="next-btn" onclick="window.location.href='degreedesign.html'">Next</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html> 