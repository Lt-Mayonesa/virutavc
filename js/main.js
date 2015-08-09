/* global PhotoSwipeUI_Default */

function showForm(id) {
    $('form').attr('class', 'hide');
    $('#' + id).attr('class', 'show');
}

function showActions(id) {
    $('.sub-menu').attr('class', 'sub-menu hide');
    $('#' + id + '_options').attr('class', 'sub-menu show');
}

function getWorkStructure(data, innerWork, currentImage) {
    var workClass = innerWork ? 'work inner-work' : 'work';

    return '<article id="' + data.id + '" class="' + workClass + '"><div class="work-img"><img id="' + currentImage + '" onclick="showImage(this.id);" onload="addItem(this);" src="uploaded/' + data.url + '" alt="imagen"/></div>\n\
                <div class="work-info">\n\
                    <h2>' + data.title + '</h2><p>' + data.description + '</p><p>' + data.created + '</p>\n\
                </div>\n\
            </article>';
}
function getWorks(id) {
    loader.show();
    $('#slidee').empty();
    items = [];
    if (FRAMES.length > 0) {
        for (var f in FRAMES) {
            FRAMES[f].destroy();
        }
    }
    $.get('actions/getbycategory.php?id=' + id, function (res) {
        var hFramesIds = [];
        if (!res.error) {
            var items = res.items;
            var lastAlbum = 1;
            WORKS_TOTAL = items.length;
            for (var i = 0; i < items.length; i++) {
                var item = items[i];
//                var div = item.album_id == 1 ? '' : '<div id="album_' + item.album_id + '" class="h-frame">';
//                var endDiv = item.album_id == 1 ? '' : '</div>';
                if (item.album_id == 1) {
                    $('#slidee').append(getWorkStructure(item, false, i));
                } else {
                    if (lastAlbum != item.album_id) {
                        $('#slidee').append(
                                '<div class="frame h-frame"><div id="album_' + item.album_id + '" class="slidee">\n\
                                    ' + getWorkStructure(item, true, i) + '\
                                </div><button id="album_btn_next_' + item.album_id + '" class="frame-btn frame-btn-right h-frame-btn">&ShortRightArrow;</button><button id="album_btn_prev_' + item.album_id + '" class="frame-btn frame-btn-left h-frame-btn">&ShortLeftArrow;</button><h3 class="album-title">' + item.albumTitle + '</h3></div>'
                                );
                        hFramesIds.push(item.album_id);
                    } else {
                        $('#album_' + lastAlbum).append(getWorkStructure(item, true, i));
                    }
                }
                lastAlbum = item.album_id;
            }
        } else {
            $('#slidee').append('<p class="alert no-works">Todavia no hay trabajos!</p>');
        }
        hFrames = $('.h-frame');
        setTimeout(function () {
            for (var i = 0; i < hFrames.length; i++) {
                optionsHorizontal.prev = '#album_btn_prev_' + hFramesIds[i];
                optionsHorizontal.next = '#album_btn_next_' + hFramesIds[i];
                frame = new Sly(hFrames[i], optionsHorizontal).init();
                FRAMES.push(frame);
            }
        }, 1000);
        frame = new Sly('#frame', options).init();
        FRAMES.push(frame);
        loader.hide();
    }, 'json');
}
var FRAMES = [];
var frame = null;
var WORKS_TOTAL = 0;
var options = {
    scrollSource: document,
    scrollBy: 1,
    itemNav: 'forceCentered',
    speed: 300,
    smart: true,
    mouseDragging: 1,
    touchDragging: 1,
    releaseSwing: true,
    //prev: '#prev_work',
    //next: '#next_work',
    keyboardNavBy: 'items',
    activateOn: 'click'
};
var optionsHorizontal = {
    horizontal: 1,
    //scrollSource: document,
    scrollBy: 1,
    itemNav: 'forceCentered',
    speed: 300,
    smart: true,
    mouseDragging: 1,
    touchDragging: 1,
    releaseSwing: true,
    prev: '#',
    next: '#',
    keyboardNavBy: 'items',
    activateOn: 'click'
};

var loader;
var sly;
var items = [];
var pswpElement;
var optionsPS = {
    index: 0, // start at first slide
    closeOnScroll: false,
    bgOpacity: 0.9
};
var gallery;

$(document).ready(function () {
    loader = new Loader('loader');
    pswpElement = document.querySelectorAll('.pswp')[0];

}).ajaxStart(function () {
    loader.show();
}).ajaxComplete(function () {
    loader.hide();
});

function showImage(id) {
    // start index correct id
    //optionsPS.index = id;
    var image = [];
    image.push(items[id]);
    gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, image, optionsPS);
    gallery.init();
}

function addItem(img) {
    items[img.id] = {
        src: img.src,
        w: img.naturalWidth,
        h: img.naturalHeight
    };
}

function Loader(elm) {
    this.elm = document.getElementById(elm);
}
;

Loader.prototype.show = function () {
    this.elm.className = 'loader fade-in';
};
Loader.prototype.hide = function () {
    this.elm.className = 'loader fade-out';
};

function loadImg(source, imgTagId) {
    $('#' + imgTagId).attr('src', source);
}

function operationSuccess() {
    alert('Operacion Exitosa!');
}
function operationError(msg) {
    var message = msg || 'Error desconocido, intentalo de nuevo.';
    alert(msg);
}

function showPage(id, direction) {
    hidePages(direction);
    if (direction) {
        $('#' + id).attr('class', 'page expand-' + direction);
    } else {
        $('#' + id).attr('class', 'page expand-middle');
    }
}

function hidePages(direction) {
    if (direction) {
        $('.page').attr('class', 'page shrink-' + direction);
    } else {
        $('.page').attr('class', 'page shrink-middle');
    }
}