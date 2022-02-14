<?php

require_once 'markdown/MarkdownExtra.inc.php';

function processDir($src, $dst) {
    if (!file_exists($dst)) {
        mkdir($dst);
    }
    $files = scandir($src);
    foreach ($files as $fname) {
        if ($fname[0] == '_' || $fname[0] == '.') {
            continue;
        }
        if (is_dir("$src/$fname")) {
            processDir("$src/$fname", "$dst/$fname");
        } else {
            $text = file_get_contents("$src/$fname");
            $html = convert($text);
            file_put_contents(str_replace('.md', '.html', "$dst/$fname"), $html);
        }
    }
}

function convert($text) {
    $params = extractParams($text);
    $text = substituteParams($text, $params);
    $template = file_get_contents("src/_templates/{$params['template']}.html");
    $params['text'] = \Michelf\MarkdownExtra::defaultTransform($text);
    $html = substituteParams($template, $params);
    return $html;
}

function extractParams(&$text) {
    global $serverUrl, $protocol, $ghRawContentUrl;
    $vars = array(
            'template' => 'default', 'baseurl' => $serverUrl,
            'year' => date('Y'),
            'protocol' => $protocol, 'imgroot' => $ghRawContentUrl);
    $lines = explode("\n", $text);
    $res = array();
    foreach ($lines as $line) {
        $matches = array();
        if (preg_match('/^\s*\<\!\-\-\?([a-z]+)\s+(.*)\-\-\>\s*$/', $line, $matches)) {
            $vars[$matches[1]] = $matches[2];
            continue;
        }
        $res[] = $line;
    }
    $text = implode("\n", $res);
    return $vars;
}

function substituteParams($text, $params) {
    foreach ($params as $name => $value) {
        $text = str_replace("&$name&", $value, $text);
    }
    return $text;
}

processDir('src', 'html');
