<?php
include_once('../header.php');

date_default_timezone_set('Asia/Manila');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "All fields are required. Please fill in all the information.";
    } 

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    }
    else {
        try {
            $sql = "INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([$name, $email, $subject, $message])) {
                $email_subject = "New Contact Form Submission: " . htmlspecialchars($subject);
                
                // create ng formatted message body
                $email_message = "
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'><strong>Sender Name:</strong></td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'>" . htmlspecialchars($name) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'><strong>Email Address:</strong></td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'>" . htmlspecialchars($email) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'><strong>Subject:</strong></td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'>" . htmlspecialchars($subject) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'><strong>Message:</strong></td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; white-space: pre-wrap;'>" . htmlspecialchars($message) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px;'><strong>Submitted:</strong></td>
                            <td style='padding: 10px;'>" . date('F j, Y g:i A') . "</td>
                        </tr>
                    </table>";
                
                if(sendMail('dyterljfederiz@gmail.com', $email_subject, $email_message, $email, $name)) {
                    $success = "Message sent successfully! We'll get back to you soon.";
                } else {
                    $success = "Message saved successfully! We'll get back to you soon.";
                }
            } else {
                $error = "Sorry, there was an error sending your message.";
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $error = "Sorry, there was an error sending your message.";
        }
    }
}
?>
<body data-bs-spy="scroll" data-bs-target="#navScroll">
    
    <main>
        <div class="w-100 overflow-hidden position-relative bg-light" id="top" style="padding-top: 120px;">
            <div class="container py-5">
                <div class="contact-container">
                    <div class="contact-header">
                        <h2 class="mb-2">Contact Us</h2>
                        <p class="text-muted">Got any question? Feel free to message us and we will get in touch with you right away.</p>
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                <?php echo htmlspecialchars($success); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <form class="contact-form" id="contactForm" method="post">
                        <div class="row g-4">
                            <div class="col-12">
                                <input type="text" class="form-control" name="name" placeholder="Name" required style="background: #fff;">
                            </div>
                            <div class="col-12">
                                <input type="email" class="form-control" name="email" placeholder="Email@email.com" required style="background: #fff;">
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject" required style="background: #fff;">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" name="message" placeholder="Message" rows="4" required style="background: #fff;"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-send w-50" style="background-color:rgb(211, 175, 75);">
                                    Send
                                    <div class="loading-dots">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="contact-info">
                        <div class="contact-info-item">
                            <img src="../favicon/footer/fb2.svg" alt="Phone">
                            <a href="https://www.facebook.com/skye.blinds.9">Skye Window Blinds</a>
                        </div>
                        <div class="contact-info-item">
                            <img src="../favicon/footer/viber-svgrepo-com.svg" alt="Phone">
                            <a href="viber://chat?number=09488736946">09488736946</a>
                        </div>
                        <div class="contact-info-item">
                            <img src="../favicon/footer/gmail-svgrepo-com.svg" alt="Email">
                            <a href="mailto:dyterljfederiz@gmail.com">dyterljfederiz@gmail.com</a>
                        </div>
                        <div class="contact-info-item">
                            <img src="../favicon/footer/gmaps.svg" alt="Location">
                            <span>Santol extension, North Signal Village, Taguig City</span>
                        </div>
                    </div>

                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps?q=14.5191288,121.0598736&output=embed"
                            width="100%"
                            height="300"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Our Location">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chatbot Integration -->
        
    </main>

    <!-- JavaScript Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/some.js"></script>
    <script src="../js/aos.js"></script>
    <script>
        AOS.init({
            duration: 800
        });
    </script>
    <script>
        // AoS
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in-up');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, {
                threshold: 0.1
            });

            fadeElements.forEach(element => {
                observer.observe(element);
            });

            const form = document.getElementById('contactForm');
            const submitBtn = form.querySelector('button[type="submit"]');
            const loadingDots = submitBtn.querySelector('.loading-dots');

            form.addEventListener('submit', function(e) {
                loadingDots.classList.add('active');
                submitBtn.disabled = true;
            });
        });

        let scrollpos = window.scrollY;
        const header = document.querySelector(".navbar");
        const header_height = header.offsetHeight;

        const add_class_on_scroll = () => header.classList.add("scrolled", "shadow-sm");
        const remove_class_on_scroll = () => header.classList.remove("scrolled", "shadow-sm");

        window.addEventListener('scroll', function() {
            scrollpos = window.scrollY;
            if (scrollpos >= header_height) { add_class_on_scroll(); }
            else { remove_class_on_scroll(); }
        });
    </script>

</body>
</html>