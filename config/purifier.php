<?php

return [
    'encoding'         => 'UTF-8',
    'finalize'         => true,
    'cachePath'        => storage_path('app/purifier'),
    'cacheFileMode'    => 0755,
    'settings'         => [
        'default' => [
            'HTML.Doctype'             => 'HTML 4.01 Transitional',
            'HTML.Allowed'             => 'p,b,strong,i,em,u,a[href|title|target],ul,ol,li,br,img[src|alt|title|width|height|style],h1,h2,h3,h4,h5,h6,blockquote',
            'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
            'AutoFormat.AutoParagraph' => true,
            'AutoFormat.RemoveEmpty'    => true,
            'URI.AllowedSchemes'       => [
                'http'  => true,
                'https' => true,
                'mailto'=> true,
                'data'  => true,
            ],
            'Attr.EnableID'            => true,
            'HTML.Trusted'             => true,
            'HTML.SafeIframe'          => true,
        ],
    ],
];
