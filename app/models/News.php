<?php

class News {
    private static $feedUrl = "https://forum.autodaily.vn/forums/tin-tuc/index.rss";

    public static function getNews($limit = null) {
        $rss = simplexml_load_file(self::$feedUrl);
        $newsList = [];

        if ($rss && isset($rss->channel->item)) {
            foreach ($rss->channel->item as $item) {
                $newsList[] = [
                    'title' => (string)$item->title,
                    'link' => (string)$item->link,
                    'pubDate' => (string)$item->pubDate,
                    'timestamp' => strtotime($item->pubDate), // dùng để sắp xếp
                ];
            }

            // Sắp xếp theo timestamp giảm dần
            usort($newsList, function ($a, $b) {
                return $b['timestamp'] - $a['timestamp'];
            });

            // Nếu có giới hạn số lượng tin
            if ($limit && is_int($limit)) {
                $newsList = array_slice($newsList, 0, $limit);
            }
        }

        return $newsList;
    }
}
