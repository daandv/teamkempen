<?php defined( 'ABSPATH' ) || exit; ?><!DOCTYPE html><!--  Last Published: Fri May 10 2019 11:12:00 GMT+0000 (UTC)  --><html data-wf-page="5cc2f2a63a80e8fe24646f00" data-wf-site="5cc2f2a63a80e8ed6d646eed"><head>
  <meta charset="utf-8">
  
  
  <meta content="width=device-width, initial-scale=1" name="viewport">
  
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/normalize.css?v=1557486765" rel="stylesheet" type="text/css">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/webflow.css?v=1557486765" rel="stylesheet" type="text/css">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/fablab-2-0.webflow.css?v=1557486765" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">WebFont.load({  google: {    families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic","Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic","Inconsolata:400,700","Tajawal:200,300,regular,500,700,800,900","Quicksand:300,regular,500,700","Archivo Black:regular","Archivo:regular,500,600,700"]  }});</script>
  <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-small_1favicon-small.png?v=1557486765" rel="shortcut icon" type="image/x-icon">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-big.png?v=1557486765" rel="apple-touch-icon">
<?php wp_enqueue_script("jquery"); wp_head(); ?><?php $udesly_fe_items = udesly_set_fe_items('login'); ?></head>
<body class="body-2 <?php echo " ".join( ' ', get_body_class() ); ?>" udesly-page-name="login"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div data-collapse="medium" data-animation="default" data-duration="400" class="navbar search w-nav"><a href="<?php echo $udesly_fe_items['link_273194441']; ?>" class="brand w-nav-brand" data-udy-fe="link_273194441"><img src="<?php echo $udesly_fe_items['image_-1103214451']->src; ?>" height="35" alt="<?php echo $udesly_fe_items['image_-1103214451']->alt; ?>" srcset="<?php echo $udesly_fe_items['image_-1103214451']->srcset; ?>" data-udy-fe="image_-1103214451"></a>
    <nav role="navigation" class="nav-menu w-nav-menu"><a href="<?php echo $udesly_fe_items['link_-14917563']; ?>" class="nav-link w-nav-link" data-udy-fe="text_-1961798681,link_-14917563"><?php echo $udesly_fe_items['text_-1961798681']; ?></a><a href="<?php echo $udesly_fe_items['link_-1653484085']; ?>" class="nav-link w-nav-link" data-udy-fe="text_-273746995,link_-1653484085"><?php echo $udesly_fe_items['text_-273746995']; ?></a><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="nav-link w-nav-link">Onze toestellen</a><a href="<?php echo $udesly_fe_items['link_604765606']; ?>" class="nav-link w-nav-link" data-udy-fe="text_-502807520,link_604765606"><?php echo $udesly_fe_items['text_-502807520']; ?></a><?php if( !is_user_logged_in() ) : ?><a href="login.html" class="nav-link sign-in w-nav-link w--current">Log in</a><?php endif; ?>
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
  <div class="section-7 about">
    <div class="div-block-78"><img src="<?php echo $udesly_fe_items['image_-458548464']->src; ?>" width="50" alt="<?php echo $udesly_fe_items['image_-458548464']->alt; ?>" srcset="<?php echo $udesly_fe_items['image_-458548464']->srcset; ?>" data-udy-fe="image_-458548464">
      <div class="login-form-container w-container">
        <div class="login-form-head-2">
          <h1 class="hero-head-4 login" data-udy-fe="text_-1759526087"><?php echo $udesly_fe_items['text_-1759526087']; ?></h1>
          <p class="hero-paragraph-6 login" data-udy-fe="text_-2038634695"><?php echo $udesly_fe_items['text_-2038634695']; ?></p>
        </div>
        <div class="form-block w-form">
          <form id="email-form" name="email-form" redirect="https://www.udesly.com/" class="form w-clearfix" action="login" method="post" udesly-wp-ajax="login"><input type="text" class="text-field-login-form w-input" maxlength="256" name="log" placeholder="Gebruikersnaam" id="log" required><input type="password" class="text-field-4 w-input" maxlength="256" name="pwd" placeholder="Wachtwoord" id="pwd" required>
            <div class="checkbox-field w-checkbox"><input type="checkbox" id="rememberme" name="rememberme" class="checkbox w-checkbox-input"><label for="checkbox" class="field-label w-form-label" data-udy-fe="text_162160217"><?php echo $udesly_fe_items['text_162160217']; ?></label></div><a href="<?php echo $udesly_fe_items['link_1266236507']; ?>" class="link-3" data-udy-fe="text_2065514631,link_1266236507"><?php echo $udesly_fe_items['text_2065514631']; ?></a><input type="submit" value="Log in" data-wait="Even wachten..." class="submit-button-2 w-button" name="wp-submit"><input type="hidden" name="redirect_to" value="https://www.udesly.com/"><?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?></form>
          <div class="success-message-2 w-form-done">
            <div class="hero-paragraph-3 success" data-udy-fe="text_890049685"><?php echo $udesly_fe_items['text_890049685']; ?></div>
          </div>
          <div class="error-message-2 w-form-fail">
            <div udesly-data="error-message" class="hero-paragraph-3 error">Oops! Something went wrong while submitting the form.</div>
          </div>
        </div>
      </div>
      <div class="div-block-82">
        <div class="hero-link-3" data-udy-fe="text_-188198769"><?php echo $udesly_fe_items['text_-188198769']; ?><a href="<?php echo $udesly_fe_items['link_-1551351070']; ?>" class="link-8" data-udy-fe="text_46,link_-1551351070"><span class="text-span-51" data-udy-fe="text_-453782606"><?php echo $udesly_fe_items['text_-453782606']; ?></span><?php echo $udesly_fe_items['text_46']; ?></a></div>
      </div>
    </div>
  </div>
  <div class="footer">
    <div class="div-block-28">
      <div class="row-2 w-row">
        <div class="column-2 w-col w-col-3"><a href="<?php echo $udesly_fe_items['link_273194450']; ?>" class="brand footer w-nav-brand" data-udy-fe="link_273194450"><img src="<?php echo $udesly_fe_items['image_1200326060']->src; ?>" width="30" alt="<?php echo $udesly_fe_items['image_1200326060']->alt; ?>" srcset="<?php echo $udesly_fe_items['image_1200326060']->srcset; ?>" data-udy-fe="image_1200326060"></a>
          <a href="<?php echo $udesly_fe_items['link_-120906842']; ?>" class="brand text footer w-nav-brand" data-udy-fe="link_-120906842">
            <div class="text-block" data-udy-fe="text_-1986500891"><?php echo $udesly_fe_items['text_-1986500891']; ?></div>
          </a>
          <p class="paragraph-2 w-hidden-small w-hidden-tiny" data-udy-fe="text_972837648,text_8205"><br><br><?php echo $udesly_fe_items['text_972837648']; ?><br><?php echo $udesly_fe_items['text_8205']; ?></p>
          <div class="div-block-29"><a href="<?php echo $udesly_fe_items['link_35203']; ?>" class="link-block w-inline-block" data-udy-fe="link_35203"><img src="<?php echo $udesly_fe_items['image_2047281594']->src; ?>" width="20" alt="<?php echo $udesly_fe_items['image_2047281594']->alt; ?>" class="image-4" srcset="<?php echo $udesly_fe_items['image_2047281594']->srcset; ?>" data-udy-fe="image_2047281594"></a><a href="<?php echo $udesly_fe_items['link_35204']; ?>" class="link-block-2 w-inline-block" data-udy-fe="link_35204"><img src="<?php echo $udesly_fe_items['image_-1961026279']->src; ?>" width="20" alt="<?php echo $udesly_fe_items['image_-1961026279']->alt; ?>" class="image-3" srcset="<?php echo $udesly_fe_items['image_-1961026279']->srcset; ?>" data-udy-fe="image_-1961026279"></a><a href="<?php echo $udesly_fe_items['link_35205']; ?>" class="w-inline-block" data-udy-fe="link_35205"><img src="<?php echo $udesly_fe_items['image_-807117686']->src; ?>" width="20" alt="<?php echo $udesly_fe_items['image_-807117686']->alt; ?>" class="image-5" srcset="<?php echo $udesly_fe_items['image_-807117686']->srcset; ?>" data-udy-fe="image_-807117686"></a></div>
        </div>
        <div class="column w-hidden-small w-hidden-tiny w-col w-col-3">
          <div class="text-block-2" data-udy-fe="text_-173405940"><?php echo $udesly_fe_items['text_-173405940']; ?></div>
          <a href="<?php echo $udesly_fe_items['link_-462444401']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_-462444401">
            <div class="text-block-5" data-udy-fe="text_1683947569"><?php echo $udesly_fe_items['text_1683947569']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_689168031']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_689168031">
            <div class="text-block-5" data-udy-fe="text_1443853438"><?php echo $udesly_fe_items['text_1443853438']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_1671804470']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_1671804470">
            <div class="text-block-5" data-udy-fe="text_2073538"><?php echo $udesly_fe_items['text_2073538']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_1567864564']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_1567864564">
            <div class="text-block-5" data-udy-fe="text_2133281470"><?php echo $udesly_fe_items['text_2133281470']; ?></div>
          </a>
        </div>
        <div class="w-hidden-small w-hidden-tiny w-col w-col-3">
          <div class="text-block-4" data-udy-fe="text_-1355980859"><?php echo $udesly_fe_items['text_-1355980859']; ?></div>
          <a href="<?php echo $udesly_fe_items['link_46738925']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_46738925">
            <div class="text-block-5" data-udy-fe="text_945985687"><?php echo $udesly_fe_items['text_945985687']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_1026212270']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_1026212270">
            <div class="text-block-5" data-udy-fe="text_-1069410038"><?php echo $udesly_fe_items['text_-1069410038']; ?></div>
          </a>
        </div>
        <div class="w-hidden-small w-hidden-tiny w-col w-col-3">
          <div class="text-block-3" data-udy-fe="text_-742495891"><?php echo $udesly_fe_items['text_-742495891']; ?></div>
          <a target="_blank" href="<?php echo $udesly_fe_items['link_-104314701']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_-104314701">
            <div class="text-block-5" data-udy-fe="text_561774310"><?php echo $udesly_fe_items['text_561774310']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_-998051920']; ?>" target="_blank" class="link-block-8 w-inline-block" data-udy-fe="link_-998051920">
            <div class="text-block-5" data-udy-fe="text_671954723"><?php echo $udesly_fe_items['text_671954723']; ?></div>
          </a>
        </div>
      </div>
    </div>
  </div>
  
  <script type="text/javascript">var $ = window.jQuery;</script><script src="<?php echo get_stylesheet_directory_uri(); ?>/js/webflow.js?v=1557486765" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->

<?php wp_footer(); ?><?php udesly_set_fe_configuration($udesly_fe_items, 'login'); ?><?php endwhile; endif; ?></body></html>