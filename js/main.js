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
    return '<article id="' + data.id + '" class="' + workClass + '">\n\
                <div class="work-img" onmouseout="hideInfo(' + currentImage + ')">\n\
                    <span class="vertical-center-helper"></span>\n\
                    <img id="' + currentImage + '" onclick="showImage(this);" onload="addItem(this, ' + data.album_id + ');" onmouseover="showInfo(this.id)" src="uploaded/' + data.url + '" alt="imagen"/>\n\
                </div>\n\
            </article>';
}

function getWorkThumbStructure(item) {
    return '<div id="work_thumb_' + item.id + '" data-category="' + item.category_id + '" class="work-thumbnail" style="background-image: url(uploaded/' + item.url + ')" onclick="getWorks(this.dataset.category, ' + item.id + ')">\n\
                <p>' + item.title + '</p>\n\
            </div>';
}

function getWorkInfoStructure(imgIndex) {
    var info = WORKS_INFO[imgIndex];
    return '<div id="work_info_' + imgIndex + '" class="work-info">\n\
            <h2>' + info.title + '</h2>\n\
            <p class="info-text">' + info.description + '</p>\n\
            <p class="info-footer">' + info.created + '</p>\n\
        </div>';
}
function getWorks(id, work, album) {
    loader.show();
    var currentAlbum = album || 1;
    var albumToShow = null;
    $('#slidee').empty();
    $('#frame').css('display', 'block');
    items = [];
    if (FRAMES.length > 0) {
        for (var f in FRAMES) {
            FRAMES[f].destroy();
        }
    }

    $.get('actions/getbycategory.php?id=' + id, function (res) {
        var hFramesIds = [];
        var addedAlbums = [];
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
                        if (addedAlbums.indexOf(item.album_id) != -1) {
                            $('#album_' + item.album_id).append(getWorkStructure(item, true, i));
                        } else {
                            $('#slidee').append(
                                    '<div id="h_frame_' + item.album_id + '" class="frame h-frame">\n\
                                        <div id="album_' + item.album_id + '" class="slidee">\n\
                                            ' + getWorkStructure(item, true, i) + '\
                                        </div>\n\
                                        <button id="album_btn_next_' + item.album_id + '" class="frame-btn frame-btn-right h-frame-btn">&ShortRightArrow;</button>\n\
                                        <button id="album_btn_prev_' + item.album_id + '" class="frame-btn frame-btn-left h-frame-btn">&ShortLeftArrow;</button>\n\
                                        <h3 class="album-title">' + item.albumTitle + '</h3>\n\
                                    </div>'
                                    );
                            hFramesIds.push(item.album_id);
                        }
                    } else {
                        $('#album_' + lastAlbum).append(getWorkStructure(item, true, i));
                    }
                }
                var pos = $('#' + i).position();
                var h = $('#' + i).height();
                $('#work_info_' + i).css({'top': pos.top + 'px', 'left': pos.left + 'px', 'height': h + 'px'});
                lastAlbum = item.album_id;
                addedAlbums.push(item.album_id);
                WORKS_INFO[i] = {
                    'title': item.title,
                    'description': item.description,
                    'created': item.created
                };
            }
        } else {
            $('#slidee').append('<p class="alert no-works">Todavia no hay trabajos!</p>');
        }
        hFrames = $('.h-frame');
        //setTimeout(function () {
        for (var i = 0; i < hFrames.length; i++) {
            optionsHorizontal.prev = '#album_btn_prev_' + hFramesIds[i];
            optionsHorizontal.next = '#album_btn_next_' + hFramesIds[i];
            frame = new Sly(hFrames[i], optionsHorizontal).init();
            FRAMES.push(frame);
            if (currentAlbum != 1 && currentAlbum == hFramesIds[i]) {
                albumToShow = frame;
            }
        }
        loader.hide();
        //}, 1000);
        frame = new Sly('#frame', options).init();
        FRAMES.push(frame);
        showPage('frame', 'left', id);
        if (work != null) {
            if (albumToShow == null) {
                frame.toCenter($('#' + work));
            } else {
                frame.toCenter($('#h_frame_' + currentAlbum));
                albumToShow.toCenter($('#' + work));
            }
        }
    }, 'json');
}

function getLastWorks() {
    $.getJSON('actions/getlastworks.php', function (data) {
        if (!data.error) {
            var items = data.items;
            for (var i = 0; i < items.length; i++) {
                $('#thumbnails_cont').append(getWorkThumbStructure(items[i]));
            }
        }
    });
}
var FRAMES = [];
var frame = null;
var WORKS_TOTAL = 0;
var WORKS_INFO = [];
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
var CURRENT_PAGE = 0;
var Navigation = {
    currentPage: 0,
    currentCategory: null,
    currentImage: null,
    imageId: null,
    currentAlbum: null
};
var optionsPS = {
    index: 0,
    closeOnScroll: false,
    bgOpacity: 0.9,
    history: true,
    galleryPIDs: true,
    shareButtons: [
        {id: 'facebook', label: 'Share on Facebook', url: 'https://www.facebook.com/sharer/sharer.php?u={{url}}'},
        {id: 'twitter', label: 'Tweet', url: 'https://twitter.com/intent/tweet?text={{text}}&url={{url}}'},
        {id: 'pinterest', label: 'Pin it', url: 'http://www.pinterest.com/pin/create/button/' + '?url={{url}}&media={{image_url}}&description={{text}}'},
        {id: 'download', label: 'Download image', url: '{{raw_image_url}}', download: true}
    ],
    getPageURLForShare: function () {
        return 'http://virutavc.com/detail?id=' + Navigation.currentImage;
    },
    getTextForShare: function () {
        return 'Viruta vc | ' + WORKS_INFO[Navigation.imageId].title;
    }
};
var gallery;

$(document).ready(function () {
    loader = new Loader('loader');
    pswpElement = document.querySelectorAll('.pswp')[0];
    getLastWorks();
    setCurrentPage('li_page_menu');
    var params = parseUrlParameters();
    if (params.gid != null) {
        getWorks(params.gid, params.pid, params.aid);
    }
}).ajaxStart(function () {
    loader.show();
}).ajaxComplete(function () {
    loader.hide();
});

function showImage(el) {
    var id = el.id;
    var image = [];
    Navigation.currentImage = el.parentElement.parentElement.id;
    Navigation.imageId = id;
    Navigation.currentAlbum = items[id].aid;
    image.push(items[id]);
    optionsPS.galleryUID = Navigation.currentCategory;
    gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, image, optionsPS);
    gallery.init();
}

function showInfo(id) {
    var info = getWorkInfoStructure(id);
    $('#info_cont').append(info);
}

function hideInfo(id) {
    $('#info_cont').empty();
}

function addItem(img, aid) {
    items[img.id] = {
        src: img.src,
        w: img.naturalWidth,
        h: img.naturalHeight,
        pid: img.parentElement.parentElement.id,
        aid: aid
    };
}

function Loader(elm) {
    this.elm = document.getElementById(elm);
}
;

Loader.prototype.show = function () {
    this.elm.style.display = 'block';
    this.elm.className = 'loader fade-in';
};
Loader.prototype.hide = function () {
    this.elm.style.display = 'none';
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

function showPage(id, direction, catId) {
    hidePages(id, direction);
    if (id == 'frame') {
        $('#' + id).css('display', 'block');
    } else {
        if (direction) {
            $('#' + id).attr('class', 'page expand-' + direction);
        } else {
            $('#' + id).attr('class', 'page expand-middle');
        }
    }
    if (catId) {
        setCurrentPage('li_page_cat_' + catId);
    } else {
        setCurrentPage('li_' + id);
    }
    Navigation.currentCategory = catId;
}

function hidePages(id, direction) {
    if (direction) {
        $('.page').attr('class', 'page shrink-' + direction);
    } else {
        $('.page').attr('class', 'page shrink-middle');
    }
    if (id != 'frame') {
        $('#frame').css('display', 'none');
    }
}

function setCurrentPage(id) {
    $('.main-nav ul li').css('font-weight', '400');
    $('#' + id).css('font-weight', '800');
}

function parseUrlParameters() {
    var parameters = [];
    var key = null;
    var value = null;
    var strKey = '';
    var strValue = '';
    var ls = location.href;
    var start = ls.indexOf('#&') + 2;
    for (var i = start; i < ls.length; i++) {
        var char = ls[i];
        if (char != '#') {
            if (key == null) {
                if (char != '=') {
                    strKey += char;
                } else {
                    key = strKey;
                }
            } else if (value == null) {
                if (char != '&') {
                    strValue += char;
                } else {
                    value = strValue;
                    parameters[key] = value;
                    key = null;
                    value = null;
                    strKey = '';
                    strValue = '';
                }
            }
        }
    }
    if (key != null) {
        value = strValue;
        parameters[key] = value;
        key = null;
        value = null;
        strKey = '';
        strValue = '';
    }
    return parameters;
}
