<?php
$dir = 'C:/myProject/test/dir1/';  //путь к папке, в которой надо
$space = '';

function listing($dir, $space)
{
    $dirCanonical = realpath($dir);
    if ($fileOrDir = opendir($dirCanonical)) {
        while ($fileName = readdir($fileOrDir)) {
            if ($fileName == "." || $fileName == "..")
                continue;
            $pathToFile = $dirCanonical . DIRECTORY_SEPARATOR . $fileName;
            echo $space . $pathToFile . "<br>";;
            if (is_dir($pathToFile)) {
                echo $space . $pathToFile."<br>";
                listing($pathToFile,$space . '-' . '&nbsp;');
            }
        }
    }
}

// Вывести список файлов и каталогов
listing($dir, $space);
