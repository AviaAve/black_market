<?php

define("silpoName", "Сільпо");
define("silpoUrl", "https://silpo.ua/graphql");
define("silpoRequestParameters", [
    'post' => [
        'query' => file_get_contents('config/queryParameterToSilpo.txt'),
        'variables' => '{"categoryId":null,"storeIds":null,"pagingInfo":{"offset":0,"limit":999999},"pageSlug":"actions","random":false,"fetchPolicy":"network-only"}',
        'debugName' => "",
        'operationName' => "offers"
]]);
define('silpoHeaders', [
        "authority" => "silpo.ua",
        "method" => "POST",
        "path" => "/graphql",
        "scheme" => "https",
        "accept-encoding" => "gzip, deflate, br",
        "content-length:" => "2469",
        "cookie" => "_ga=GA1.2.256605731.1552806974; _gid=GA1.2.2132265161.1552806974; _gcl_au=1.1.954843636.1552806974; _hjIncludedInSample=1"
    ]);


define("atbName", "АТБ");
define("atdUrl", "https://www.atbmarket.com/hot/akcii/economy/");
define("atbDomen", "https://www.atbmarket.com/");
define("atbRequestParameters", []);
define("atbHeaders", [
    "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
    "Cookie" => "popupsubscribe=1; _ym_uid=1552380280193768953; _ym_d=1552380280; PHPSESSID=dld2tv5jfsfqv39abgntodluq0; __utma=129022940.1712021448.1552141304.1552380283.1552827835.6; __utmc=129022940; __utmz=129022940.1552827835.6.3.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); __utmt=1; __utmb=129022940.4.10.1552827835",
    "User-Agent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36",
    "Content-Type" => "text/html; charset=UTF-8",
    "Accept-Language" => "uk-UA,uk;q=0.9,ru;q=0.8,en-US;q=0.7,en;q=0.6"
]);


define("mySqlDbName", "BLACK_MARKET");
define("mySqlUser", "root");
define("mySqlPassword", "11");
define("mySqlHost", "localhost");