<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dir = 'dir1';  //путь к папке, для которой надо вывести путь(дерево) относительно файла index.php
$space = ''; //что подставить перед выводом пути папки

function listing($dir, $space) //функция для вывода структуры папки listing на вход она принимает имя папки и что поставить перед путем файла или папки
{
    $dirCanonical = realpath($dir); // Возвращает канонизированный абсолютный путь к файлу
    if ($fileOrDir = opendir($dirCanonical)) { // Возвращает канонизированный абсолютный путь к файлу
        while ($fileName = readdir($fileOrDir)) { // Получает элемент каталога по его дескриптору, перебирает все элемен ы в папке
            if ($fileName == "." || $fileName == "..") //убирает элементы с названиями "." и ".." это сслыки на папку
                continue;
            $pathToFile = $dirCanonical . DIRECTORY_SEPARATOR . $fileName; //формируется путь файла
            echo $space . $pathToFile . '<br>'; // выводится путь файла
            if (is_dir($pathToFile)) { //проверяется, если файл это папка то рекурсивно запускается функция обхода папки
                echo $space . $pathToFile . '<br>'; // выводится путь папки
                listing($pathToFile,$space . '-' . '&nbsp;'); // вызывается функция обхода папки и делается отсутп, чтобы показать структуру папки
            }
        }
    }
}

// Вывести список файлов и каталогов
//listing($dir, $space); // вызов функциии обхода папки



/*
--------------------------------------------------------------------------------------------------
обход папки(получения дерева) с использование итератора RecursiveIteratorIterator и вложенного в него RecursiveDirectoryIterator
*/


$rdir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), TRUE);  // создаем экземляр класса  RecursiveIteratorIterator
// и в него вкладывает экземляр класса RecursiveDirectoryIterator в качестве аргумента, а ему уже исслудуемую папку

foreach ($rdir as $file) // проходим по полученной коллеции объектов
{
    if ($file->getFilename() != "." || $file->getFilename() != "..") { // выводим все названия кроме "." и ".." то
        echo '<pre>' . str_repeat('-- ', $rdir->getDepth()) . $file . '</pre>'; // str_repeat добавляет '-- ' столько раз,
        // сколько выдает getDepth()(глубина вложенности) перед именем файла
    }
}
