<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "polo0210";
$dbname = "maindb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit_application'])) {
    $sql = "INSERT INTO appli_profile (
        FirstName, MidName, LastName, Suffix, BirthDate, BirthPlace, Sex, EthnoGroupStudent, EmailAdd, ContactNo, LRN, CivilStat,
        Perma_Stud_Add, Current_Stud_Add, ParentName, ParentEduc, EthnoGroupPrt, Parent_Add, PLifeStatus, ParentPrimaryOccu,
        ParentOfficeAdd, Parent_Income, ITR_Year
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssssssssssssssss",
        $_SESSION["FirstName"],
        $_SESSION["MidName"],
        $_SESSION["LastName"],
        $_SESSION["Suffix"],
        $_SESSION["BirthDate"],
        $_SESSION["BirthPlace"],
        $_SESSION["Sex"],
        $_SESSION["EthnoGroupStudent"],
        $_SESSION["EmailAdd"],
        $_SESSION["ContactNo"],
        $_SESSION["LRN"],
        $_SESSION["CivilStat"],
        $_SESSION["Perma_Stud_Add"],
        $_SESSION["Current_Stud_Add"],
        $_SESSION["ParentName"],
        $_SESSION["ParentEduc"],
        $_SESSION["EthnoGroupPrt"],
        $_SESSION["Parent_Add"],
        $_SESSION["PLifeStatus"],
        $_SESSION["ParentPrimaryOccu"],
        $_SESSION["ParentOfficeAdd"],
        $_SESSION["Parent_Income"],
        $_SESSION["ITR_Year"]
    );

    if ($stmt->execute()) {
        echo "Data saved successfully!";
        session_destroy();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Show the form if the user has not submitted yet
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Submit Application</title>
    </head>
    <body>
        <h2>Review your information and submit</h2>
        <!-- You can show the session data here as a review -->

        <form action="educbackground.php" method="POST">
            <button type="submit" name="submit_application">Submit Application</button>
        </form>
    </body>
    </html>

    <?php
}
?>
