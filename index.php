<?php
require_once 'functions.php';

$gallery = isset($_GET['gallery']) ? $_GET['gallery'] : '.';
// Removes all forward slashes (/) from define album to prevent path traversal.
//$gallery = str_replace(chr(47), '', $gallery);
$gallery = trim($gallery, '/');
// You can now disable multiple folders from showing up in the list.
$disable = array("cache", "folder2", "folder3");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if (!isset($gallery)) {
            echo "Quick Gallery";
        } else {
            echo "Quick Gallery - " . $gallery . "";
        } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            background: #ebebeb;
            height: 100%;
            padding-top: 10px;
        }

        .active {
            color: #eee11f;
        }

        h1 {
            color: #222;
            text-align: center;
        }

        .row-fluid {
            height: 100%;
        }

        .gallery img {
            background: #222;
            border-radius: 3px;
            padding: 10px;
            display: inline-block;
            margin: 10px;
            border: 1px #fff solid;
        }
    </style>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/fancybox/2.1.5/jquery.fancybox.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/fancybox/2.1.5/jquery.fancybox.css" media="screen"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $("a[rel=gallery]").fancybox({
                'transitionIn': 'none',
                'transitionOut': 'none',
                'titlePosition': 'over',
                'titleFormat': function (title, currentArray, currentIndex, currentOpts) {
                    return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                }
            });
        });
    </script>
</head>

<body>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-2">
            <div class="well">
                <?php
                $list = dir_list($gallery);
                nav_list($list, $gallery);
                ?>

            </div>
            <p style="text-align: center;"><a href="https://github.com/mojeda/QuickGallery" target="_blank">Quick
                    Gallery</a> by <a href="http://www.mojeda.com/" target="_blank">Michael Ojeda</a></p>
        </div>
        <div class="col-md-10 gallery">
            <?php
            $imgdir = $gallery . '/';
            $allowed_types = array('png', 'jpg', 'jpeg', 'gif');
            if (is_dir($imgdir)) {
                $dimg = opendir($imgdir);
                $a_img = [];
                while ($imgfile = readdir($dimg)) {
                    if (in_array(strtolower(substr($imgfile, -3)), $allowed_types) OR
                        in_array(strtolower(substr($imgfile, -4)), $allowed_types)) {
                        $a_img[] = $imgfile;
                    }
                }
                $totimg = count($a_img);
                foreach ($a_img as $img) {
                    echo "<a href='" . $imgdir . $img . "' rel='gallery'><img src='thumb.php?file=$imgdir" . $img . "' /></a>";
                }
            } else {
                echo '<div class="alert alert-warning" role="alert">Folder does not exist</div>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
