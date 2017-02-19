<?php

if ($_POST) {
    $errors = array();
    $send = null;

    function validate_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validate_length($text, $length = 10)
    {
        if (strlen($text) < $length) {
            return false;
        }
        return true;
    }

    // Name
    $name = array_key_exists('name', $_POST) ? $_POST['name'] : '';
    if (!$name) {
        $errors['name'] = 'Name cannot be blank.';
    } else {
        if (!validate_length($name, 2)) {
            $errors['name'] = 'Name must have 2 characters at least.';
        }
    }
    // Email
    $email = array_key_exists('email', $_POST) ? $_POST['email'] : '';
    if (!$email) {
        $errors['email'] = 'Email cannot be blank.';
    } else {
        if (!validate_email($email)) {
            $errors['email'] = 'Email must be a valid email.';
        }
    }
    // Messages
    $message = array_key_exists('message', $_POST) ? $_POST['message'] : '';
    if (!$message) {
        $errors['message'] = 'Message cannot be blank.';
    } else {
        if (!validate_length($message, 15)) {
            $errors['message'] = 'Message must have 15 characters at least.';
        }
    }

    if (!$errors) {
        require_once('vendor/autoload.php');
        $config = parse_ini_file('config.ini');

        $apikey = $config['MAILJET_USER'];
        $apisecret = $config['MAILJET_PASSWORD'];

        $mj = new \Mailjet\Client($apikey, $apisecret);

        $body = [
            'FromEmail' => $config['MAIL_FROM'],
            'FromName' => 'Portfolio Mailer',
            'Subject' => 'Portfolio Message',
            'Text-part' => $message,
            'Html-part' => $message,
            'To' => $config['MAIL_TO'],
            'Headers' => [
              'Reply-To' => $email,
            ],
        ];

        $response = $mj->post(\Mailjet\Resources::$Email, ['body' => $body]);
        $send = $response->success() == 'OK';
        if (!$send) {
          echo '<!-- ' . $response->getReasonPhrase() . ' -->';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DANIEL ROGI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>
<!-- Github -->
<a href="https://github.com/danybmx/portfolio" class="github-corner" aria-label="Fork me on Github">
    <svg width="120" height="120" viewBox="0 0 250 250"
         style="fill:#fff; color:#000; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true">
        <path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path>
        <path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2"
              fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path>
        <path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z"
              fill="currentColor" class="octo-body"></path>
    </svg>
</a>
<style>
    .github-corner {
        position: absolute;
        right: 0;
        top: 0;
        z-index: 11;
    }

    .github-corner:hover .octo-arm {
        animation: octocat-wave 560ms ease-in-out;
    }

    @keyframes octocat-wave {
        0%, 100% {
            transform: rotate(0)
        }
        20%, 60% {
            transform: rotate(-25deg)
        }
        40%, 80% {
            transform: rotate(10deg)
        }
    }

    @media (max-width: 500px) {
        .github-corner:hover .octo-arm {
            animation: none;
        }

        .github-corner .octo-arm {
            animation: octocat-wave 560ms ease-in-out;
        }
    }
</style>
<!-- Header -->
<header>
    <div class="container">
        <h1 class="brand">
            DANIEL ROGI
        </h1>
        <nav>
            <ul id="navigation">
                <li><a class="about-me" href="#about-me-anchor">ABOUT ME</a></li>
                <li><a class="skills" href="#skills-anchor">SKILLS</a></li>
                <li><a class="works" href="#works-anchor">EXPERIENCE</a></li>
                <li><a class="get-in-touch" href="#get-in-touch-anchor">GET IN TOUCH</a></li>
            </ul>
        </nav>
    </div>
</header>
<article id="welcome" class="parallax" data-speed="40">
    <div id="intro-text">
        I
        <span class="before-cursor">|</span><span class="write"
                                                  data-strings="DO WEBSITES|DO MOBILE APPS|CODE|DESIGN"></span><span
                class="cursor">|</span><br>
        WITH
        <span class="love"><i class="fa fa-heart"></i></span>
    </div>
    <div class="bottom-wrapper">
        <div class="bottom">
            <div class="bg"></div>
        </div>
    </div>
</article>
<article id="about-me">
    <div id="about-me-anchor" class="link_anchor"></div>
    <div class="container">
        <h2>
            <span class="comment">&lt;!--</span>
            ABOUT ME<span class="cursor">|</span>
            <span class="comment">--&gt;</span>
        </h2>
        <div class="profile-image">
            <div class="image">
                <img src="assets/img/profile.jpg" alt="About me">
            </div>
        </div>
        <p>
            Hi, my name is Daniel Rodríguez Gil and I'm a web developer and graphic designer living in Vigo, Spain.
            Currently I spend my days working as Analyst and programmer at Optare Solutions and the nights as Freelance,
            so feel free to get in touch if you have an idea I might be interested in.</p>
        <p>
            I love work on many different areas of web development, from frontend (HTML, Sass/CSS,
            CoffeeScript/Javascript, Angular, jQuery) to backend (PHP, Ruby on Rails, Node.js, Go and lately I started
            to play with Java) and trying to get the best user experience and visual design for every project.
        </p>
        <p>
            I'm really passionate about web development and development in general and the extense world that exists
            arround it. I enjoy spend my time helping small business to build and improve their online work and
            presence.
        </p>
    </div>
</article>
<article id="skills">
    <div id="skills-anchor" class="link_anchor"></div>
    <h2>
        <span class="comment">//</span>
        SKILLS<span class="cursor">|</span>
    </h2>
    <div class="container">
        <div class="skills">
            <div class="skill" data-percent="100" data-name="HTML5"></div>
            <div class="skill" data-percent="99" data-name="CSS3"></div>
            <div class="skill" data-percent="90" data-name="Javascript"></div>
            <div class="skill" data-percent="100" data-name="PHP"></div>
            <div class="skill" data-percent="95" data-name="Node.js"></div>
            <div class="skill" data-percent="90" data-name="Photoshop"></div>
            <div class="skill" data-percent="70" data-name="Illustrator"></div>
            <div class="skill" data-percent="99" data-name="jQuery"></div>
            <div class="skill" data-percent="80" data-name="Angular.js"></div>
            <div class="skill" data-percent="80" data-name="Objective-C"></div>
            <div class="skill" data-percent="75" data-name="Ruby on Rails"></div>
            <div class="skill" data-percent="20" data-name="Java"></div>
            <div class="clear"></div>
        </div>
    </div>
</article>
<article id="works">
    <div id="works-anchor" class="link_anchor"></div>
    <h2>
        <span class="comment">#</span>
        EXPERIENCE<span class="cursor">|</span>
    </h2>
    <div class="container">

        <!-- Flybikes -->
        <div class="block-wrapper">
            <div class="block">
                <h3 class="work">
                    Web designer, developer and technical support
                </h3>
                <div class="details">
						<span class="place">
							<i class="fa fa-suitcase"></i> Flybikes
						</span>
                    <span class="dates">
							<i class="fa fa-calendar"></i> 2009 - Today
						</span>
                    <span>
							<a href="http://www.flybikes.com" target="_blank">www.flybikes.com</a>
						</span>
                </div>
                <div class="description">
                    It's my current full-time work and I do the website and the B2B Software for work with a lot of
                    distributors along the world. The website is redesigned every year with all the new products and the
                    last was written in PHP using FuelPHP Framework on the server side and HTML5, SASS/CSS3 and
                    CoffeeScript/Javascript with jQuery on the client side and years before it was done using Ruby on
                    Rails.<br>
                    The B2B is made in Node.js using mongoDB as database because their benefits when treat a lot of data
                    and the speed working as an API at the server-side and using Angular.js, Bootstrap and HTML5,
                    SASS/CSS3 and CoffeeScript/Javascript.<br>
                </div>
            </div>
        </div>

        <!-- Cromoly -->
        <div class="block-wrapper">
            <div class="block">
                <h3 class="work">
                    Web designer &amp; developer
                </h3>
                <div class="details">
						<span class="place">
							<i class="fa fa-suitcase"></i> Cromoly
						</span>
                    <span class="dates">
							<i class="fa fa-calendar"></i> 2007 - Today
						</span>
                    <span>
							<a href="http://www.cromoly.com" target="_blank">www.cromoly.com</a>
						</span>
                </div>
                <div class="description">
                    That's the online shop when I start to work on 2007 and my work there was create the website with an
                    online shop, a news system and a few more categories like team. <br>
                    I also be the developer of the point of sale app and do it linking the stock from the online shop in
                    realtime.<br>
                    The website and the point of sale app was written in PHP using a micro framework that I create for
                    learn on the year 2007 and it still working now.
                </div>
            </div>
        </div>

        <!-- Arnette O'Marisquiño -->
        <div class="block-wrapper">
            <div class="block">
                <h3 class="work">
                    Web and mobile App designer &amp; developer
                </h3>
                <div class="details">
						<span class="place">
							<i class="fa fa-suitcase"></i> O'Marisquiño
						</span>
                    <span class="dates">
							<i class="fa fa-calendar"></i> 2012 - Today
						</span>
                    <span>
							<a href="http://www.omarisquino.com" target="_blank">www.omarisquino.com</a>
						</span>
                </div>
                <div class="description">
                    Every summer we have here, in Vigo, the Arnetter O'Marisquiño multicultural event and I'm in charge
                    of make the website and the mobile app. It's an awesome experience and a truly stressful job on the
                    days of the event because the big load of info from all the events but it worth because I learn how
                    to manage my time and organize myself for this kind of works.<br>
                    <div style="margin-top: 20px; text-align: center">
                        <a href="https://play.google.com/store/apps/details?id=es.dpstudios.marisquino"><img
                                    src="//developer.android.com/images/brand/es_generic_rgb_wo_45.png"
                                    style="height: 40px"></a>
                        <a href="https://itunes.apple.com/es/app/marisquino/id550462096?mt=8&amp;uo=4"
                           target="itunes_store"
                           style="display:inline-block;overflow:hidden;background:url(https://linkmaker.itunes.apple.com/htmlResources/assets/es_es//images/web/linkmaker/badge_appstore-lrg.png) no-repeat;width:140px;height:40px;@media only screen{background-image:url(https://linkmaker.itunes.apple.com/htmlResources/assets/es_es//images/web/linkmaker/badge_appstore-lrg.svg);}"></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alquiloapartamentos -->
        <div class="block-wrapper">
            <div class="block">
                <h3 class="work">
                    General designer &amp; developer
                </h3>
                <div class="details">
						<span class="place">
							<i class="fa fa-suitcase"></i> AlquiloApartamentos
						</span>
                    <span class="dates">
							<i class="fa fa-calendar"></i> 2012 - Today
						</span>
                    <span>
							<a href="http://www.alquiloapartamentos.es" target="_blank">www.alquiloapartamentos.es</a>
						</span>
                </div>
                <div class="description">
                    This is a renting portal that I create from scratch using Node.js with express, mongoDB and many
                    other technologies. It's a portal like booking but simpliest with the things that need a national
                    bussines from Spain. Part of the code is published in github under MIT license because that part of
                    my prom work.<br>
                    <a href="https://github.com/freckless/renting.js" target="_blank" class="github">github/freckless/renting.js</a>
                </div>
            </div>
        </div>
    </div>
</article>
<article id="get-in-touch">
    <div id="get-in-touch-anchor" class="link_anchor"></div>
    <h2>
        <span class="comment">/*</span>
        GET IN TOUCH<span class="cursor">|</span>
        <span class="comment">*/</span>
    </h2>
    <div id="contact-form-wrapper">
        <div id="contact-form-fixv"></div>
        <div id="contact-form">
            <?php if ($send !== null): ?>
                <div class="status <?php echo $send ? 'success' : 'error' ?>">
                    <?php if ($send): ?>
                        <script type="text/javascript">
                            window.location.hash = '#contact-form';
                        </script>
                        Your message has been sent, I'll reply as soon as possible
                    <?php else: ?>
                        Sorry, but something happen.<br/>Write me at <a
                                href="mailto:<?php echo $me ?>"><?php echo $me ?></a>
                    <?php endif ?>
                </div>
            <?php else: ?>
                <form method="POST" action="index.php">
                    <?php echo isset($errors['name']) ? '<div class="error">' . $errors['name'] . '</div>' : ''; ?>
                    <input value="<?php echo $_POST ? $_POST['name'] : '' ?>"
                           class="<?php echo $errors['name'] ? 'error' : '' ?>" type="text" name="name" id="name-input"
                           placeholder="Name">
                    <?php echo isset($errors['email']) ? '<div class="error">' . $errors['email'] . '</div>' : ''; ?>
                    <input value="<?php echo $_POST ? $_POST['email'] : '' ?>"
                           class="<?php echo $errors['email'] ? 'error' : '' ?>" type="text" name="email"
                           id="email-input" placeholder="E-mail">
                    <?php echo isset($errors['message']) ? '<div class="error">' . $errors['message'] . '</div>' : ''; ?>
                    <textarea class="<?php echo $errors['message'] ? 'error' : '' ?>" name="message"
                              placeholder="Message"><?php echo $_POST ? $_POST['message'] : '' ?></textarea>
                    <button type="submit">Send message</button>
                </form>
            <?php endif ?>
        </div>
    </div>
</article>
<script src="assets/js/frontpage.js"></script>
</body>
</html>
