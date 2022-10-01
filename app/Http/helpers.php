<?php
 
/**
 * Return active if current path begins with path.
 *
 * @param string $path
 * @return string
 */
function active($path) {
    return Request::is($path) ? 'active' :  '';
    /*
    bentuk di atas adalah bentuk sederhana dari code berikut
    if (Request::is($path)) {
        return 'active';
    } else {
        return '';
    }
    */
}