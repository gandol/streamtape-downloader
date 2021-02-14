<?php

namespace Downloader;

class StreamTape
{
    public static function getLinkFile($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        $headers = array();
        $headers[] = 'Authority: strtape.tech';
        $headers[] = 'Dnt: 1';
        $headers[] = 'Upgrade-Insecure-Requests: 1';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36';
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
        $headers[] = 'Sec-Fetch-Site: none';
        $headers[] = 'Sec-Fetch-Mode: navigate';
        $headers[] = 'Sec-Fetch-User: ?1';
        $headers[] = 'Sec-Fetch-Dest: document';
        $headers[] = 'Accept-Language: en-US,en;q=0.9';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        preg_match_all('/<div id="videolink".*/', $result, $match);
        $linkFirst = strip_tags($match[0][0]);
        $linkExplode = explode('?', $linkFirst);
        $linkFind = explode('=', $linkExplode[1]);

        preg_match_all("/token=.*';/", $result, $founded);
        $findToken = substr($founded[0][0], 0, -2);
        $tokenDirt = explode('=', $findToken);
        $linkFind[count($linkFind) - 1] = $tokenDirt[1];
        $finalFind = implode('=', $linkFind);
        $linkExplode[1] = $finalFind;
        $link = implode('?', $linkExplode);
        $fileNameDirt = explode('/', $url);
        $fileName = end($fileNameDirt);
        $final = [
            'link' => "https:" . $link . "&stream=1",
            'file_name' => $fileName
        ];
        return $final;
    }

    public static function getLinkDownload($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $headers = array();
        $headers[] = 'Authority: strtape.tech';
        $headers[] = 'Dnt: 1';
        $headers[] = 'Upgrade-Insecure-Requests: 1';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36';
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
        $headers[] = 'Sec-Fetch-Site: none';
        $headers[] = 'Sec-Fetch-Mode: navigate';
        $headers[] = 'Sec-Fetch-User: ?1';
        $headers[] = 'Sec-Fetch-Dest: document';
        $headers[] = 'Accept-Language: en-US,en;q=0.9';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $last_url = curl_getinfo($ch);
        print_r($last_url);
        exit;
        curl_close($ch);
        return $last_url;
    }



    public static function downloadFile($url, $fileName)
    {
        // echo StreamTape::getLinkDownload($url);
        // exit();

        $file = fopen('./result/' . $fileName, 'w+') or die('Unable to write a file');;
        $ch   = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_FILE, $file);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $headers            = array();
        $headers[]          = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0';
        $headers[]          = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $headers[]          = 'Accept-Language: en-US,en;q=0.5';
        $headers[]          = 'Connection: keep-alive';
        $headers[]          = 'Cache-Control: max-age=0';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result             = curl_exec($ch);
        $contentType        = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);
        fclose($file);
        return true;
    }
}
