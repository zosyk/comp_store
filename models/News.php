<?php

class News
{
    /**
     *Return an array of news item
     */
    public static function gewNewsList()
    {
        $db = Db::getConnection();

        $newsList = array();

        $result = $db->query(
            'SELECT id, title, date, short_content, author_name '
            . 'FROM publication '
            . 'ORDER BY date DESC '
            . 'LIMIT 10;'
        );

        $i = 0;
        while ($row = $result->fetch()) {
            $newsList[$i]['id'] = $row['id'];
            $newsList[$i]['title'] = $row['title'];
            $newsList[$i]['date'] = $row['date'];
            $newsList[$i]['short_content'] = $row['short_content'];
            $newsList[$i]['author_name'] = $row['author_name'];
            $i++;
        }

        return $newsList;
    }

    /**
     * @param $id
     * @return array of single news with specified id
     */
    public static function getNewsItemById($id)
    {
        $db = Db::getConnection();

        $newsItem = array();

        $result = $db->query(
            'SELECT * '
            . 'FROM publication '
            . 'WHERE id='.$id
            . ';'
        );

        $result->setFetchMode(PDO::FETCH_ASSOC);

        $newsItem = $result->fetch();

        return $newsItem;
    }

}