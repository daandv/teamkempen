<?php defined( 'ABSPATH' ) || exit; ?><!DOCTYPE html><!--  Last Published: Fri May 10 2019 11:12:00 GMT+0000 (UTC)  --><html data-wf-page="5cc2f2a63a80e87970646efe" data-wf-site="5cc2f2a63a80e8ed6d646eed"><head>
  <meta charset="utf-8">
  
  
  <meta content="width=device-width, initial-scale=1" name="viewport">
  
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/normalize.css?v=1557486764" rel="stylesheet" type="text/css">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/webflow.css?v=1557486764" rel="stylesheet" type="text/css">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/fablab-2-0.webflow.css?v=1557486764" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">WebFont.load({  google: {    families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic","Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic","Inconsolata:400,700","Tajawal:200,300,regular,500,700,800,900","Quicksand:300,regular,500,700","Archivo Black:regular","Archivo:regular,500,600,700"]  }});</script>
  <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-small_1favicon-small.png?v=1557486764" rel="shortcut icon" type="image/x-icon">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-big.png?v=1557486764" rel="apple-touch-icon">
<?php wp_enqueue_script("jquery"); wp_head(); ?><?php $udesly_fe_items = udesly_set_fe_items('full-width-template'); ?></head>
<body class="body-3 <?php echo " ".join( ' ', get_body_class() ); ?>" udesly-page-name="full-width-template"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
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
  <div class="section-6">
    <div class="container-2 w-container">
      <h3 class="heading-2 center" data-udy-fe="text_-2029119021"><?php echo $udesly_fe_items['text_-2029119021']; ?></h3>
    </div>
    <div>
      <div class="w-dyn-list"><?php $the_query = udesly_get_content_query('recent'); ?>
        <?php if( $the_query->have_posts() ) : ?><div class="w-dyn-items">
          <?php while( $the_query->have_posts() ) :  $the_query->the_post(); ?><div class="collection-item w-dyn-item">
            <a href="<?php the_permalink(); ?>" class="link-block-3 w-inline-block">
              <div data-w-id="f7ee4675-e37d-2655-f1f1-a1f72ad7ed24" style="opacity:0" class="div-block-36 reverse"><img src="<?php the_post_thumbnail_url('full'); ?>" alt="" class="image-14">
                <div class="div-block-39">
                  <h3 class="heading-12" udesly-data="title"><?php the_title(); ?></h3>
                  <p class="paragraph-5"><?php echo get_the_excerpt(); ?></p>
                </div>
              </div>
            </a>
          </div><?php endwhile; wp_reset_query(); ?>
        </div>
        <?php else : ?><div class="w-dyn-empty">
          <div data-udy-fe="text_1028668715"><?php echo $udesly_fe_items['text_1028668715']; ?></div>
        </div><?php endif; wp_reset_postdata(); ?>
      </div>
    </div>
  </div>
  
  <script type="text/javascript">var $ = window.jQuery;</script><script src="<?php echo get_stylesheet_directory_uri(); ?>/js/webflow.js?v=1557486764" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->

<?php wp_footer(); ?><?php udesly_set_fe_configuration($udesly_fe_items, 'full-width-template'); ?><?php endwhile; endif; ?></body></html>