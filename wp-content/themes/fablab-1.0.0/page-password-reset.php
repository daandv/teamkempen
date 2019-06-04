<?php defined( 'ABSPATH' ) || exit; ?><!DOCTYPE html><!--  Last Published: Fri May 10 2019 11:12:00 GMT+0000 (UTC)  --><html data-wf-page="5cc2f2a63a80e8722c646f02" data-wf-site="5cc2f2a63a80e8ed6d646eed"><head>
  <meta charset="utf-8">
  
  
  <meta content="width=device-width, initial-scale=1" name="viewport">
  
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/normalize.css?v=1557486766" rel="stylesheet" type="text/css">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/webflow.css?v=1557486766" rel="stylesheet" type="text/css">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/fablab-2-0.webflow.css?v=1557486766" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">WebFont.load({  google: {    families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic","Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic","Inconsolata:400,700","Tajawal:200,300,regular,500,700,800,900","Quicksand:300,regular,500,700","Archivo Black:regular","Archivo:regular,500,600,700"]  }});</script>
  <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-small_1favicon-small.png?v=1557486766" rel="shortcut icon" type="image/x-icon">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-big.png?v=1557486766" rel="apple-touch-icon">
<?php wp_enqueue_script("jquery"); wp_head(); ?><?php $udesly_fe_items = udesly_set_fe_items('password-reset'); ?></head>
<body class="body-2 <?php echo " ".join( ' ', get_body_class() ); ?>" udesly-page-name="password-reset"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div data-collapse="medium" data-animation="default" data-duration="400" class="navbar search w-nav"><a href="<?php echo $udesly_fe_items['link_273194441']; ?>" class="brand w-nav-brand" data-udy-fe="link_273194441"><img src="<?php echo $udesly_fe_items['image_-1103214451']->src; ?>" height="35" alt="<?php echo $udesly_fe_items['image_-1103214451']->alt; ?>" srcset="<?php echo $udesly_fe_items['image_-1103214451']->srcset; ?>" data-udy-fe="image_-1103214451"></a>
    <nav role="navigation" class="nav-menu w-nav-menu"><a href="<?php echo $udesly_fe_items['link_-14917563']; ?>" class="nav-link w-nav-link" data-udy-fe="text_-1961798681,link_-14917563"><?php echo $udesly_fe_items['text_-1961798681']; ?></a><a href="<?php echo $udesly_fe_items['link_-1653484085']; ?>" class="nav-link w-nav-link" data-udy-fe="text_-273746995,link_-1653484085"><?php echo $udesly_fe_items['text_-273746995']; ?></a><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="nav-link w-nav-link">Onze toestellen</a><a href="<?php echo $udesly_fe_items['link_604765606']; ?>" class="nav-link w-nav-link" data-udy-fe="text_-502807520,link_604765606"><?php echo $udesly_fe_items['text_-502807520']; ?></a><?php if( !is_user_logged_in() ) : ?><a href="login.html" class="nav-link sign-in w-nav-link">Log in</a><?php endif; ?>
      <?php if( is_user_logged_in() ) : ?><div><a href="<?php echo wp_logout_url( home_url() ); ?>" class="nav-link w-nav-link">Uitloggen</a></div><?php endif; ?>
    </nav>
    <div class="container w-container">
      <div data-ix="simple-menu-button" class="simple-menu-button w-nav-button">
        <div class="line-1 simple"></div>
        <div class="line-2 simple"></div>
        <div class="line-3 simple"></div>
      </div>
    </div>
  </div>
  <div class="section-7 about register">
    <div class="div-block-84">
      <div class="div-block-82"></div>
      <div class="login-form-container-2 w-container">
        <?php if(!isset($_GET['key']) && !isset($_GET['login']) ) :  ?><div class="lost-password">
          <div class="login-form-head-2"><img src="<?php echo $udesly_fe_items['image_-458548464']->src; ?>" width="50" alt="<?php echo $udesly_fe_items['image_-458548464']->alt; ?>" srcset="<?php echo $udesly_fe_items['image_-458548464']->srcset; ?>" data-udy-fe="image_-458548464">
            <h1 class="hero-head-4 login" data-udy-fe="text_2065514631"><?php echo $udesly_fe_items['text_2065514631']; ?></h1>
            <p class="hero-paragraph-7" data-udy-fe="text_-1136236165"><?php echo $udesly_fe_items['text_-1136236165']; ?></p>
          </div>
          <div class="form-block w-form">
            <form id="email-form" name="email-form" class="form" action="lost-password" method="post" udesly-wp-ajax="lost-password"><input type="text" class="text-field-2 w-input" maxlength="256" name="user_login" placeholder="Email" id="user_login" required><input type="submit" value="Ontvang nieuw wachtwoord" data-wait="Even wachten..." class="submit-button-4 w-button"><?php wp_nonce_field( 'ajax-lost-password-nonce', 'security' ); ?><?php do_action('lostpassword_form'); ?></form>
            <div class="success-message-4 w-form-done">
              <div data-udy-fe="text_1586772413"><?php echo $udesly_fe_items['text_1586772413']; ?></div>
            </div>
            <div class="error-message-4 w-form-fail">
              <div udesly-data="error-message" class="text-block-20">Oops! Something went wrong while submitting the form.</div>
            </div>
          </div>
        </div><?php endif; ?><img src="<?php echo $udesly_fe_items['image_-458548464']->src; ?>" width="50" alt="<?php echo $udesly_fe_items['image_-458548464']->alt; ?>" srcset="<?php echo $udesly_fe_items['image_-458548464']->srcset; ?>" data-udy-fe="image_-458548464">
        <?php if(isset($_GET['key']) && isset($_GET['login']) ) :  ?><div class="reset-password">
          <div class="login-form-head-2">
            <h1 class="hero-head-4 login" data-udy-fe="text_238653386"><?php echo $udesly_fe_items['text_238653386']; ?></h1>
            <p class="hero-paragraph-7" data-udy-fe="text_-1723397378"><?php echo $udesly_fe_items['text_-1723397378']; ?></p>
          </div>
          <?php $reset_password_form_error = udesly_get_reset_password_error(); if(!$reset_password_form_error->get_error_code()) :  ?><div class="form-block w-form">
            <form id="email-form" name="email-form" class="form" action="reset-password" method="post" udesly-wp-ajax="reset-password"><input type="text" class="text-field-2 w-input" maxlength="256" name="user-2" placeholder="Email" id="user-2" required><input type="text" class="text-field-2 w-input" maxlength="256" name="old-password" placeholder="Oud wachtwoord" id="old-password" required><input type="password" class="text-field-2 w-input" maxlength="256" name="password" placeholder="Nieuw wachtwoord" id="password" required><input type="password" class="text-field-2 w-input" maxlength="256" name="password_repeat" placeholder="Bevestig nieuw wachtwoord" id="password_repeat" required><input type="submit" value="Verander je wachtwoord" data-wait="Even wachten..." class="submit-button-4 w-button"><input type="hidden" name="user_key" id="user_key" value="<?php echo esc_attr( $_GET['key'] ); ?>" autocomplete="off"><input type="hidden" name="user_login" id="user_login" value="<?php echo esc_attr( $_GET['login'] ); ?>" autocomplete="off"><?php wp_nonce_field( 'ajax-reset-password-nonce', 'security' ); ?></form>
            <div class="success-message-4 w-form-done">
              <div data-udy-fe="text_-739580264"><?php echo $udesly_fe_items['text_-739580264']; ?></div>
            </div>
            <div class="error-message-4 w-form-fail">
              <div udesly-data="error-message">Oops! Something went wrong while submitting the form.</div>
            </div>
          </div><?php endif; ?><?php if($reset_password_form_error->get_error_code()) :  ?><div class="error-message-4 w-form-fail udesly-register-form-error-message" style="display: block;">
              <div udesly-data="error-message"><?php echo $reset_password_form_error->get_error_message(); ?></div>
            </div><?php endif;  ?>
        </div><?php endif; ?>
      </div>
    </div>
  </div>
  
  <script type="text/javascript">var $ = window.jQuery;</script><script src="<?php echo get_stylesheet_directory_uri(); ?>/js/webflow.js?v=1557486766" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->

<?php wp_footer(); ?><?php udesly_set_fe_configuration($udesly_fe_items, 'password-reset'); ?><?php endwhile; endif; ?></body></html>