<?php defined( 'ABSPATH' ) || exit; ?><!DOCTYPE html><!--  Last Published: Fri May 10 2019 11:12:00 GMT+0000 (UTC)  --><html data-wf-page="5cc2f2a63a80e85986646eff" data-wf-site="5cc2f2a63a80e8ed6d646eed"><head>
  <meta charset="utf-8">
  
  
  <meta content="width=device-width, initial-scale=1" name="viewport">
  
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/normalize.css?v=1557486761" rel="stylesheet" type="text/css">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/webflow.css?v=1557486761" rel="stylesheet" type="text/css">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/fablab-2-0.webflow.css?v=1557486761" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">WebFont.load({  google: {    families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic","Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic","Inconsolata:400,700","Tajawal:200,300,regular,500,700,800,900","Quicksand:300,regular,500,700","Archivo Black:regular","Archivo:regular,500,600,700"]  }});</script>
  <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-small_1favicon-small.png?v=1557486761" rel="shortcut icon" type="image/x-icon">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-big.png?v=1557486761" rel="apple-touch-icon">
<?php wp_enqueue_script("jquery"); wp_head(); ?><?php $udesly_fe_items = udesly_set_fe_items('boxed-template'); ?></head>
<body class="body-3 <?php echo " ".join( ' ', get_body_class() ); ?>" udesly-page-name="boxed-template"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
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
  <div class="section-25">
    <div class="container-12 w-container"></div>
  </div>
  <div class="footer">
    <div class="div-block-28">
      <div class="row-2 w-row">
        <div class="column-2 w-col w-col-3"><a href="<?php echo $udesly_fe_items['link_273194448']; ?>" class="brand footer w-nav-brand" data-udy-fe="link_273194448"><img src="<?php echo $udesly_fe_items['image_1200326060']->src; ?>" width="30" alt="<?php echo $udesly_fe_items['image_1200326060']->alt; ?>" srcset="<?php echo $udesly_fe_items['image_1200326060']->srcset; ?>" data-udy-fe="image_1200326060"></a>
          <a href="<?php echo $udesly_fe_items['link_273194449']; ?>" class="brand text footer w-nav-brand" data-udy-fe="link_273194449">
            <div class="text-block" data-udy-fe="text_-1986500891"><?php echo $udesly_fe_items['text_-1986500891']; ?></div>
          </a>
          <p class="paragraph-2 w-hidden-small w-hidden-tiny" data-udy-fe="text_972837648,text_8205"><br><br><?php echo $udesly_fe_items['text_972837648']; ?><br><?php echo $udesly_fe_items['text_8205']; ?></p>
          <div class="div-block-29"><a href="<?php echo $udesly_fe_items['link_1142']; ?>" class="link-block w-inline-block" data-udy-fe="link_1142"><img src="<?php echo $udesly_fe_items['image_2047281594']->src; ?>" width="20" alt="<?php echo $udesly_fe_items['image_2047281594']->alt; ?>" class="image-4" srcset="<?php echo $udesly_fe_items['image_2047281594']->srcset; ?>" data-udy-fe="image_2047281594"></a><a href="<?php echo $udesly_fe_items['link_35202']; ?>" class="link-block-2 w-inline-block" data-udy-fe="link_35202"><img src="<?php echo $udesly_fe_items['image_-1961026279']->src; ?>" width="20" alt="<?php echo $udesly_fe_items['image_-1961026279']->alt; ?>" class="image-3" srcset="<?php echo $udesly_fe_items['image_-1961026279']->srcset; ?>" data-udy-fe="image_-1961026279"></a><a href="<?php echo $udesly_fe_items['link_35203']; ?>" class="w-inline-block" data-udy-fe="link_35203"><img src="<?php echo $udesly_fe_items['image_-807117686']->src; ?>" width="20" alt="<?php echo $udesly_fe_items['image_-807117686']->alt; ?>" class="image-5" srcset="<?php echo $udesly_fe_items['image_-807117686']->srcset; ?>" data-udy-fe="image_-807117686"></a></div>
        </div>
        <div class="column w-hidden-small w-hidden-tiny w-col w-col-3">
          <div class="text-block-2" data-udy-fe="text_-173405940"><?php echo $udesly_fe_items['text_-173405940']; ?></div>
          <a href="<?php echo $udesly_fe_items['link_-462444403']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_-462444403">
            <div class="text-block-5" data-udy-fe="text_1683947569"><?php echo $udesly_fe_items['text_1683947569']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_689168029']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_689168029">
            <div class="text-block-5" data-udy-fe="text_1443853438"><?php echo $udesly_fe_items['text_1443853438']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_1671804468']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_1671804468">
            <div class="text-block-5" data-udy-fe="text_2073538"><?php echo $udesly_fe_items['text_2073538']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_1567864562']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_1567864562">
            <div class="text-block-5" data-udy-fe="text_2133281470"><?php echo $udesly_fe_items['text_2133281470']; ?></div>
          </a>
        </div>
        <div class="w-hidden-small w-hidden-tiny w-col w-col-3">
          <div class="text-block-4" data-udy-fe="text_-1355980859"><?php echo $udesly_fe_items['text_-1355980859']; ?></div>
          <a href="<?php echo $udesly_fe_items['link_46738923']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_46738923">
            <div class="text-block-5" data-udy-fe="text_945985687"><?php echo $udesly_fe_items['text_945985687']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_1026212268']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_1026212268">
            <div class="text-block-5" data-udy-fe="text_-1069410038"><?php echo $udesly_fe_items['text_-1069410038']; ?></div>
          </a>
        </div>
        <div class="w-hidden-small w-hidden-tiny w-col w-col-3">
          <div class="text-block-3" data-udy-fe="text_-742495891"><?php echo $udesly_fe_items['text_-742495891']; ?></div>
          <a target="_blank" href="<?php echo $udesly_fe_items['link_-104314724']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_-104314724">
            <div class="text-block-5" data-udy-fe="text_561774310"><?php echo $udesly_fe_items['text_561774310']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_-998051943']; ?>" target="_blank" class="link-block-8 w-inline-block" data-udy-fe="link_-998051943">
            <div class="text-block-5" data-udy-fe="text_671954723"><?php echo $udesly_fe_items['text_671954723']; ?></div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright">
    <div class="text-block-6" data-udy-fe="text_964782459"><?php echo $udesly_fe_items['text_964782459']; ?></div>
  </div>
  
  <script type="text/javascript">var $ = window.jQuery;</script><script src="<?php echo get_stylesheet_directory_uri(); ?>/js/webflow.js?v=1557486761" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->

<?php wp_footer(); ?><?php udesly_set_fe_configuration($udesly_fe_items, 'boxed-template'); ?><?php endwhile; endif; ?></body></html>