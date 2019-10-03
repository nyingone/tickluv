<?php

namespace App\Services\Banner;

use Symfony\Component\HttpFoundation\Response;

class HTMLMockUpBanner
{

    public function addMockUp(Response $response, $remainingDays)
    {
    $content = $response->getContent();

    $html = '<div id= "Top_banner"> Mock-up banner: '.(int) $remainingDays.' days to go !  </div>';
    
    $content = str_replace(
        '<body>',
        '</body>'. $html,
        $content
    );

    $response->setContent($content);

    return $response;
}

}