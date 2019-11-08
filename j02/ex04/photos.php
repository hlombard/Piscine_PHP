#!/usr/bin/php
<?php

if ($argc != 2)
    return;

$http_type = "http://";
if (strstr($argv[1], $http_type) == false || strpos($argv[1], $http_type) !== 0)
{
    $http_type = "https://";
    if (strstr($argv[1], $http_type) == false || strpos($argv[1], $http_type) !== 0)
        exit("Bad URL, has to start with : http:// or https://\n");
}

$file = @file_get_contents($argv[1]);
if ($file === false)
{
	echo "Invalid website, nothing to be done." . "\n";
	return;
}

function get_images_links($file, $url, $http_type)
{
    if (!preg_match_all('<img.*?src=\"(.*?)\">', $file, $tmp))
        exit(0);
    $images = array();
	$elem = explode('/', $url);
    foreach($tmp[1] as $links)
    {
        if (strstr($links, ".jpg") || strstr($links, ".svg") || strstr($links, ".gif") || strstr($links, ".jpeg") || strstr($links, ".png"))
        {
            if (strpos($links, "/") === 0)
            {
               $links = $elem[2] . $links;
               $links = $http_type . $links;
            }
            else if (strstr($links, "http") === false)
            {
                $links = $elem[2] . "/" . $links;
                $links = $http_type . $links;
            }
            if (in_array($links, $images) == false)
                array_push($images, $links);
        }
    }
    return ($images);
}


function dl_images($images, $folder)
{
    if (!count($images))
        exit("No images to download\n");

    foreach($images as $url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER,1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);
        $raw = curl_exec($curl);
        if ($raw === false)
        {
            echo "Curl error with file: $url:\n";
            $raw = curl_error($curl);
        }
        curl_close ($curl);
        $img_name = basename($url);
        if (empty($img_name) === false)
        {
            if (@file_put_contents($folder. "/" .$img_name, $raw) === false)
                echo("ERROR on file: $img_name\n");
        }
    }
}

function create_folder($name, $http_type)
{
    $elem = explode($http_type, $name);
    $folder = "www.";
    if (strstr($elem[1], "www.") === false)
        $folder .= $elem[1];
    else
        $folder = $elem[1];
    $elem = explode("/", $elem[1]);
    if (!file_exists($folder))
       mkdir($folder, 0777, true);
    return ($folder);
}

$images = get_images_links($file, $argv[1], $http_type);
if (count($images) === 0)
   return;
$folder = create_folder($argv[1], $http_type);
dl_images($images, $folder);


?>
