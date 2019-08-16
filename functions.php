<?php
/**
 * 获取文件夹列表
 *
 * @param string $dir
 * @return array
 */
function get_dirs($dir = '.') {
    if (empty($dir)) {
        $dir = '.';
    }
    return array_diff(scandir($dir), array('.', '..'));
}

/**
 * 判断文件夹是否为指定文件夹或者他的子文件夹
 *
 * @param string $dir
 * @param string $parent_dir
 * @return bool
 */
function is_belong_to_dir($dir, $parent_dir) {
    if ($dir == $parent_dir) {
        return true;
    }
    if (is_dir($dir) && in_array($dir, get_dirs($parent_dir))) {
        return true;
    }

    return false;
}

function dir_list($dir, $current_dir = null) {
    // 判断当前目录是否和需要的目录在同一级
    if ($dir == $current_dir) {
        return get_dirs($current_dir);
    }

    $list = [];
    // 不是同一级往下获取
    if ($current_dir == null) {
        $current_dir = '';
        if ($dir[0] == '/') {
            $current_dir = '/';
            $dir = trim($dir);
        }
        $current_dir .= substr($dir, 0, strpos($dir, '/') + 1);
        
        $list = get_dirs();
    }
}
