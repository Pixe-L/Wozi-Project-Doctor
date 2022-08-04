<?php
header("Content-type: text/plain; charset=utf-8");
echo 'User-agent: *
Disallow: /admin
Sitemap:  '.$ruta.'sitemap.xml';
