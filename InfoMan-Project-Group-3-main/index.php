<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCIP Educational Assistance Program</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="landingpage.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-container">
            <img src="src/img_logo.png" alt="NCIP Logo" class="logo">
            <div class="logo-text">
                <p class="department">Department of Social Welfare and Development</p>
                <p class="commission">National Commission on Indigenous Peoples</p>
            </div>
        </div>
        <nav class="nav-links">
            <a href="#hero" class="nav-link">About</a>
            <a href="#eligibility" class="nav-link">Eligibility</a>
            <a href="#requirements" class="nav-link">Requirements</a>
            <a href="#process" class="nav-link">Application Process</a>
            <a href="#reminders" class="nav-link">Reminders</a>
            <a href="#register" class="nav-link">Register</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="hero-content">
            <!-- First slide -->
            <div class="hero-slide" data-slide="0">
                <div class="hero-card">
                    <h1 class="hero-title">Begin your scholar<br>journey today!</h1>
                    <p class="hero-text">The <span class="highlight">NCIP Educational Assistance Program</span> aims to: provide scholarships that will finance the education of talented and deserving college students; and ensure a steady, adequate supply of qualified civilians who can steer the country towards national progress.</p>
                </div>
                <div class="hero-illustration">
                    <img src="src/img_assets_infoman_1.png" alt="Student illustration" class="hero-image">
                </div>
            </div>
            
            <!-- Second slide -->
            <div class="hero-slide" data-slide="1" style="display: none;">
                <div class="hero-card">
                    <h1 class="hero-title">What is NCIP Educational<br>Assistance Program?</h1>
                    <p class="hero-text">The <span class="highlight">NCIP Educational Assistance Program</span> is a government initiative aimed at supporting the educational needs of Indigenous Cultural Communities/Indigenous Peoples (ICCs/IPs) in the Philippines. This program provides financial assistance to qualified indigenous students from elementary to tertiary levels.</p>
                </div>
                <div class="hero-illustration">
                    <img src="src/img_assets_infoman_1_1.png" alt="Program description" class="hero-image">
                </div>
            </div>

            <!-- Third slide -->
            <div class="hero-slide" data-slide="2" style="display: none;">
                <div class="hero-card">
                    <h1 class="hero-title">NCIP Educational<br>Assistance Program Impact</h1>
                    <p class="hero-text">Since its launch, the <span class="highlight">NCIP Educational Assistance Program</span> has supported thousands of Indigenous students across the Philippines, helping them access and complete quality education. Each year, the program provides financial assistance to an estimated 8,000 to 10,000 IP learners.</p>
                </div>
                <div class="hero-illustration">
                    <img src="src/img_assets_infoman_2_1.png" alt="Program impact" class="hero-image">
                </div>
            </div>
        </div>
        <div class="slider-controls">
            <button class="slider-arrow prev disabled">
                <svg width="72" height="77" viewBox="0 0 72 77" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M45 57.75L27 38.5L45 19.25" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="slider-dots">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
            <button class="slider-arrow next">
                <svg width="72" height="77" viewBox="0 0 72 77" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M27 19.25L45 38.5L27 57.75" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </section>

    <!-- Eligibility Section -->
    <section id="eligibility" class="eligibility-section">
        <div class="section-container">
            <h2 class="section-title">Eligibility</h2>
            <p class="section-subtitle">Who can apply?</p>
            <div class="eligibility-cards">
                <div class="eligibility-card">
                    <div class="icon-container">
                        <img src="src/img_icon.svg" alt="Student icon" class="card-icon">
                    </div>
                    <h3>Incoming College,<br>Masters, or PHD Student</h3>
                    <p>The applicant<br>must be an incoming<br>college, masters, or PHD student.</p>
                </div>
                <div class="eligibility-card">
                    <div class="icon-container">
                        <img src="src/img_icon_48x48.svg" alt="Not a scholar icon" class="card-icon">
                    </div>
                    <h3>Not a<br>Scholar Yet</h3>
                    <p>The applicant<br>must not be availing other<br>government scholarships.</p>
                </div>
                <div class="eligibility-card">
                    <div class="icon-container">
                        <img src="src/img_bookmarkfilled.svg" alt="Grades icon" class="card-icon">
                    </div>
                    <h3>General<br>Weighted<br>Average atleast 83%</h3>
                    <p>The applicant<br>must have no failing<br>grades.</p>
                </div>
                <div class="eligibility-card">
                    <div class="icon-container">
                        <img src="src/img_filipino_icon.svg" alt="Filipino citizen icon" class="card-icon">
                    </div>
                    <h3>Filipino<br>Citizen</h3>
                    <p>The applicant<br>must be a natural-born<br>Filipino citizen.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Requirements Section -->
    <section id="requirements" class="requirements-section">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Requirements</h2>
                <p class="section-subtitle">What to prepare?</p>
            </div>
            <div class="requirements-grid">
                <div class="requirement-card">
                    <div class="icon-container">
                        <img src="src/img_icon_checklist.svg" alt="Transcript icon" class="req-icon">
                    </div>
                    <h3>Transcript of Records</h3>
                    <p>Must include the First Semester of First Year until the Current Semester of Enrolled Year.</p>
                </div>
                <div class="requirement-card">
                    <div class="icon-container">
                        <img src="src/img_icon_checklist.svg" alt="Registration icon" class="req-icon">
                    </div>
                    <h3>Income Tax Return</h3>
                    <p>It must be the most recent Income Tax Return (ITR) of the parent with whom the student will be registering.</p>
                </div>
                <div class="requirement-card">
                    <div class="icon-container">
                        <img src="src/img_icon_checklist.svg" alt="Birth Certificate icon" class="req-icon">
                    </div>
                    <h3>Birth Certificate</h3>
                    <p>Must be a clear copy of the PSA-issued Birth Certificate showing full name, birth date, and place of birth.</p>
                </div>
                <div class="requirement-card">
                    <div class="icon-container">
                        <img src="src/img_icon_checklist.svg" alt="Indigency icon" class="req-icon">
                    </div>
                    <h3>Certificate of Indigency</h3>
                    <p>Must be an original or certified true copy issued by the barangay, stating that the student is a resident and classified as indigent.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Process Section -->
    <section id="process" class="process-section">
        <div class="process-container">
            <h2 class="section-title">Application Process</h2>
            <p class="section-subtitle">Step-by-Step Process</p>
            
            <div class="process-steps">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-line"></div>
                </div>
                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-line"></div>
                </div>
                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-line"></div>
                </div>
                <div class="step-item">
                    <div class="step-number">4</div>
                </div>
            </div>

            <div class="process-content">
                <div class="step-content" data-step="1">
                    <h3 class="content-title">Register Your Email</h3>
                    <p class="content-description">Sign up using a valid email address to begin your scholarship application. Use the link sent in your inbox to begin the process.</p>
                </div>
                <div class="step-content" data-step="2" style="display: none;">
                    <h3 class="content-title">Fill Out the Application Form</h3>
                    <p class="content-description">Enter all necessary details in the online form accurately.</p>
                </div>
                <div class="step-content" data-step="3" style="display: none;">
                    <h3 class="content-title">Review and Submit Your Application</h3>
                    <p class="content-description">Review all information, then click <strong>Submit</strong> to complete your application.</p>
                </div>
                <div class="step-content" data-step="4" style="display: none;">
                    <h3 class="content-title">Wait for an Email</h3>
                    <p class="content-description">Once done, we will review your application and send an email to set a date for an interview.</p>
                </div>
                <div class="step-buttons">
                    <button class="prev-button">Previous</button>
                    <button class="next-button">Next</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Reminders Section -->
    <section id="reminders" class="reminders-section">
        <div class="reminders-container">
            <h2 class="section-title reminders-title">Reminders</h2>
            <p class="section-subtitle reminders-subtitle">What to remember?</p>
            <div class="reminders-list">
                <div class="reminder-item">You can only fill out the application form once. Do not apply twice.</div>
                <div class="reminder-item">Make sure that the email and mobile number you provided are active.</div>
                <div class="reminder-item">Ensure that you are using a stable internet connection when filling out the application.</div>
                <div class="reminder-item">Beware of other websites that may contain fake and outdated information about this application.</div>
            </div>
        </div>
    </section>

    <!-- Register Section -->
    <section id="register" class="register-section">
        <h2 class="section-title">Register</h2>
        <p class="section-subtitle">Be one of our scholars now!</p>
        <div class="register-content">
            <div class="register-illustration">
                <img src="src/img_student_girl.png" alt="Student girl" class="student-girl">
                <div class="register-button-container">
                    <a href="personalinfo.php" class="apply-button">Apply now! </a>
                </div>
                <img src="src/img_student_boy.png" alt="Student boy" class="student-boy">
            </div>
        </div>
    </section>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const dots = document.querySelectorAll('.dot');
    const slides = document.querySelectorAll('.hero-slide');
    const prevArrow = document.querySelector('.slider-arrow.prev');
    const nextArrow = document.querySelector('.slider-arrow.next');
    let currentSlide = 0;

    function showSlide(index) {
        // Hide all slides and remove active classes
        slides.forEach((slide, i) => {
            slide.style.display = 'none';
            dots[i].classList.remove('active');
        });

        // Show current slide and activate dot
        slides[index].style.display = 'flex';
        dots[index].classList.add('active');

        // Update arrow states
        prevArrow.classList.toggle('disabled', index === 0);
        nextArrow.classList.toggle('disabled', index === slides.length - 1);

        currentSlide = index;
    }

    // Event listeners for dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => showSlide(index));
    });

    // Event listeners for arrows
    prevArrow.addEventListener('click', () => {
        if (!prevArrow.classList.contains('disabled')) {
            showSlide(currentSlide - 1);
        }
    });

    nextArrow.addEventListener('click', () => {
        if (!nextArrow.classList.contains('disabled')) {
            showSlide(currentSlide + 1);
        }
    });

    // Initialize first slide
    showSlide(0);
});

document.addEventListener('DOMContentLoaded', function() {
    const stepContents = document.querySelectorAll('.step-content');
    const stepNumbers = document.querySelectorAll('.step-number');
    const nextButtons = document.querySelectorAll('.next-button');
    const prevButtons = document.querySelectorAll('.prev-button');
    let currentStep = 1;

    function showStep(stepNumber) {
        // Hide all steps
        stepContents.forEach(content => {
            content.style.display = 'none';
        });

        // Show current step
        const currentContent = document.querySelector(`.step-content[data-step="${stepNumber}"]`);
        if (currentContent) {
            currentContent.style.display = 'block';
        }

        // Update step numbers
        stepNumbers.forEach((number, index) => {
            if (index + 1 <= stepNumber) {
                number.classList.add('active');
            } else {
                number.classList.remove('active');
            }
        });

        // Update buttons visibility
        prevButtons.forEach(button => {
            button.style.display = stepNumber === 1 ? 'none' : 'inline-flex';
        });

        nextButtons.forEach(button => {
            button.style.display = stepNumber === stepContents.length ? 'none' : 'inline-flex';
        });

        currentStep = stepNumber;
    }

    // Next button click handlers
    nextButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep < stepContents.length) {
                showStep(currentStep + 1);
            }
        });
    });

    // Previous button click handlers
    prevButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        });
    });

    // Initialize first step
    showStep(1);
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const section = document.querySelector(this.getAttribute('href'));
        if (section) {
            section.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});
</script>
<!-- Footer Start -->
<footer class="custom-footer">
  <div class="footer-inner">
    <div class="footer-names">
      <ul>
        <li>Baltazar, Maria Trisha</li>
        <li>Cruz, Joriz Ben</li>
        <li>de Leon, Maria Agatha Cristie</li>
        <li>Pangue, Laurence Gabriel</li>
        <li>Reandino, Clicel Jeane</li>
      </ul>
    </div>
    <div class="footer-disclaimer">
      <div class="disclaimer-title">
        <span class="disclaimer-icon">&#9432;</span>
        <span class="disclaimer-heading">Disclaimer</span>
      </div>
      <div class="disclaimer-text">
        The <b>logo/form</b> of the company used in this software have been utilized solely for <b>educational and non-commercial purposes</b> as part of an academic project. The inclusion of the logo does not imply any affiliation, endorsement, or sponsorship by the logo owner.
      </div>
    </div>
  </div>
</footer>
<!-- Footer End -->
</body>
</html>

<?php
?>