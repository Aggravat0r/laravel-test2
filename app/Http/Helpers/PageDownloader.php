<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Storage;

class PageDownloader{
    private $url;
    private $folder = "webpages/";

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function store($page_id)
    {
        $webpage_content = file_get_contents($this->url);
        $webpage_content = $this->formatPage($webpage_content);
        return Storage::put($this->folder.$page_id.'.html', $webpage_content);
    }

    public function getSize($page_id){
        return Storage::size($this->folder.$page_id.'.html');
    }

    private function formatPage($page){
        $baseUrl = $this->getBaseUrl()."/";
        return preg_replace(
            array(
                '/href=(?:"|\')(?!http)(.+)(?:"|\')/m',
                '/src=(?:"|\')(?!http)(.+)(?:"|\')/m'),
            array(
                'href="'.$baseUrl.'/$1"',
                'src="'.$baseUrl.'/$1"',
            ),
            $page
        );
    }

    private function getBaseUrl(){
        $url_info = parse_url($this->url);
        return $url_info['scheme']."://".$url_info['host'];
    }
}
