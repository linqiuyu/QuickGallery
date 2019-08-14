<?php
/**
 * 获取文件夹列表
 *
 * @param null $dir
 * @return array
 */
function get_dirs($dir = null) {
    if (!empty($dir)) {
        return array_filter(glob($dir . '/*'), 'is_dir');
    }
    return array_filter(glob('*'), 'is_dir');
}

/**
 * 判断文件夹是否为指定文件夹或者他的子文件夹
 *
 * @param string $dir
 * @param string $parent_dir
 * @return bool
 */
function is_belong_to_dir($dir, $parent_dir) {
    if ($dir = $parent_dir) {
        return true;
    }
    if (is_dir($dir) && in_array($dir, get_dirs($parent_dir))) {
        return true;
    }

    return false;
}

function nav_list() {

}