<?php 

function startsWith($string, $search) {
    return substr($string, 0, strlen($search)) === $search;
}