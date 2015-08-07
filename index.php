<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Viruta VC</title>
        <link rel="stylesheet" href="css/reset.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/photoswipe.css"> 
        <link rel="stylesheet" href="css/default-skin/default-skin.css"> 
        <script src="js/jquery/jquery.js" ></script>
        <script src="js/sly/sly.js" ></script>
        <script src="js/photoswipe/photoswipe.min.js"></script> 
        <script src="js/photoswipe/photoswipe-ui-default.min.js"></script> 
        <script src="js/main.js"></script>
    </head>
    <?php
    require ('control' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');
    require ('control' . DIRECTORY_SEPARATOR . 'basemysql.php');
    ?>
    <body>
        <div class="background"></div>
        <div class="cont-gral" >
            <div class="sidebar">
                <header>
                    <img src="img/eye.png" alt="logo" width="40"/>
                    <h1>Viruta VC</h1>
                </header>
                <nav class="main-nav">
                    <ul>
                        <li><a href="javascript:void(0)" onclick="$('#icon_menu').attr('class','icon-menu shrink-middle')">Menu</a></li>
                        <?php
                        $menuCategories = queryDB('SELECT * FROM categories WHERE active = true', true, $dbhost, $dbuser, $dbpswd, $dbname);
                        if ($menuCategories) {
                            foreach ($menuCategories as $key => $row) {
                                echo '<li><a href="javascript:void(0)" onclick="getWorks(' . $row['id'] . ');">' . $row['name'] . '</a></li>';
                            }
                        }
                        ?>
                        <li><a href="javascript:void(0)">Acerca</a></li>
                        <li><a href="javascript:void(0)">Contacto</a></li>
                    </ul>
                </nav>
            </div>
            <div class="content">
                <div id="loader" class="loader">
                    <div class="square"></div>
                </div>
                <div id="frame" class="frame">
                    <div id="slidee" class="slidee"></div>
                </div>
                <div id="icon_menu" class="icon-menu">
                        <div class="icon-menu-item">a</div>
                        <div class="icon-menu-item">b</div>
                        <div class="icon-menu-item">c</div>
                        <div class="icon-menu-item">d</div>
                        <div class="icon-menu-item">e</div>
                        <div class="icon-menu-item">f</div>
                        <div class="icon-menu-item">g</div>
                        <div class="icon-menu-item">h</div>
                        <div class="icon-menu-item">i</div>
                    </div>
                <ul id="scroll_buttons" class="scroll-buttons">
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
