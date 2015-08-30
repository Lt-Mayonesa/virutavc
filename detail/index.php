<!DOCTYPE html>
<?php
require ('..' . DIRECTORY_SEPARATOR . 'control' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');
require ('..' . DIRECTORY_SEPARATOR . 'control' . DIRECTORY_SEPARATOR . 'basemysql.php');
$workId = filter_input(INPUT_GET, 'id');
$work;
if ($workId) {
    $result = queryDB('SELECT * FROM works WHERE id = ' . $workId);
    $work = $result[0];
} else {
    header("Location: http://virutavc.com/");
    die();
}
?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Gestos</title>
        <link rel="icon" href="favicon.png" sizes="16x16" type="image/png" />
        <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/reset.css" />
        <link rel="stylesheet" href="../css/style.css" />
        <link rel="stylesheet" href="../css/style_detail.css" />
    </head>
    <body>
        <a id="btn_back" href="../">Ver mas trabajos</a>
        <div class="">
            <article class="work">
                <div class="work-img">
                    <span class="vertical-center-helper"></span>
                    <img src="../uploaded/<?php echo $work['url']; ?>" onclick="location.href = '../#&gid=<?php echo $work['category_id']; ?>&pid=<?php echo $work['id']; ?>'" alt="trabajo de valentin cacault"/>
                    <div class="">
                        <h1><?php echo $work['title']; ?></h1>
                        <h2><?php echo $work['description']; ?></h2>
                    </div>
                </div>
            </article>
        </div>
    </body>
</html>