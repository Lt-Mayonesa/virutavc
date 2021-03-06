<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <title>Viruta vc</title>
        <link rel="icon" href="favicon.png" sizes="16x16" type="image/png" />
        <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/reset.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/photoswipe.css"> 
        <link rel="stylesheet" href="css/default-skin/default-skin.css"> 
        <script src="js/jquery/jquery.js" ></script>
        <!--script src="//code.jquery.com/jquery-1.11.3.min.js"></script-->
        <script src="js/sly/sly.js" ></script>
        <script src="js/photoswipe/photoswipe.js"></script>
        <script src="js/photoswipe/photoswipe-ui-default.min.js"></script> 
        <script src="js/main.js"></script>

        <!--meta property="og:title" content="Trabajos" />
        <meta property="og:site_name" content="Viruta VC"/>
        <meta property="og:url" content="http://virutavc.com/index.php"/>
        <meta property="og:image" content="http://virutavc.com/img/icon.png"/>
        <meta property="og:description" content="Los Maravillosos trabajos de Valentín Cacault"/>
        <meta property="og:type" content="article" />
        <meta property="og:locale" content="es_AR"/>
        <meta property="article:author" content="https://www.facebook.com/virutavc" />
        <meta property="article:publisher" content="https://www.facebook.com/virutavc" /-->

    </head>
    <?php
    require ('control' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');
    require ('control' . DIRECTORY_SEPARATOR . 'basemysql.php');
    ?>
    <body>
        <div id="fb-root"></div>
        <!--script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.4";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        </script-->
        <div class="background"></div>
        <div class="cont-gral" >
            <div class="sidebar">
                <header>
                    <img src="img/icon.png" alt="logo" width="130"/>
                    <h1>Viruta VC</h1>
                </header>
                <nav class="main-nav">
                    <ul>
                        <li id="li_page_menu"><a href="javascript:void(0)" onclick="showPage('page_menu', 'left');">Menu</a></li>
                        <?php
                        $menuCategories = queryDB('SELECT * FROM categories WHERE active = true');
                        if ($menuCategories) {
                            foreach ($menuCategories as $key => $row) {
                                echo '<li id="li_page_cat_' . $row['id'] . '"><a id="btn_get_works_' . $row['id'] .  '" href="javascript:void(0)" onclick="getWorks(' . $row['id'] . ');">' . $row['name'] . '</a></li>';
                            }
                        }
                        ?>
                        <li id="li_page_about"><a href="javascript:void(0)" onclick="showPage('page_about', 'left');">Acerca</a></li>
                        <li id="li_page_contact"><a href="javascript:void(0)" onclick="showPage('page_contact', 'left');">Contacto</a></li>
                    </ul>
                </nav>
            </div>
            <div id="info_cont" class="info-container"></div>
            <div class="content">
                <div id="loader" class="loader">
                    <div class="square"></div>
                </div>
                <div id="frame" class="frame">
                    <div id="slidee" class="slidee"></div>
                </div>
                <article id="page_menu" class="page">
                    <div class="page-content padding">
                        <div id="thumbnails_cont">
                        </div>
                        <!--aside class="facebook-feed">
                            <div class="fb-page" data-href="https://www.facebook.com/virutavc" data-width="320" data-height="500" data-small-header="true" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="false" data-show-posts="true">
                                <div class="fb-xfbml-parse-ignore">
                                    <blockquote cite="https://www.facebook.com/virutavc">
                                        <a href="https://www.facebook.com/virutavc">Viruta vc</a>
                                    </blockquote>
                                </div>
                            </div>
                        </aside-->
                    </div>
                </article>
                <article id="page_about" class="page shrink-left" style="opacity: 0;">
                    <div class="page-content padding">
                        <h2>Valentin Cacault</h2>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rutrum dui nec dui maximus accumsan. Fusce non tristique nisl. Ut tristique lacus eu mi venenatis, ac ultrices est rhoncus. Etiam eu venenatis sem. Nunc placerat luctus odio, quis ullamcorper tellus luctus sit amet. Nulla ultricies metus eget felis finibus, vitae interdum purus consequat. Proin in aliquam mauris. Vivamus id tincidunt odio. Phasellus nibh mi, suscipit non odio eget, interdum lobortis turpis. Mauris arcu sem, fringilla at nunc sagittis, dignissim posuere neque.</p>
                            <p>Cras consequat bibendum eros, vitae placerat ante posuere vel. Curabitur fringilla eleifend odio ut posuere. Pellentesque quis mollis elit. Praesent efficitur, ex at dictum malesuada, turpis nulla egestas libero, sed efficitur odio mauris eu est. Cras quis lorem fermentum orci sodales iaculis ut egestas erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nam vitae tempus ipsum, id vestibulum lorem. Suspendisse aliquam urna at libero convallis, vel suscipit metus commodo. Maecenas varius lacus nisi, efficitur viverra turpis tincidunt vel.</p>
                        </div>
                    </div>
                </article>
                <article id="page_contact" class="page shrink-left" style="opacity: 0;">
                    <div class="page-content padding">
                        <h2>Contactame</h2>
                        <div class="contact-form">
                            <form action="actions/mailer.php" method="POST">
                                <label for="contactName">Nombre:</label>
                                <input name="contactName" type="text" placeholder="..." required/>
                                <label for="contactEmail">Mail:</label>
                                <input name="contactEmail" type="email" placeholder="..."/>
                                <label for="contactMessage">Mensaje:</label>
                                <textarea name="contactMessage" rows="6" placeholder="se aceptan criticas buenas y malas" required></textarea>
                                
                                <input type="submit" value="Enviar"/>
                            </form>
                        </div>
                    </div>
                </article>
                <ul id="scroll_buttons" class="scroll-buttons" style="display: none;">
                    <li id="prev_work">&uparrow;</li>
                    <li id="next_work">&downarrow;</li>
                </ul>
            </div>
        </div>
        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="pswp__bg"></div>
            <div class="pswp__scroll-wrap">
                <div class="pswp__container">
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>
                <div class="pswp__ui pswp__ui--hidden">
                    <div class="pswp__top-bar">
                        <div class="pswp__counter"></div>
                        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                        <button class="pswp__button pswp__button--share" title="Share"></button>
                        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div> 
                    </div>
                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                    </button>
                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                    </button>
                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
