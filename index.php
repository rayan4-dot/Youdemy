<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once '../Youdemy/app/config/Database.php'; 
use App\Config\Database;

try {
    $conn = new Database(); 
    $db = $conn->getConnection();


    $sql_courses = "SELECT courses.*, categories.name AS category_name
                    FROM courses
                    INNER JOIN categories ON courses.category_id = categories.category_id
                    WHERE courses.status = 'active'";
    $stmt = $db->prepare($sql_courses);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching courses: " . $e->getMessage();
    die();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>Youdemy HTML5 Template</title>
    
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-grad-school.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
<style>
    /* General carousel item styles */
/* General carousel item styles */
.item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    text-align: center;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin: 10px;
    overflow: hidden;
    width: 100%; /* Ensure it fits properly */
    max-width: 320px; /* Set a max width for consistency */
}

.course-media {
    width: 100%;
    height: 250px; /* Set a height for the video */
    margin-bottom: 15px; /* Add some spacing between the video and content */
    border-radius: 8px;
    overflow: hidden; /* To keep the video within bounds */
}

.course-video {
    width: 100%;
    height: 100%;
    border: none;
    border-radius: 8px; /* Rounded corners for the video */
}

.down-content {
    padding: 20px; /* Consistent padding */
    background-color: #fff;
    border-radius: 8px; /* Smooth rounded corners */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Slight shadow for the content box */
    color: #333; /* Ensure text is dark enough to be readable */
}

.down-content h4 {
    font-size: 1.25rem; /* Larger title */
    font-weight: bold;
    color: #007bff; /* Blue color for the title */
    margin-bottom: 10px; /* Space between title and description */
}

.down-content p {
    font-size: 1rem;
    color: #666; /* Light gray color for descriptions */
    margin-bottom: 10px; /* Space after the paragraph */
}

.text-button-pay a {
    display: inline-block;
    padding: 10px 15px;
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.text-button-pay a:hover {
    background-color: #0056b3;
}

</style>
</head>

<body>

    <!--header-->
    <header class="main-header clearfix" role="header">
        <div class="logo">
            <a href="#"><em>Youdemy</em></a>
        </div>
        <a href="#menu" class="menu-link"><i class="fa fa-bars"></i></a>
        <nav id="menu" class="main-nav" role="navigation">
            <ul class="main-menu">
                <li><a href="#section1">Home</a></li>
                <li class="has-submenu">
                    <a href="#section2">Courses</a>
                    <ul class="sub-menu">
                        <li><a href="#section3">Categories</a></li>
                    </ul>
                </li>
                <li><a href="#section7">Teachers</a></li> <!-- Teachers link -->
                <li><a href="#section6">Contact</a></li> <!-- Contact link -->
                <li><a href="../Youdemy/app/Authentication/login.php">Login</a></li>
            </ul>
        </nav>

    </header>

    <!-- ***** Main Banner Area Start ***** -->
    <section class="section main-banner" id="top" data-section="section1">
        <video autoplay muted loop id="bg-video">
            <source src="assets/images/course-video.mp4" type="video/mp4" />
        </video>

        <div class="video-overlay header-text">
            <div class="caption">
                <h6>Welcome to Youdemy</h6>
                <h2><em>Your</em> Learning Platform</h2>
                <div class="main-button">
                    <div class="scroll-to-section"><a href="#section2">Discover Courses</a></div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Main Banner Area End ***** -->

    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="features-post">
                        <div class="features-content">
                            <div class="content-show">
                                <h4><i class="fa fa-pencil"></i>All Courses</h4>
                            </div>
                            <div class="content-hide">
                                <p>Explore a variety of courses designed to help you expand your knowledge and skills.</p>
                                <div class="scroll-to-section"><a href="#section3">More Info.</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="features-post second-features">
                        <div class="features-content">
                            <div class="content-show">
                                <h4><i class="fa fa-graduation-cap"></i>Virtual Classes</h4>
                            </div>
                            <div class="content-hide">
                                <p>Learn from top instructors through live and recorded sessions.</p>
                                <div class="scroll-to-section"><a href="#section4">Details</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="features-post third-features">
                        <div class="features-content">
                            <div class="content-show">
                                <h4><i class="fa fa-book"></i>Community Access</h4>
                            </div>
                            <div class="content-hide">
                                <p>Join a vibrant community of learners and share your learning journey.</p>
                                <div class="scroll-to-section"><a href="#section5">Join Now</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section why-us" data-section="section2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Why Choose Youdemy?</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id='tabs'>
                        <ul>
                            <li><a href='#tabs-1'>Diverse Courses</a></li>
                            <li><a href='#tabs-2'>Expert Instructors</a></li>
                            <li><a href='#tabs-3'>Engaging Content</a></li>
                        </ul>
                        <section class='tabs-content'>
                            <article id='tabs-1'>
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="assets/images/choose-us-image-01.png" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Diverse Courses</h4>
                                        <p>Youdemy offers a plethora of courses across various fields, catering to all learning needs.</p>
                                    </div>
                                </div>
                            </article>
                            <article id='tabs-2'>
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="assets/images/choose-us-image-02.png" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Expert Instructors</h4>
                                        <p>Learn from knowledgeable instructors with real-world experience.</p>
                                    </div>
                                </div>
                            </article>
                            <article id='tabs-3'>
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="assets/images/choose-us-image-03.png" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Engaging Content</h4>
                                        <p>Our courses are designed to be interactive and engaging for an effective learning experience.</p>
                                    </div>
                                </div>
                            </article>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

 <!-- ***** Courses Section ***** -->
 <section class="section courses" data-section="section3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h2>Choose Your Course</h2>
                </div>
            </div>
            <div class="owl-carousel owl-theme">
                <?php foreach ($courses as $course): ?>
           <div class="item">
    <div class="course-media">
        <?php if (!empty($course['image_path'])): ?>
            <!-- Render course image -->
            <img class="course-image" src="../app/uploads/<?= htmlspecialchars($course['image_path']) ?>" alt="<?= htmlspecialchars($course['title']) ?>">
        <?php elseif (!empty($course['video_url'])): ?>
            <!-- Render course video -->
            <iframe class="course-video" src="<?= htmlspecialchars($course['video_url']) ?>" frameborder="0" allowfullscreen></iframe>
        <?php else: ?>
            <!-- Fallback: Default image -->
            <img class="course-image" src="assets/images/default-course.jpg" alt="Default Course">
        <?php endif; ?>
    </div>
    <div class="down-content">
        <h4><?= htmlspecialchars($course['title']) ?></h4>
        <p><?= htmlspecialchars($course['description']) ?></p>
        <p><strong>Category:</strong> <?= htmlspecialchars($course['category_name']) ?></p>
        <div class="text-button-pay">
            <a href="../Youdemy/app/Authentication/login.php">Enroll Now <i class="fa fa-angle-double-right"></i></a>
        </div>
    </div>
</div>


                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


<!-- ***** Teacher Section ***** -->
<section class="teacher_section layout_padding-bottom">
    <div class="container">
        <h2 class="main-heading text-center mb-4">
            Our Teachers
        </h2>
        <p class="text-center mb-5">
            Meet our highly skilled and experienced instructors who are dedicated to providing the best learning experience.
        </p>
        <div class="teacher_container layout_padding2">
            <div class="row justify-content-center">
                <!-- Teacher Card 1 -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card border-0">
                        <img class="card-img-top rounded-circle" src="kudo.webp" alt="Den Mark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Den Mark</h5>
                        </div>
                    </div>
                </div>
                <!-- Teacher Card 2 -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card border-0">
                        <img class="card-img-top rounded-circle" src="kudo.webp" alt="Leena Jorj">
                        <div class="card-body text-center">
                            <h5 class="card-title">Leena Jorj</h5>
                        </div>
                    </div>
                </div>
                <!-- Teacher Card 3 -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card border-0">
                        <img class="card-img-top rounded-circle" src="kudo.webp" alt="Magi Den">
                        <div class="card-body text-center">
                            <h5 class="card-title">Magi Den</h5>
                        </div>
                    </div>
                </div>
                <!-- Teacher Card 4 -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card border-0">
                        <img class="card-img-top rounded-circle" src="kudo.webp" alt="Jonson Mark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Jonson Mark</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <a href="#" class="call_to-btn">
                <span>See More</span>
                <img src="images/right-arrow.png" alt="">
            </a>
        </div>
    </div>
    <style>
        .teacher_section .card {
            background-color: transparent;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .teacher_section .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .teacher_section .card-img-top {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin: 0 auto;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        .teacher_section .card-img-top:hover {
            transform: scale(1.05);
        }

        .teacher_section .card-title {
            color: #48494a;
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .teacher_section .call_to-btn {
            font-size: 16px;
            color: #fec913;
            font-weight: bold;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .teacher_section .call_to-btn img {
            margin-left: 10px;
        }

        .teacher_section .call_to-btn:hover {
            color: #d79e1f;
        }

        .teacher_section {
            margin-top: 50px; /* Added space above the Teacher Section */
        }


        
    </style>
</section>
<!-- ***** End of Teacher Section ***** -->

<!-- ***** Feedback Section ***** -->
<section class="client_section layout_padding">
    <div class="container">
        <h2 class="main-heading text-center">
            Our Students Feedback
        </h2>
        <p class="text-center mb-5">
            Hear directly from our students about their learning experiences at Youdemy.
        </p>
        <div class="layout_padding2">
            <div class="client_container d-flex flex-column align-items-center">
                <div class="client_detail d-flex align-items-center mb-4">
                    <div class="client_img-box">
                        <img src="kudo.webp" alt="Veniam Quis">
                    </div>
                    <div class="client_detail-box">
                        <h4>Veniam Quis</h4>
                        <span>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .client_section .client_detail {
            background-color: #f7f7f7;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .client_section .client_img-box {
            margin-right: 20px;
        }

        .client_section .client_img-box img {
            border-radius: 50%;
            width: 60px;
            height: 60px;
            object-fit: cover;
        }

        .client_section .client_detail-box {
            display: flex;
            flex-direction: column;
        }

        .client_section .client_detail-box h4 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .client_section .client_detail span {
            font-size: 14px;
            color: #888;
        }
    </style>
</section>

<!-- ***** End of Feedback Section ***** -->

<!-- ***** Contact Section ***** -->
<section class="contact_section layout_padding-bottom">
    <div class="container">
        <h2 class="main-heading text-center">
            Contact Us Now
        </h2>
        <p class="text-center mb-5">
            Have any questions? Get in touch with us and we'll respond as soon as possible.
        </p>
        <div class="contact_section-container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="contact-form">
                        <form action="">
                            <div>
                                <input type="text" placeholder="Name" required>
                            </div>
                            <div>
                                <input type="text" placeholder="Phone Number" required>
                            </div>
                            <div>
                                <input type="email" placeholder="Email" required>
                            </div>
                            <div>
                                <input type="text" placeholder="Message" class="input_message" required>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn_on-hover">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .contact_section {
            background-image: url(../images/shape-2.png);
            background-repeat: no-repeat;
            background-size: 14%;
            background-position: left center;
            padding: 60px 0;
        }

        .contact-form {
            padding: 30px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-form input {
            border: none;
            outline: none;
            background-color: #f3f3f3;
            width: 100%;
            margin: 15px 0;
            padding: 10px;
            border-radius: 8px;
            font-size: 16px;
        }

        .contact-form .input_message {
            height: 120px;
        }

        .contact-form button {
            border: none;
            outline: none;
            padding: 10px 40px;
            text-transform: uppercase;
            margin-top: 20px;
            background-color: #fec913;
            color: #fff;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .contact-form button:hover {
            background-color: #e1b60a;
        }
    </style>
</section>
<!-- ***** End of Contact Section ***** -->





    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p><i class="fa fa-copyright"></i> Copyright 2025 by Youdemy  
                    | Design: <a href="#" target="_parent">Youdemy</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/tabs.js"></script>
    <script src="assets/js/video.js"></script>
    <script src="assets/js/slick-slider.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        //according to loftblog tut
        $('.nav li:first').addClass('active');

        var showSection = function showSection(section, isAnimate) {
          var
          direction = section.replace(/#/, ''),
          reqSection = $('.section').filter('[data-section="' + direction + '"]'),
          reqSectionPos = reqSection.offset().top - 0;

          if (isAnimate) {
            $('body, html').animate({
              scrollTop: reqSectionPos },
            800);
          } else {
            $('body, html').scrollTop(reqSectionPos);
          }
        };

        var checkSection = function checkSection() {
          $('.section').each(function () {
            var
            $this = $(this),
            topEdge = $this.offset().top - 80,
            bottomEdge = topEdge + $this.height(),
            wScroll = $(window).scrollTop();
            if (topEdge < wScroll && bottomEdge > wScroll) {
              var
              currentId = $this.data('section'),
              reqLink = $('a').filter('[href*=\\#' + currentId + ']');
              reqLink.closest('li').addClass('active').
              siblings().removeClass('active');
            }
          });
        };

        $('.main-menu, .scroll-to-section').on('click', 'a', function (e) {
          if($(e.target).hasClass('external')) {
            return;
          }
          e.preventDefault();
          $('#menu').removeClass('active');
          showSection($(this).attr('href'), true);
        });

        $(window).scroll(function () {
          checkSection();
        });
    </script>
</body>
</html>