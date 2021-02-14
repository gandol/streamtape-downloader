<?php
require './src/steamTape.php';
use Downloader\StreamTape;
$info = StreamTape::getLinkFile('https://streamtape.com/v/oAyl8rV67auW39/Jellyfish_1080_10s_5MB.mp4');
StreamTape::downloadFile($info['link'],$info['file_name']);