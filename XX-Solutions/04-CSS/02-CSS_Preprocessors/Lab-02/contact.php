<?php require 'core/processContactForm.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>About Jason Snider</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="css/dist/main.css">
  </head>

  <body>

      <div id="Wrapper">

          <nav class="top-nav">
              <a href="index.html" class="pull-left" href="/">Site Logo</a>
              <ul class="nav-inline pull-right" role="navigation">
                  <li><a href="index.html">Home</a></li>
                  <li><a href="resume.html">Resume</a></li>
                  <li><a href="contact.php">Contact</a></li>
              </ul>
          </nav>

          <div class="row">
              <div id="Content" class="col">
                  <h1>Contact YOUR-NAME</h1>

                  <?php echo $message; ?>

                  <form method="post" action="contact.php">

                    <div>
                      <label for="firstName">First Name</label><br>
                      <input type="text" name="first_name" id="firstName">
                      <div class="text-error"><?php echo $valid->error('first_name'); ?></div>
                    </div>

                    <div>
                      <label for="lastName" id="lastName">Last Name</label><br>
                      <input type="text" name="last_name">
                      <div class="text-error"><?php echo $valid->error('last_name'); ?></div>
                    </div>

                    <div>
                      <label for="email" id="email">Email</label><br>
                      <input type="text" name="email">
                      <div class="text-error"><?php echo $valid->error('email'); ?></div>
                    </div>

                    <div>
                      <label for="subject" id="subject">Subject</label><br>
                      <input type="text" name="subject">
                      <div class="text-error"><?php echo $valid->error('subject'); ?></div>
                    </div>

                    <div>
                      <label for="message" id="message">Message</label><br>
                      <textarea name="message"></textarea>
                      <div class="text-error"><?php echo $valid->error('message'); ?></div>
                    </div>

                    <input type="submit">

                  </form>
              </div>
              <div id="Sidebar" class="col">
                <div id="AboutMe">
                  <div class="header">Hello, I am YOUR-NAME</div>
                  <img src="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm" alt="My Avatar" class="img-circle">
                </div>
              </div>
          </div>

          <div id="Footer">
              <small>&copy; 2017 - MyAwesomeSite.com</small>
              <ul class="nav-inline pull-right" role="navigation">
                  <li><a href="terms.html">Terms</a></li>
                  <li><a href="privacy.html">Privacy</a></li>
              </ul>
          </div>
      </div>

  </body>

</html>
