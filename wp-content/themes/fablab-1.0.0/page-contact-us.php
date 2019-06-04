<?php defined( 'ABSPATH' ) || exit; ?><!DOCTYPE html><!--  Last Published: Fri May 10 2019 11:12:00 GMT+0000 (UTC)  --><html data-wf-page="5cc2f2a63a80e8d1d0646efa" data-wf-site="5cc2f2a63a80e8ed6d646eed"><head>
  <meta charset="utf-8">
  
  
  <meta content="width=device-width, initial-scale=1" name="viewport">
  
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/normalize.css?v=1557486762" rel="stylesheet" type="text/css">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/webflow.css?v=1557486762" rel="stylesheet" type="text/css">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/fablab-2-0.webflow.css?v=1557486762" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">WebFont.load({  google: {    families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic","Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic","Inconsolata:400,700","Tajawal:200,300,regular,500,700,800,900","Quicksand:300,regular,500,700","Archivo Black:regular","Archivo:regular,500,600,700"]  }});</script>
  <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-small_1favicon-small.png?v=1557486762" rel="shortcut icon" type="image/x-icon">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-big.png?v=1557486762" rel="apple-touch-icon">
<?php wp_enqueue_script("jquery"); wp_head(); ?><?php $udesly_fe_items = udesly_set_fe_items('contact-us'); ?></head>
<body class="body-10 <?php echo " ".join( ' ', get_body_class() ); ?>" udesly-page-name="contact-us"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div data-collapse="medium" data-animation="default" data-duration="400" class="navbar search w-nav"><a href="<?php echo $udesly_fe_items['link_273194441']; ?>" class="brand w-nav-brand" data-udy-fe="link_273194441"><img src="<?php echo $udesly_fe_items['image_-1103214451']->src; ?>" height="35" alt="<?php echo $udesly_fe_items['image_-1103214451']->alt; ?>" srcset="<?php echo $udesly_fe_items['image_-1103214451']->srcset; ?>" data-udy-fe="image_-1103214451"></a>
    <nav role="navigation" class="nav-menu w-nav-menu"><a href="<?php echo $udesly_fe_items['link_-14917563']; ?>" class="nav-link w-nav-link" data-udy-fe="text_-1961798681,link_-14917563"><?php echo $udesly_fe_items['text_-1961798681']; ?></a><a href="<?php echo $udesly_fe_items['link_-1653484085']; ?>" class="nav-link w-nav-link" data-udy-fe="text_-273746995,link_-1653484085"><?php echo $udesly_fe_items['text_-273746995']; ?></a><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="nav-link w-nav-link">Onze toestellen</a><a href="<?php echo $udesly_fe_items['link_604765606']; ?>" class="nav-link w-nav-link w--current" data-udy-fe="text_-502807520,link_604765606"><?php echo $udesly_fe_items['text_-502807520']; ?></a><?php if( !is_user_logged_in() ) : ?><a href="login.html" class="nav-link sign-in w-nav-link">Log in</a><?php endif; ?>
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
  <div class="section-7 contact-us">
    <div class="container-14 w-container">
      <h1 class="heading-16" data-udy-fe="text_-1678787584"><?php echo $udesly_fe_items['text_-1678787584']; ?></h1>
      <p class="paragraph-9" data-udy-fe="text_1128712133,text_-532056466,text_2047201532"><?php echo $udesly_fe_items['text_1128712133']; ?><br><?php echo $udesly_fe_items['text_-532056466']; ?><br><?php echo $udesly_fe_items['text_2047201532']; ?></p>
      <p class="paragraph-9-extra" data-udy-fe="text_-979546709,text_191909596"><strong data-udy-fe="text_902652170"><?php echo $udesly_fe_items['text_902652170']; ?><br></strong><?php echo $udesly_fe_items['text_-979546709']; ?><br><?php echo $udesly_fe_items['text_191909596']; ?><br></p>
    </div>
  </div>
  <div class="w-clearfix">
    <div class="half-section from">
      <div class="center-div">
        <div>
          <div class="top-title">
            <h2 class="heading-22" data-udy-fe="text_1713625670"><?php echo $udesly_fe_items['text_1713625670']; ?></h2>
          </div>
        </div>
        <div>
          <div class="form-block-2 w-form">
            <form id="email-form" name="email-form" action="udesly-ajax" method="post" udesly-wp-ajax="form"><label class="field-label-2" data-udy-fe="text_2420031"><?php echo $udesly_fe_items['text_2420031']; ?></label><input type="text" id="name-2" name="name-2" maxlength="256" class="text-field-3 w-input"><label class="field-label-2" data-udy-fe="text_67066748"><?php echo $udesly_fe_items['text_67066748']; ?></label><input type="text" class="text-field-3 w-input" maxlength="256" name="email-2" id="email-2" required><label for="Message" class="field-label-2" data-udy-fe="text_1445752981"><?php echo $udesly_fe_items['text_1445752981']; ?></label><textarea id="Message-2" name="Message-2" maxlength="5000" class="text-field-3 area w-input"></textarea><input type="submit" value="verzenden" data-wait="Even wachten..." class="button-2 w-button"></form>
            <div class="success-message w-form-done">
              <div data-udy-fe="text_1510909345"><?php echo $udesly_fe_items['text_1510909345']; ?></div>
            </div>
            <div class="error-message w-form-fail">
              <div data-udy-fe="text_-2081500825"><?php echo $udesly_fe_items['text_-2081500825']; ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="half-section">
      <div data-disable-touch="1" data-widget-latlng="51.5073509,-0.1277583" data-widget-style="terrain" data-widget-zoom="18" class="map w-widget w-widget-map"></div>
    </div>
  </div>
  
  <script type="text/javascript">var $ = window.jQuery;</script><script src="<?php echo get_stylesheet_directory_uri(); ?>/js/webflow.js?v=1557486762" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->

<?php wp_footer(); ?><?php udesly_set_fe_configuration($udesly_fe_items, 'contact-us'); ?><?php endwhile; endif; ?></body></html>