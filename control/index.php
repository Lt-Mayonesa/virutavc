<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Administrador</title>
        <link rel="stylesheet" href="css/admin-style.css"/>
        <script src="../js/jquery/jquery.js"></script>
        <script src="../js/main.js"></script>
    </head>
    <?php
    require ('config' . DIRECTORY_SEPARATOR . 'config.php');
    require ('basemysql.php');
    ?>
    <body>
        <div id="loader" class="loader">
            <div class="square"></div>
        </div>
        <div class="menu">
            <header>
                <h1>Panel de Control</h1>
            </header>
            <h2>Acciones</h2>
            <div class="column column-half column-left border-dotted-right">

                <ul>
                    <li><a href="javascript:void(0)" onclick="showActions('work')">Trabajos</a></li>
                    <li><a href="javascript:void(0)" onclick="showActions('category')">Categorias</a></li>
                    <li><a href="javascript:void(0)" onclick="showActions('series')">Series</a></li>
                </ul>
            </div>
            <div class="column column-half column-right">
                <ul id="work_options" class="sub-menu">
                    <li><a href="javascript:void(0)" onclick="showForm('upload_work')">Subir trabajo</a></li>
                    <!--<li><a href="jsvascript:void(0)" onclick="showForm('update_work')">Actualizar trabajo</li>-->
                    <li><a href="javascript:void(0)" onclick="showForm('delete_work')">Eliminar trabajo</a></li>
                </ul>
                <ul id="category_options" class="sub-menu">
                    <li><a href="javascript:void(0)" onclick="showForm('create_category')">Crear Categoria</a></li>
                    <li><a href="javascript:void(0)" onclick="showForm('set_category')">Activar / Desactivar Categoria</a></li>
                </ul>
                <ul id="series_options" class="sub-menu">
                    <li><a href="javascript:void(0)" onclick="showForm('create_album')">Crear serie</a></li>
                    <li><a href="javascript:void(0)" onclick="showForm('delete_album')">Eliminar serie</a></li>
                </ul>
            </div>
        </div>
        <div class="forms">
            <form id="upload_work" method="POST" action="uploadwork.php" enctype="multipart/form-data">
                <label>Archivo:</label>
                <input class="custom-file-input" type="file" id="work_file" name="work_file" required />
                <img id="preview" src="" alt="imagen" style="display: none;" width="100%"/>
                <label>Titulo:</label>
                <input type="text" id="work_title" name="work_title" placeholder="titulo del trabajo" required/>
                <label>Descripción:</label>
                <textarea id="work_description" name="work_description" placeholder="descripcion del trabajo" rows="4" required></textarea>
                <label>Categoria:</label>
                <select name="work_category" required>
                    <option value="" disabled selected>Seleccionar</option>
                    <?php
                    $optionsCategories = queryDB('SELECT * FROM categories');
                    if ($optionsCategories) {
                        foreach ($optionsCategories as $key => $row) {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <label>Album:</label>
                <select name="work_album" required>
                    <?php
                    $optionsAlbums = queryDB('SELECT * FROM albums');
                    if ($optionsAlbums) {
                        foreach ($optionsAlbums as $key => $row) {
                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <label></label>
                <input type="submit" value="Guardar"/>
            </form>
            <form id="delete_work" method="POST" action="deletework.php">
                <input type="submit" value="Eliminar"/>
                <label></label>
                <select name="work_id" required onchange="$('#delete_file').val(this.children[this.selectedIndex].dataset.src);
                        loadImg('../uploaded/' + this.children[this.selectedIndex].dataset.src, 'delete_img');
                        loader.show();">
                    <option value="" disabled selected>seleccionar...</option>
                    <?php
                    $optionsWorks = queryDB('SELECT * FROM works');
                    if ($optionsWorks) {
                        foreach ($optionsWorks as $key => $value) {
                            echo '<option value="' . $value['id'] . '" data-src="' . $value['url'] . '">' . $value['title'] . '</option>';
                        }
                    } else {
                        echo 'no result';
                    }
                    ?>
                </select>
                <input id="delete_file" name="work_file" type="hidden" value="" required />
                <label>Imagen</label>
                <img id="delete_img" alt="" src="" width="100%" onload="loader.hide();"/>
            </form>
            <form id="create_category" method="POST" action="createcategory.php">
                <label>Nombre:</label>
                <input type="text" id="category_name" name="category_name" required placeholder="ej: Ilustraciones"/>
                <label></label>
                <input type="submit" value="Crear"/>
            </form>
            <form id="set_category" method="POST" action="setcategory.php">
                <select name="category_id" required onchange="formSetCategoryUpdate(this.children[this.selectedIndex]);">
                    <option value="" disabled selected >seleccionar...</option>
                    <?php
                    $optionsCategories = queryDB('SELECT * FROM categories');
                    if ($optionsCategories) {
                        foreach ($optionsCategories as $key => $row) {
                            echo '<option data-state="' . $row['active'] . '" value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <div>
                    <p>Estado: <span id="category_state_span">...</span></p>
                </div>
                <label></label>
                <input id="set_category_submit" type="submit" value="Eliminar"/>
            </form>
            <form id="create_album" method="POST" action="createalbum.php">
                <label>Titulo:</label>
                <input type="text" id="album_title" name="album_title" required placeholder="titulo"/>
                <label>Descripción:</label>
                <textarea id="album_description" name="album_description" rows="4" placeholder="descripción"></textarea>
                <input type="submit" value="Crear"/>
            </form>
            <form id="delete_album" method="POST" action="deletealbum.php">
                <select name="album_id" required onchange="deleteAlbumFormSelected = this.children[this.selectedIndex].value;
                        enableDisableOptions('album_new_select', deleteAlbumFormSelected);
                        fillDataFromUrl('../actions/getbyalbum.php?id=' + this.children[this.selectedIndex].value, 'album_works_display', 'album_works_option')">
                    <option value="" disabled selected>seleccionar...</option>
                    <?php
                    $optionsAlbums = queryDB('SELECT * FROM albums');
                    if ($optionsAlbums) {
                        foreach ($optionsAlbums as $key => $row) {
                            if ($row['id'] != 1) {
                                echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
                <div>
                    <p>Trabajos: </p>
                    <ul id="album_works_display">

                    </ul>
                </div>
                <div id="album_works_option" style="display: none;">
                    <label>Eliminar trabajos?</label>
                    <div>
                        <input type="radio" name="album_works" value="true" onclick="changeAlbumsOption(false)"/>Si
                    </div>
                    <div>
                        <input type="radio" name="album_works" value="false" onclick="changeAlbumsOption(true)"/>No
                    </div>
                    <div id="change_albums" style="display: none;">
                        <label>Mover a:</label>
                        <select id="album_new_select" name="album_new">
                            <?php
                            $optionsAlbums = queryDB('SELECT * FROM albums');
                            if ($optionsAlbums) {
                                foreach ($optionsAlbums as $key => $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <label></label>
                <input type="submit" value="Eliminar"/>
            </form>
        </div>
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#preview').show('fade-in');
                        $('#preview').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#work_file").change(function () {
                readURL(this);
            });
            $('form').submit(function (event) {
                event.preventDefault();
                var form = this;
                if (this.id === 'upload_work') {
                    var data = new FormData(this);
                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: data,
                        processData: false,
                        contentType: false,
                        dataType: 'json'
                    }).done(function (res) {
                        if (!res.error)
                            operationSuccess();
                        else
                            operationError(res.msg);
                        if (!res.noReload)
                            location.reload();
                    }).fail(function (error) {
                        console.log(error);
                    });
                } else {
                    $.post(form.action, $(form).serialize(), function (res) {
                        if (!res.error)
                            operationSuccess();
                        else
                            operationError(res.msg);
                        if (!res.noReload)
                            location.reload();
                    }, 'json').fail(function (error) {
                        console.log(error);
                    });
                }
                return false;
            });

            function formSetCategoryUpdate(selected) {
                var active = selected.dataset.state === '1';
                $('#set_category_submit').val(active ? 'Desactivar' : 'Activar');
                $('#category_state_span').text(active ? 'Activada' : 'Desactivada');
            }
            var deleteAlbumFormSelected = 0;

            function changeAlbumsOption(show) {
                if (show) {
                    enableDisableOptions('album_new_select', deleteAlbumFormSelected);
                    $('#change_albums').show();
                    $('#delete_album input[type="submit"]').val('Eliminar y Mover');
                } else {
                    $('#change_albums').hide();
                    $('#delete_album input[type="submit"]').val('Eliminar');
                }
            }

            function enableDisableOptions(select, val) {
                var sOptions = $('#' + select).children();
                $(sOptions[0]).attr('selected', 'selected');
                for (var i = 0; i < sOptions.length; i++) {
                    if (sOptions[i].value == val) {
                        $(sOptions[i]).attr('disabled', 'disabled');
                    } else {
                        $(sOptions[i]).removeAttr('disabled');
                    }
                }
            }

            function fillDataFromUrl(url, id, container) {
                $('#' + id).empty();
                $.getJSON(url, function (res) {
                    if (!res.error) {
                        if (container)
                            $('#' + container).show();
                        for (var i = 0; i < res.items.length; i++) {
                            $('#' + id).append('<li><p>' + res.items[i].title + '</p></li>');
                        }
                    } else {
                        if (container)
                            $('#' + container).hide();
                        $('#' + id).append('<li><p>' + res.msg + '</p></li>');
                    }
                });
            }

        </script>
    </body>
</hmtl>
