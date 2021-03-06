<?php 
$site_url= "https://www.mavenprojects.in";
error_reporting(E_ALL);
ini_set('display_errors', 1);

    $name_of_uploaded_file =basename($_FILES['uploaded_file']['name']);
    $formData = $_POST;
    getFile( $name_of_uploaded_file, $formData );

    function getFile( $filename , $formData ) {

        $allowedExts = array("csv","pdf","jpg","png","JPG","PNG","jpeg","JPEG");
        $temp = explode(".", $_FILES["uploaded_file"]["name"]);
        $extension = end($temp);
        $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv','application/jpg','image/jpg', 'image/jpeg', 'image/png','image/gif','application/pdf');

        if (in_array($_FILES['uploaded_file']['type'],$mimes )
        && ($_FILES["uploaded_file"]["size"] < 2000000)
        && in_array($extension, $allowedExts))
          {
          if ($_FILES["uploaded_file"]["error"] > 0)
            {
            echo "Return Code: " . $_FILES["uploaded_file"]["error"] . "<br>";
            }
          else
            {      
                sendMailAsAttachment($_FILES["uploaded_file"]["tmp_name"],$_FILES["uploaded_file"]["name"],$formData);         
            }
          }
        else
          {
          echo "Invalid file " . $extension . " {} " . $_FILES['uploaded_file']['type'];
          //echo in_array($_FILES['uploaded_file']['type'],$mimes );
          }  
    }



//This function accepts post data on form submissions and prepare the email message from the form data.

    function prepareEmail( $formData ) {

        // email fields: to, from, subject, and so on
        $to = "hr@mavenprojects.in";
        $from = ""; 
        $subject ="Job Application from " .$formData['name'];
        $message = "Uploaded File\n";
        $message .= "Name :". $formData['name']."\n";
        $message .= "Email Address :". $formData['email']."\n";
        $message .="Applied for ". $formData['position']."\n";
        $headers = "From: $from";

        // boundary 
        $semi_rand = md5(time()); 
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

        // headers for attachment 
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

        // multipart boundary 
        $message .= "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
        $message .= "--{$mime_boundary}\n";

        $emailData = array (
            'to' => $to,
            'from' => $from,
            'subject' => $subject,
            'headers' => $headers,
            'message' => $message
        );

        return $emailData;

    }

    function prepareAttachment( $filename ,$fileorgname) {
        $semi_rand = md5(time()); 
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
        $attachContent = '';
        $file = fopen($filename,"rb");
        $data = fread($file,filesize($filename));
        fclose($file);
        $cvData = chunk_split(base64_encode($data));
        $attachContent .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$fileorgname\"\n" . 
        "Content-Disposition: attachment;\n" . " filename=\"$fileorgname\"\n" . 
        "Content-Transfer-Encoding: base64\n\n" . $cvData . "\n\n";
        $attachContent .= "--{$mime_boundary}\n"; 
        return $attachContent;

    }

    function sendMailAsAttachment( $filename, $fileorgname, $formData ) {

        $emailData = prepareEmail( $formData );
        $attachContent = prepareAttachment( $filename,$fileorgname );
        $message = $emailData['message'].$attachContent;
        $ok = @mail($emailData['to'], $emailData['subject'], $message, $emailData['headers']); 
        
    }



?>

<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Basic Page Needs
================================================== -->
  <meta charset="utf-8">
  <title>Maven Consultant and Construction Pvt Ltd <?php print $site_name; ?></title>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="5;url=<?php print $site_url; ?>">
	

  <!-- Mobile Specific Metas
================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Maven Consultant and Construction Pvt Ltd">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

  <!-- Favicon
================================================== -->
  <link rel="icon" type="image/png" href="images/favicon.png">

  <!-- CSS
================================================== -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="plugins/fontawesome/css/all.min.css">
  <!-- Animation -->
  <link rel="stylesheet" href="plugins/animate-css/animate.css">
  <!-- slick Carousel -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick/slick-theme.css">
  <!-- Colorbox -->
  <link rel="stylesheet" href="plugins/colorbox/colorbox.css">
  <!-- Template styles-->
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <div class="body-inner">

     
    <!-- Header start -->
    <header id="header" class="header-one">
      <div class="bg-white">
        <div class="container">
          <div class="logo-area">
            <div class="row align-items-center">
              <div class="logo col-lg-3 text-center text-lg-left mb-3 mb-md-5 mb-lg-0">
                <a class="d-block" href="index.html">
                  <img loading="lazy" src="images/logo.png" alt="Maven Projects">
                </a>
              </div><!-- logo end -->

              <div class="col-lg-9 header-right">
                <ul class="top-info-box">
                  <li>
                    <div class="info-box">
                      <div class="info-box-content">
                        <p class="info-box-title">Call Us</p>
                        <p class="info-box-subtitle">(+91) 700-829-5234 / (+91) 888-126-0111 </p>
                      </div>
                    </div>
                  </li>
                  <li class="last">
                    <div class="info-box">
                      <div class="info-box-content">
                        <p class="info-box-title">Email Us</p>
                        <p class="info-box-subtitle"> info@mavenprojects.in</p>
                      </div>
                    </div>
                  </li>
                  <!-- <li >
                    <div class="info-box last">
                      <div class="info-box-content">
                          <p class="info-box-title">Global Certificate</p>
                          <p class="info-box-subtitle">ISO 9001:2017</p>
                      </div>
                    </div>
                  </li> -->
                  <li class="header-get-a-quote">
                    <a class="btn btn-primary" href="contact.html">Get A Quote</a>
                  </li>
                </ul><!-- Ul end -->
              </div><!-- header right end -->
            </div><!-- logo area end -->

          </div><!-- Row end -->
        </div><!-- Container end -->
      </div>

      <div class="site-navigation">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <nav class="navbar navbar-expand-lg navbar-dark p-0">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse"
                  aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>

                <div id="navbar-collapse" class="collapse navbar-collapse">
                  <ul class="nav navbar-nav mr-auto">
                    <li class="nav-item  active">
                      <a href="#" class="nav-link ">Home</a>

                    </li>

                    <li class="nav-item dropdown">
                      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">About Us <i
                          class="fa fa-angle-down"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="about.html">Message from Founders</a></li>
                        <li><a href="team.html">Management</a></li>
                        <!-- <li><a href="testimonials.html">Testimonials</a></li>
                            <li><a href="faq.html">Faq</a></li>
                            <li><a href="pricing.html">Pricing</a></li> -->
                      </ul>
                    </li>

                    <li class="nav-item dropdown">
                      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Our Services <i
                          class="fa fa-angle-down"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="projectManagement.html">Project
                            Management</a></li>
                        <li><a href="constructionManagement.html">Construction
                            Management</a></li>
                        <li><a href="annualMaintenance.html">Annual Maintenance and Overhauling</a></li>
                        <li><a href="engineerservices.html">Owner???s Engineer services</a></li>
                        <li><a href="automation.html">Automation Services</a></li>
                        <li><a href="energyManagement.html">Energy Audits and Management</a></li>

                        <li><a href="assetmanagement.html">Asset management services</a></li>
                        <li><a href="reliability.html"> Reliability management services</a></li>
                        <li><a href="monitoring.html">Condition based monitoring system</a></li>

                      </ul>
                    </li>

                    <li class="nav-item">
                      <a href="business.html" class="nav-link ">Our
                        Businesses </a>

                    </li>

                    <li class="nav-item ">
                      <a href="training.html" class="nav-link ">Training &
                        Support</a>
                      <!-- <ul class="dropdown-menu" role="menu">
                            <li><a href="typography.html">Typography</a></li>
                            <li><a href="404.html">404</a></li>
                            <li class="dropdown-submenu">
                                <a href="#!" class="dropdown-toggle" data-toggle="dropdown">Parent Menu</a>
                                <ul class="dropdown-menu">
                                  <li><a href="#!">Child Menu 1</a></li>
                                  <li><a href="#!">Child Menu 2</a></li>
                                  <li><a href="#!">Child Menu 3</a></li>
                                </ul>
                            </li>
                          </ul> -->
                    </li>

                    <li class="nav-item"><a class="nav-link" href="gallery.html">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="careers.html">Careers</a></li>
                  </ul>
                </div>
              </nav>
            </div>
            <!--/ Col end -->
          </div>
          <!--/ Row end -->


          <!--/ Container end -->

        </div>
        <!--/ Navigation end -->
    </header>
    <!--/ Header end -->

	<section id="main-container" class="main-container">


    <div class="row" id="thankyou">

      <div class="col-12">
        <div class="error-page text-center">
          <div class="error-code">
            <h5><strong>Thank you for contacting us, your message has been sent.</strong></h5>
          </div>
          <div class="error-message">
            <h3>We will reach you soon </h3>
          </div>
          <div class="error-body">
		  If you're not redirected in 5 seconds, then try using the button below to go to main page of the site <br>
            <a href="<?php print $continue; ?>" class="btn btn-primary">Back to Home Page</a>
          </div>
        </div>
      </div>

    </div><!-- Content row -->

</section><!-- Main container end -->






    <footer id="footer" class="footer bg-overlay">
      <div class="footer-main">
        <div class="container">
          <div class="row justify-content-between">
            <div class="col-lg-4 col-md-6 footer-widget footer-about">
              <h3 class="widget-title">About Us</h3>
              <img loading="lazy" class="footer-logo" src="images/index-logo1.png" alt="MavenLogo">
              <p>MCCPL has comprise with modern, innovative thinkers and experienced advisors who has ability to deliver
                quality and desirable product to our clients.
              </p>

            </div><!-- Col end -->

            <div class="col-lg-4 col-md-6 footer-widget mt-5 mt-md-0 mt-5">
                            <h3 class="widget-title">Our Services</h3>

                            <ul class="list-arrow">
                                <li><a href="projectManagement.html">Project
                                        Management</a></li>
                                <li><a href="constructionManagement.html">Construction
                                        Management</a></li>

                                <li><a href="annualMaintenance.html">Annual Maintenance and Overhauling</a></li>
                                <li><a href="engineerservices.html">Owner???s Engineer Services</a></li>

                                <li><a href="automation.html">Automation Services</a></li>


                            </ul>
                        </div><!-- Col end -->

                        <div class="col-lg-4 col-md-6 extra-space mt-lg-0 footer-widget">
                
                            <ul class="list-arrow">
                                <li><a href="energyManagement.html">Energy Audits and Management</a></li>
                                <li><a href="assetmanagement.html">Asset Management Services</a></li>

                                <li><a href="reliability.html">Reliability Management Services
                                    </a></li>
                                <li><a href="monitoring.html">Condition Based Monitoring System</a></li>



                            </ul>
                        </div><!-- Col end -->
          </div><!-- Row end -->
        </div><!-- Container end -->
      </div><!-- Footer main end -->
      <div id="top-bar" class="top-bar">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-md-8">
              <ul class="top-info text-center text-md-left">
                <li><i class="fas fa-map-marker-alt"></i>
                  <p class="info-text">Office no.12
                    UGF, Omex Plaza
                    Shakti Khand-2, Indirapuram
                    Ghaziabad-201014</p>
                </li>
              </ul>
            </div>
            <!--/ Top info end -->
                            <div class="footer-social">
                                <ul>
                                    <li><a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li><a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>

                                    </li>
                                </ul>
                            </div>
            <!--/ Top social end -->
          </div>
          <!--/ Content row end -->
        </div>
        <!--/ Container end -->
      </div>
      <!--/ Topbar end -->

      <div class="copyright">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6 col-sm-6">
              <div class="copyright-info">
                <span>Copyright &copy;
                  <script>
                    document.write(new Date().getFullYear())
                  </script>, Designed &amp; Developed by <a href="https://wa.me/+919458707426?text=Hey there!" class="text-danger">KC</a>
                </span>
              </div>
            </div>

            <div class="col-md-6 col-sm-6">
              <div class="footer-menu text-center text-md-right">
                <ul class="list-unstyled mb-0">
                  <li><a href="index.html">Home</a></li>
                  <li><a href="about.html">About Us</a></li>
                  <li><a href="contact.html">Contact us</a></li>
                  <li><a href="careers.html">Careers</a></li>

                </ul>
              </div>
            </div>
          </div><!-- Row end -->

          <div id="back-to-top" data-spy="affix" data-offset-top="10" class="back-to-top position-fixed">
            <button class="btn btn-primary" title="Back to Top">
              <i class="fa fa-angle-double-up"></i>
            </button>
          </div>

        </div><!-- Container end -->
      </div><!-- Copyright end -->
    </footer><!-- Footer end -->


    <!-- Javascript Files
    ================================================== -->

    <!-- initialize jQuery Library -->
    <script src="plugins/jQuery/jquery.min.js"></script>
    <!-- Bootstrap jQuery -->
    <script src="plugins/bootstrap/bootstrap.min.js" defer></script>
    <!-- Slick Carousel -->
    <script src="plugins/slick/slick.min.js"></script>
    <script src="plugins/slick/slick-animation.min.js"></script>
    <!-- Color box -->
    <script src="plugins/colorbox/jquery.colorbox.js"></script>
    <!-- shuffle -->
    <script src="plugins/shuffle/shuffle.min.js" defer></script>


    <!-- Google Map API Key-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
    <!-- Google Map Plugin-->
    <script src="plugins/google-map/map.js" defer></script>

    <!-- Template custom -->
    <script src="js/script.js"></script>

  </div><!-- Body inner end -->
</body>

</html>
