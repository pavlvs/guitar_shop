<?php
function htmlConvert($text) {
    if (htmlspecialchars_decode($text) == $text) {
        return htmlspecialchars($text);
    } else {
        return $text;
    }
}

function addTags($text) {

    // Convert return characters to the Unix new lines
    $text = str_replace("\r\n", "\n", $text); // convert windows
    $text = str_replace("\r", "\n", $text); // convert Mac

    // Get an array of pargraphs
    $paragraphs = explode("\n\n", $text);

    // Add tags to each paragrah
    $text = '';
    foreach ($paragraphs as $p) {
        $p = ltrim($p);

        $first_char = substr($p, 0, 1);
        if ($first_char == '*') {
            // Add <ul> and <li> tags
            $p = '<ul>' . $p . '</li></ul>';
            $p = str_replace("*", '<li>',  $p);
            $p = str_replace("\n", '</li>', $p);
        } else {
            // Add <p> tags
            $p = '<p>' . $p . '</p>';
        }
        $text .= $p;
    }
    return $text;
}

// function to remove some html tags from text
function removeTags($text) {
    // Remove <ul> and <li> tags
    $text = str_replace('<ul>', '', $text);
    $text = str_replace('</li></u>', '', $text);
    $text = str_replace('<li>', '', $text);

    // Remove <p> tags
    $text = str_replace('</p><p>', '\n\n', $text);
    $text = str_replace('<p>', '', $text);
    $text = str_replace('</p>', '', $text);
    return $text;
}
