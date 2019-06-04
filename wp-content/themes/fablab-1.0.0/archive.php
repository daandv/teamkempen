<?php defined( 'ABSPATH' ) || exit; ?><!DOCTYPE html><!--  Last Published: Fri May 10 2019 11:12:00 GMT+0000 (UTC)  --><html data-wf-page="5cc2f2a63a80e87640646ef4" data-wf-site="5cc2f2a63a80e8ed6d646eed"><head>
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
<?php wp_enqueue_script("jquery"); wp_head(); ?><?php $udesly_fe_items = udesly_set_fe_items('detail_category'); ?></head>
<body class="body-4 <?php echo " ".join( ' ', get_body_class() ); ?>" udesly-page-name="detail_category">
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
  <div class="section-16 category">
    <div class="container-6 w-container">
      <h1 class="heading-16 category"><?php echo get_the_archive_title(); ?></h1>
    </div>
  </div>
  <div class="section-17">
    <div class="collection-list-wrapper w-dyn-list">
      <?php $prev_page_link = udesly_previous_posts_link(); $next_page_link = udesly_next_posts_link(); if( have_posts() ) :  ?><div class="collection-list w-dyn-items w-row">
        <?php while( have_posts() ) :  the_post(); ?><div class="collection-item-2 w-dyn-item w-col w-col-4">
          <a href="<?php the_permalink(); ?>" class="link-block-6 w-inline-block">
            <div class="div-block-42"><img src="<?php the_post_thumbnail_url('full'); ?>" alt="" class="image-26">
              <div class="div-block-43">
                <h3 class="heading-17" udesly-data="title"><?php the_title(); ?></h3>
                <p class="paragraph-10"><?php echo get_the_excerpt(); ?></p>
                <div class="div-block-40 w-clearfix">
                  <div class="div-block-88" style="background-image: url(<?php echo get_avatar_url( get_the_author_meta( 'ID' ) ); ?>);"></div>
                  <div class="author-title lite"><?php the_author(); ?></div>
                </div>
              </div>
            </div>
          </a>
        </div><?php endwhile; ?>
      </div>
      <?php else : ?><div class="w-dyn-empty">
        <div data-udy-fe="text_1028668715"><?php echo $udesly_fe_items['text_1028668715']; ?></div>
      </div><?php endif; ?>
    </div>
  </div>
  <div class="section-11 navigation">
    <div class="boxed-container navigation">
      <div class="row-4 w-row">
        <div class="column-8 w-col w-col-4"><?php if($prev_page_link) :  ?><a href="<?php echo esc_url($prev_page_link); ?>" class="button-3 previous w-button">Previous</a><?php endif; ?></div>
        <div class="column-10 w-col w-col-4">
          <div class="div-block-85 w-hidden-small w-hidden-tiny">
            <?php $pagination_numbers = udesly_get_numbers_links(); if( $pagination_numbers ) :  ?><ul class="unordered-list-4 w-list-unstyled"><?php foreach($pagination_numbers as $current_number ) :  ?>
              <?php if($current_number["type"] == "number" ):  ?><li class="list-item-6" udesly-data="number"><a href="<?php echo $current_number["url"]; ?>" class="button-10 w-button" data-udy-fe="text_49,link_1142"><?php echo $current_number["number"] ?></a></li><?php endif; ?>
              <?php if($current_number["type"] == "current" ):  ?><li class="list-item-6" udesly-data="current"><a class="button-12 w-button" data-udy-fe="text_50,link_35202"><?php echo $current_number["url"]; ?></a></li><?php endif; ?>
              <?php if($current_number["type"] == "dots"):  ?><li class="list-item-6" udesly-data="dots"><a class="button-11 w-button" data-udy-fe="text_45678,link_35203"><?php echo $udesly_fe_items['text_45678']; ?></a></li><?php endif; ?>
            <?php endforeach; ?></ul><?php endif; ?>
          </div>
        </div>
        <div class="column-9 w-col w-col-4"><?php if($next_page_link) :  ?><a href="<?php echo esc_url($next_page_link); ?>" class="button-3 next w-button">Next</a><?php endif; ?></div>
      </div>
    </div>
  </div>
  <div class="footer">
    <div class="div-block-28">
      <div class="row-2 w-row">
        <div class="column-2 w-col w-col-3"><a href="<?php echo $udesly_fe_items['link_-120906839']; ?>" class="brand footer w-nav-brand" data-udy-fe="link_-120906839"><img src="<?php echo $udesly_fe_items['image_1200326060']->src; ?>" width="30" alt="<?php echo $udesly_fe_items['image_1200326060']->alt; ?>" srcset="<?php echo $udesly_fe_items['image_1200326060']->srcset; ?>" data-udy-fe="image_1200326060"></a>
          <a href="<?php echo $udesly_fe_items['link_-120906838']; ?>" class="brand text footer w-nav-brand" data-udy-fe="link_-120906838">
            <div class="text-block" data-udy-fe="text_-1986500891"><?php echo $udesly_fe_items['text_-1986500891']; ?></div>
          </a>
          <p class="paragraph-2 w-hidden-small w-hidden-tiny" data-udy-fe="text_972837648,text_8205"><br><br><?php echo $udesly_fe_items['text_972837648']; ?><br><?php echo $udesly_fe_items['text_8205']; ?></p>
          <div class="div-block-29"><a href="<?php echo $udesly_fe_items['link_35207']; ?>" class="link-block w-inline-block" data-udy-fe="link_35207"><img src="<?php echo $udesly_fe_items['image_2047281594']->src; ?>" width="20" alt="<?php echo $udesly_fe_items['image_2047281594']->alt; ?>" class="image-4" srcset="<?php echo $udesly_fe_items['image_2047281594']->srcset; ?>" data-udy-fe="image_2047281594"></a><a href="<?php echo $udesly_fe_items['link_35208']; ?>" class="link-block-2 w-inline-block" data-udy-fe="link_35208"><img src="<?php echo $udesly_fe_items['image_-1961026279']->src; ?>" width="20" alt="<?php echo $udesly_fe_items['image_-1961026279']->alt; ?>" class="image-3" srcset="<?php echo $udesly_fe_items['image_-1961026279']->srcset; ?>" data-udy-fe="image_-1961026279"></a><a href="<?php echo $udesly_fe_items['link_35209']; ?>" class="w-inline-block" data-udy-fe="link_35209"><img src="<?php echo $udesly_fe_items['image_-807117686']->src; ?>" width="20" alt="<?php echo $udesly_fe_items['image_-807117686']->alt; ?>" class="image-5" srcset="<?php echo $udesly_fe_items['image_-807117686']->srcset; ?>" data-udy-fe="image_-807117686"></a></div>
        </div>
        <div class="column w-hidden-small w-hidden-tiny w-col w-col-3">
          <div class="text-block-2" data-udy-fe="text_-173405940"><?php echo $udesly_fe_items['text_-173405940']; ?></div>
          <a href="<?php echo $udesly_fe_items['link_-462444397']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_-462444397">
            <div class="text-block-5" data-udy-fe="text_1683947569"><?php echo $udesly_fe_items['text_1683947569']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_689168035']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_689168035">
            <div class="text-block-5" data-udy-fe="text_1443853438"><?php echo $udesly_fe_items['text_1443853438']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_1671804495']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_1671804495">
            <div class="text-block-5" data-udy-fe="text_2073538"><?php echo $udesly_fe_items['text_2073538']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_1567864589']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_1567864589">
            <div class="text-block-5" data-udy-fe="text_2133281470"><?php echo $udesly_fe_items['text_2133281470']; ?></div>
          </a>
        </div>
        <div class="w-hidden-small w-hidden-tiny w-col w-col-3">
          <div class="text-block-4" data-udy-fe="text_-1355980859"><?php echo $udesly_fe_items['text_-1355980859']; ?></div>
          <a href="<?php echo $udesly_fe_items['link_46738950']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_46738950">
            <div class="text-block-5" data-udy-fe="text_945985687"><?php echo $udesly_fe_items['text_945985687']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_1026212295']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_1026212295">
            <div class="text-block-5" data-udy-fe="text_-1069410038"><?php echo $udesly_fe_items['text_-1069410038']; ?></div>
          </a>
        </div>
        <div class="w-hidden-small w-hidden-tiny w-col w-col-3">
          <div class="text-block-3" data-udy-fe="text_-742495891"><?php echo $udesly_fe_items['text_-742495891']; ?></div>
          <a target="_blank" href="<?php echo $udesly_fe_items['link_-104314697']; ?>" class="link-block-8 w-inline-block" data-udy-fe="link_-104314697">
            <div class="text-block-5" data-udy-fe="text_561774310"><?php echo $udesly_fe_items['text_561774310']; ?></div>
          </a>
          <a href="<?php echo $udesly_fe_items['link_-998051916']; ?>" target="_blank" class="link-block-8 w-inline-block" data-udy-fe="link_-998051916">
            <div class="text-block-5" data-udy-fe="text_671954723"><?php echo $udesly_fe_items['text_671954723']; ?></div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright">
    <div class="text-block-6" data-udy-fe="text_964782459"><?php echo $udesly_fe_items['text_964782459']; ?></div>
  </div>
  
  <script type="text/javascript">var $ = window.jQuery;</script><script src="<?php echo get_stylesheet_directory_uri(); ?>/js/webflow.js?v=1557486762" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->

<?php wp_footer(); ?><?php udesly_set_fe_configuration($udesly_fe_items, 'detail_category'); ?></body></html>