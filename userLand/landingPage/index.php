<?php
session_start();
require('./form/db.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Landing</title>
</head>

<body onload="loadContent('home')">
    <header>
        <nav>
            <a href="#" class="logo">
                <i class='bx bx-dumbbell'></i>
                <div class="logo-name"><span>Gym</span>Hero</div>
            </a>

            <ul class="nav-links">
                <li onclick="loadContent('home')"><span>Home</span></li>
                <li onclick="loadContent('plan & pricing')"><span>Plans & pricing</span></li>
                <li onclick="loadContent('aboutUs')"><span>About us</span></li>
                <li onclick="loadContent('Contact')"><span>Contact</span></li>
            </ul>
            <form action="#">
                <div class="form-input">
                    <a href="./form/login.php" class="Sign-in">Sign In</a>
                    <a href="./form/login.php#registerForm" class="register-nav">Register</a>
                </div>
            </form>
            <!-- <a href="#" class="notif">
                <i class='bx bx-bell'></i>
            </a> -->
            <!-- <a href="#" class="profile">
                <img src="images/GYMBG.jpg" alt="Profile">
            </a> -->
        </nav>
    </header>

    <main class="main-container main-content">
        <!-- Home Section -->
        <div id="home" class="content-section">
            <div class="hero-section">
                <div class="hero-content">
                    <h1 class="hero-title">TRANSFORM YOUR BODY</h1>
                    <h2 class="hero-subtitle">TRANSFORM YOUR LIFE</h2>
                    <p class="hero-text">Join GymHero and start your fitness journey today</p>
                    <div class="hero-buttons">
                        <a onclick="loadContent('plan & pricing')" class="cta-button primary">Get Started</a>
                        
                    </div>
                    
                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Happy Members</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">20+</span>
                            <span class="stat-label">Expert Trainers</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">10+</span>
                            <span class="stat-label">Fitness Programs</span>
                        </div>
                    </div>
                </div>
                
                <div class="features-banner">
                    <div class="feature-item">
                        <i class='bx bx-dumbbell'></i>
                        <span>Modern Equipment</span>
                    </div>
                    <div class="feature-item">
                        <i class='bx bx-user-check'></i>
                        <span>Expert Trainers</span>
                    </div>
                    <div class="feature-item">
                        <i class='bx bx-timer'></i>
                        <span>Flexible Hours</span>
                    </div>
                    <div class="feature-item">
                        <i class='bx bx-heart'></i>
                        <span>Wellness Support</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Membership Section -->
        <div id="plan & pricing" class="content-section" style="display: none;">
            <div class="container">
                <h2 class="plans-title">CHOOSE YOUR MEMBERSHIP PLAN</h2>
                <div class="plans">
                    <div class="plan">
                        <h2>1-MONTH</h2>
                        <div class="price">Rs. 1,500</div>
                        <div class="features">
                            <ul>
                                <li>Unlimited equipments</li> 
                                <li>No time restriction</li>
                                <li>Weight loss training</li>
                            </ul>
                        </div>
                        <a href="./form/login.php" class="enroll-button">ENROLL NOW</a>
                    </div>
                    <div class="plan">
                        <h2>6-MONTHS</h2>
                        <div class="price">Rs. 7,500</div>
                        <div class="features">
                            <ul>
                                <li>Unlimited equipments</li>
                                <li>Personal trainer</li>
                                <li>No time restriction</li>
                                <li>Weight loss training</li>
                            </ul>
                        </div>
                        <a href="./form/login.php" class="enroll-button">ENROLL NOW</a>
                    </div>
                    <div class="plan">
                        <h2>12-MONTHS</h2>
                        <div class="price">Rs. 12,000</div>
                        <div class="features">
                            <ul>
                                <li>Unlimited equipments</li>
                                <li>Personal trainer</li>
                                <li>No time restriction</li>
                                <li>Weight loss training</li>
                            </ul>
                        </div>
                        <a href="./form/login.php" class="enroll-button">ENROLL NOW</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Us Section -->
        <div id="aboutUs" class="content-section" style="display: none;">
            <div class="about-section">
                <div class="about-container">
                    <h2 class="section-title">About Us</h2>
                    <div class="about-content">
                        <!-- <div class="about-image">
                            <img src="./images/gym-interior.jpg" alt="Gym Interior">
                        </div> -->
                        <div class="about-text">
                            <h3>Welcome to GymHero</h3>
                            <p>Your premier fitness destination where strength meets transformation.</p>
                            
                            <div class="features-grid">
                                <div class="feature">
                                    <i class='bx bx-dumbbell'></i>
                                    <h4>State-of-the-Art Equipment</h4>
                                    <p>Access to premium fitness equipment and modern facilities</p>
                                </div>
                                <div class="feature">
                                    <i class='bx bx-user'></i>
                                    <h4>Expert Trainers</h4>
                                    <p>Certified professional trainers to guide your fitness journey</p>
                                </div>
                                <div class="feature">
                                    <i class='bx bx-time'></i>
                                    <h4>Flexible Hours</h4>
                                    <p>Open 24/7 to fit your schedule</p>
                                </div>
                                <div class="feature">
                                    <i class='bx bx-group'></i>
                                    <h4>Community Focus</h4>
                                    <p>Join a motivated community of fitness enthusiasts</p>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>

        <!-- contact Section -->
        <div id="Contact" class="content-section" style="display: none;">
            <div class="contact-container">
                <h2 class="section-title">Contact Us</h2>
                <div class="contact-content">
                    <div class="contact-info">
                        <div class="info-item">
                            <i class='bx bx-map'></i>
                            <h3>Location</h3>
                            <p>Satdobato, Lalitpur</p>
                            <p>Near swimming pool</p>
                        </div>
                        <div class="info-item">
                            <i class='bx bx-phone'></i>
                            <h3>Phone</h3>
                            <p>+9840312322</p>
                            <p>+9840322322</p>
                        </div>
                        <div class="info-item">
                            <i class='bx bx-envelope'></i>
                            <h3>Email</h3>
                            <p>gymhero@gmail.com</p>
                            <p>supportgymhero@hotmail.com</p>
                        </div>
                        <div class="info-item">
                            <i class='bx bx-time'></i>
                            <h3>Working Hours</h3>
                            <p>Monday - Friday: 5:00 AM - 08:00 PM</p>
                            <p>Saturday - Sunday: 6:00 AM - 07:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="contact-form">
                        <h3>Send us a Message</h3>
                        <form>
                            <div class="form-group">
                                <input type="text" placeholder="Your Name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" placeholder="Your Email" required>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Subject" required>
                            </div>
                            <div class="form-group">
                                <textarea placeholder="Your Message" required></textarea>
                            </div>
                            <button type="submit" class="submit-btn">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="index.js"></script>
</body>

</html>
