<?php defined( 'ABSPATH' ) || exit; ?><!DOCTYPE html><!--  Last Published: Fri May 10 2019 11:12:00 GMT+0000 (UTC)  --><html data-wf-page="5cc2f2a63a80e80f47646ef2" data-wf-site="5cc2f2a63a80e8ed6d646eed"><head>
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
<?php wp_enqueue_script("jquery"); wp_head(); ?><?php $udesly_fe_items = udesly_set_fe_items('about'); ?></head>
<body class="body-2 <?php echo " ".join( ' ', get_body_class() ); ?>" udesly-page-name="about"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div data-collapse="medium" data-animation="default" data-duration="400" class="navbar search w-nav"><a href="<?php echo $udesly_fe_items['link_273194441']; ?>" class="brand w-nav-brand" data-udy-fe="link_273194441"><img src="<?php echo $udesly_fe_items['image_-1103214451']->src; ?>" height="35" alt="<?php echo $udesly_fe_items['image_-1103214451']->alt; ?>" srcset="<?php echo $udesly_fe_items['image_-1103214451']->srcset; ?>" data-udy-fe="image_-1103214451"></a>
    <nav role="navigation" class="nav-menu w-nav-menu"><a href="<?php echo $udesly_fe_items['link_-14917563']; ?>" class="nav-link w-nav-link w--current" data-udy-fe="text_-1961798681,link_-14917563"><?php echo $udesly_fe_items['text_-1961798681']; ?></a><a href="<?php echo $udesly_fe_items['link_-1653484085']; ?>" class="nav-link w-nav-link" data-udy-fe="text_-273746995,link_-1653484085"><?php echo $udesly_fe_items['text_-273746995']; ?></a><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="nav-link w-nav-link">Onze toestellen</a><a href="<?php echo $udesly_fe_items['link_604765606']; ?>" class="nav-link w-nav-link" data-udy-fe="text_-502807520,link_604765606"><?php echo $udesly_fe_items['text_-502807520']; ?></a><?php if( !is_user_logged_in() ) : ?><a href="login.html" class="nav-link sign-in w-nav-link">Log in</a><?php endif; ?>
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
    <div class="container-13 w-container">
      <h1 class="heading-16" data-udy-fe="text_1683947569"><?php echo $udesly_fe_items['text_1683947569']; ?></h1>
      <p class="paragraph-9" data-udy-fe="text_1555402512"><?php echo $udesly_fe_items['text_1555402512']; ?></p>
    </div>
  </div>
  <div class="section-2">
    <div class="container-fluid-2">
      <div>
        <div class="flex-row-2 w-row">
          <div class="w-col w-col-5 w-col-stack">
            <div class="left-padding">
              <div class="heading-5 about" data-udy-fe="text_-1893006287"><?php echo $udesly_fe_items['text_-1893006287']; ?></div>
              <h2 class="heading-2" data-udy-fe="text_-698330121,text_167230283"><?php echo $udesly_fe_items['text_-698330121']; ?><br><?php echo $udesly_fe_items['text_167230283']; ?></h2>
              <div class="top-margin">
                <p class="paragraph" data-udy-fe="text_512895612"><?php echo $udesly_fe_items['text_512895612']; ?></p>
              </div>
            </div>
          </div>
          <div class="column-6 w-col w-col-7 w-col-stack">
            <div class="left-padding">
              <div class="about-wrapper-photo"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section-15" udesly-data-name="bg_image_2130217946" style="<?php echo $udesly_fe_items['bg_image_2130217946']; ?>" data-udy-fe="bg_image_2130217946">
    <div class="container-5 w-container">
      <h3 class="heading-2 center white" data-udy-fe="text_-1160319938"><?php echo $udesly_fe_items['text_-1160319938']; ?></h3>
      <p class="paragraph white" data-udy-fe="text_-511638702"><?php echo $udesly_fe_items['text_-511638702']; ?></p>
    </div>
  </div>
  <div class="section-9 gradient">
    <div class="container-fluid">
      <div>
        <div class="row w-row">
          <div class="column-7 w-col w-col-4 w-col-stack">
            <div class="testimonials-wrapper white with-margin">
              <div>
                <p class="paragraph cards" data-udy-fe="text_-742364284"><?php echo $udesly_fe_items['text_-742364284']; ?></p>
              </div>
              <div class="top-margin">
                <div class="testi-name-wrapper">
                  <div class="testi-photo"></div>
                  <div>
                    <h4 class="testi-name-2" data-udy-fe="text_66605"><?php echo $udesly_fe_items['text_66605']; ?></h4>
                    <div class="text-block-32" data-udy-fe="text_1878462358"><?php echo $udesly_fe_items['text_1878462358']; ?></div>
                  </div>
                </div>
              </div>
            </div>
            <div data-w-id="31545706-659b-3000-efe0-b16ca39f2351" style="opacity:0" class="testimonials-wrapper _4 with-margin">
              <div>
                <p class="paragraph cards" data-udy-fe="text_-742364284"><?php echo $udesly_fe_items['text_-742364284']; ?></p>
              </div>
              <div class="top-margin">
                <div class="testi-name-wrapper">
                  <div class="testi-photo photo-4"></div>
                  <div>
                    <h4 class="testi-name-2 white" data-udy-fe="text_-1589053526"><?php echo $udesly_fe_items['text_-1589053526']; ?></h4>
                    <div class="text-block-32" data-udy-fe="text_1164348520"><?php echo $udesly_fe_items['text_1164348520']; ?></div>
                  </div>
                </div>
              </div>
            </div>
            <div data-w-id="31545706-659b-3000-efe0-b16ca39f235d" style="opacity:0" class="testimonials-wrapper _7">
              <div>
                <p class="paragraph cards" data-udy-fe="text_-742364284"><?php echo $udesly_fe_items['text_-742364284']; ?></p>
              </div>
              <div class="top-margin">
                <div class="testi-name-wrapper">
                  <div class="testi-photo ui"></div>
                  <div>
                    <h4 class="testi-name-2 white" data-udy-fe="text_219464439"><?php echo $udesly_fe_items['text_219464439']; ?></h4>
                    <div class="text-block-32" data-udy-fe="text_2024945891"><?php echo $udesly_fe_items['text_2024945891']; ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="w-col w-col-4 w-col-stack">
            <div class="testimonials-wrapper _2 with-margin">
              <div>
                <p class="paragraph cards" data-udy-fe="text_-742364284"><?php echo $udesly_fe_items['text_-742364284']; ?></p>
              </div>
              <div class="top-margin">
                <div class="testi-name-wrapper">
                  <div class="testi-photo photo-3"></div>
                  <div>
                    <h4 class="testi-name-2 white" data-udy-fe="text_-176089298"><?php echo $udesly_fe_items['text_-176089298']; ?></h4>
                    <div class="text-block-32" data-udy-fe="text_861059701"><?php echo $udesly_fe_items['text_861059701']; ?></div>
                  </div>
                </div>
              </div>
            </div>
            <div data-w-id="31545706-659b-3000-efe0-b16ca39f2376" style="opacity:0" class="testimonials-wrapper _5 with-margin">
              <div>
                <p class="paragraph cards" data-udy-fe="text_-742364284"><?php echo $udesly_fe_items['text_-742364284']; ?></p>
              </div>
              <div class="top-margin">
                <div class="testi-name-wrapper">
                  <div class="testi-photo photo-5"></div>
                  <div>
                    <h4 class="testi-name-2 white" data-udy-fe="text_-1589053526"><?php echo $udesly_fe_items['text_-1589053526']; ?></h4>
                    <div class="text-block-32" data-udy-fe="text_-468992162"><?php echo $udesly_fe_items['text_-468992162']; ?></div>
                  </div>
                </div>
              </div>
            </div>
            <div data-w-id="31545706-659b-3000-efe0-b16ca39f2382" style="opacity:0" class="testimonials-wrapper _8">
              <div>
                <p class="paragraph cards" data-udy-fe="text_-742364284"><?php echo $udesly_fe_items['text_-742364284']; ?></p>
              </div>
              <div class="top-margin">
                <div class="testi-name-wrapper">
                  <div class="testi-photo photo-3 ux"></div>
                  <div>
                    <h4 class="testi-name-2 white" data-udy-fe="text_1566729160"><?php echo $udesly_fe_items['text_1566729160']; ?></h4>
                    <div class="text-block-32" data-udy-fe="text_-1258904443"><?php echo $udesly_fe_items['text_-1258904443']; ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="w-col w-col-4 w-col-stack">
            <div data-w-id="31545706-659b-3000-efe0-b16ca39f238f" style="opacity:0" class="testimonials-wrapper _3 with-margin">
              <div>
                <p class="paragraph cards" data-udy-fe="text_-742364284"><?php echo $udesly_fe_items['text_-742364284']; ?></p>
              </div>
              <div class="top-margin">
                <div class="testi-name-wrapper">
                  <div class="testi-photo photo-2"></div>
                  <div>
                    <h4 class="testi-name-2 white" data-udy-fe="text_67070"><?php echo $udesly_fe_items['text_67070']; ?></h4>
                    <div class="text-block-32" data-udy-fe="text_-760705603"><?php echo $udesly_fe_items['text_-760705603']; ?></div>
                  </div>
                </div>
              </div>
            </div>
            <div data-w-id="31545706-659b-3000-efe0-b16ca39f239b" style="opacity:0" class="testimonials-wrapper _6 with-margin">
              <div>
                <p class="paragraph cards" data-udy-fe="text_-742364284"><?php echo $udesly_fe_items['text_-742364284']; ?></p>
              </div>
              <div class="top-margin">
                <div class="testi-name-wrapper">
                  <div class="testi-photo photo-6"></div>
                  <div>
                    <h4 class="testi-name-2 white" data-udy-fe="text_-1695391735"><?php echo $udesly_fe_items['text_-1695391735']; ?></h4>
                    <div class="text-block-32" data-udy-fe="text_2103314292"><?php echo $udesly_fe_items['text_2103314292']; ?></div>
                  </div>
                </div>
              </div>
            </div>
            <div data-w-id="31545706-659b-3000-efe0-b16ca39f23a7" style="opacity:0" class="testimonials-wrapper _9">
              <div>
                <p class="paragraph cards" data-udy-fe="text_-742364284"><?php echo $udesly_fe_items['text_-742364284']; ?></p>
              </div>
              <div class="top-margin">
                <div class="testi-name-wrapper">
                  <div class="testi-photo photo-2 graphic"></div>
                  <div>
                    <h4 class="testi-name-2 white" data-udy-fe="text_-1130821309"><?php echo $udesly_fe_items['text_-1130821309']; ?></h4>
                    <div class="text-block-32" data-udy-fe="text_1084366165"><?php echo $udesly_fe_items['text_1084366165']; ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
          <a href="<?php echo $udesly_fe_items['link_-462444403']; ?>" class="link-block-8 w-inline-block w--current" data-udy-fe="link_-462444403">
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
  
  <script type="text/javascript">var $ = window.jQuery;</script><script src="<?php echo get_stylesheet_directory_uri(); ?>/js/webflow.js?v=1557486761" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->

<?php wp_footer(); ?><?php udesly_set_fe_configuration($udesly_fe_items, 'about'); ?><?php endwhile; endif; ?></body></html>