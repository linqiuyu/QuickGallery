<?php
/**
 * 获取目录下的文件夹
 *
 * @param string $dir
 * @return array
 */
function get_dirs($dir = '.') {
    $dir = str_replace('\\', '/', $dir);
    if (empty($dir)) {
        $dir = '.';
    }
    if (!is_dir($dir)) {
        return [];
    }

    $dirs = [];
    $files = array_diff(scandir($dir), array('.', '..', '.git', '.idea'));
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
             $dirs[$path] = $file;
        }
    }

    return $dirs;
}

/**
 * 判断文件夹是否为指定文件夹或者他的子文件夹
 *
 * @param string $dir
 * @param string $parent_dir
 * @return bool
 */
function is_child_dir($dir, $parent_dir) {
    $dir = ltrim(str_replace('\\', '/', $dir), './');
    $parent_dir = ltrim(str_replace('\\', '/', $parent_dir), './');

    if (strpos($dir, $parent_dir . '/') === 0) {
        return true;
    }

    return false;
}

/**
 * 生成文件列表
 *
 * @param $dir
 * @param null $current_dir
 * @return array
 */
function dir_list($dir, $current_dir = null) {
    $dirs = get_dirs($current_dir);
    foreach ($dirs as $path => $name) {
        if (is_child_dir($dir  . '/next', $path)) {
            $dirs[$path] = [
                'name' => $name,
                'children' => dir_list($dir, $path),
            ];
        }
    }

    return $dirs;
}

/**
 * 生成文件列表菜单
 *
 * @param $list
 * @param $activated
 * @param string $class
 * @param array $omitted
 */
function nav_list($list, $activated, $omitted = array(), $class = 'nav nav-list') {
    if (empty($class)) {
        echo '<ul>';
    } else {
        echo '<ul class="' . $class . '">';
    }
    foreach ($list as $path => $name) {
        if (in_array($path, $omitted)) {
            continue;
        }
        echo '<li><a href="index.php?gallery=' . $path . '" ' . (($activated == $path) ? ' class="active"' : '') . '>';
        if (is_array($name)) {
            echo $name['name'] . '</a>';
            nav_list($name['children'], $activated, $omitted, null);
        } else {
            echo $name . '</a>';
        }
        echo '</li>';
    }
    echo '</ul>';
}

/**
 * 判断文件是否是图片
 *
 * @param $filename
 * @return bool
 */
function is_image($filename){
    if (preg_match('/[\w\/]+.(?:jpg|jpeg|gif|png|bmp)$/i', $filename)) {
        return true;
    }

    return false;
}
