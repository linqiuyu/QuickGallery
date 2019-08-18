<?php
/**
 * 获取目录下的文件夹
 *
 * @param string $dir
 * @return array
 */
function get_dirs($dir = '.') {
    if (empty($dir)) {
        $dir = '.';
    }
    if (!is_dir($dir)) {
        return [];
    }

    $dirs = [];
    $files = array_diff(scandir($dir), array('.', '..', '.git', '.idea'));
    foreach ($files as $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
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
    $dir = ltrim($dir, '.' . DIRECTORY_SEPARATOR);
    $parent_dir = ltrim($parent_dir, '.' . DIRECTORY_SEPARATOR);

    if (strpos($dir, $parent_dir . DIRECTORY_SEPARATOR) === 0) {
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
        if (is_child_dir($dir . DIRECTORY_SEPARATOR . 'next', $path)) {
            $dirs[$path] = [
                'name' => $name,
                'children' => dir_list($dir, $path),
            ];
        }
    }

    return $dirs;
}

/**
 * @param $list
 * @param $activated
 * @param string $class
 */
function nav_list($list, $activated, $class = 'nav nav-list') {
    if (empty($class)) {
        echo '<ul>';
    } else {
        echo '<ul class="' . $class . '">';
    }
    foreach ($list as $path => $name) {
        echo '<li><a href="index.php?gallery=' . $path . '" ' . (($activated == $path) ? ' class="active"' : '') . '>';
        if (is_array($name)) {
            echo $name['name'] . '</a>';
            nav_list($name['children'], $activated, null);
        } else {
            echo $name . '</a>';
        }
        echo '</li>';
    }
    echo '</ul>';
}
