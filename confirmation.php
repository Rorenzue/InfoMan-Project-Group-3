<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Confirmation - NCIP Educational Assistance Program</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="landingpage.css">
    <style>
        .confirmation-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: #FFCD5F; /* Updated to match hero section background */
        }

        .outer-container {
            display: flex;
            align-items: center;
            gap: 48px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .confirmation-content {
            flex: 1;
            background-color: #FFFFFF;
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-family: 'Lexend', sans-serif;
            font-size: 48px;
            font-weight: 600;
            color: #1B1C1E;
            margin-bottom: 24px;
            line-height: 1.2;
        }

        .section-subtitle {
            font-family: 'Inter', sans-serif;
            font-size: 20px;
            color: #4F4F4F;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .confirmation-text {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            color: #6B7280;
            line-height: 1.5;
            margin-bottom: 32px;
        }

        .back-button {
            display: inline-block;
            padding: 16px 32px;
            background-color: #FF6B00;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-family: 'Lexend', sans-serif;
            font-weight: 500;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #E65A00;
        }

        .illustration-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .confirmation-illustration {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .outer-container {
                flex-direction: column;
            }
            
            .illustration-wrapper {
                order: -1;
            }
        }
    </style>
</head>
<body>
    <section class="confirmation-section">
        <div class="outer-container">
            <div class="confirmation-content">
                <div class="content-wrapper">
                    <h2 class="section-title">Application Submitted Successfully!</h2>
                    <p class="section-subtitle">Thank you for applying to the NCIP Educational Assistance Program. We have received your application, and you will receive an email soon to schedule an interview.</p>
                    <p class="confirmation-text">Please check your email (including the spam/junk folder) for further instructions. If you have any questions, feel free to contact us.</p>
                    <a href="index.php" class="back-button">Back to Home</a>
                </div>
            </div>
            <div class="illustration-wrapper">
                <img src="src/img_book.png" alt="Book illustration" class="confirmation-illustration">
            </div>
        </div>
    </section>
</body>
</html>