<?php
echo $rss->items($new_courses, 'transformRSS');

function transformRSS($data) {
		return array(
                'title' => $data['Course']['title'],
                'link'  => '/' . $data['Group']['web_path'] . '/'.$data['Course']['web_path'],
                'guid'  => '/' . $data['Group']['web_path'] . '/'.$data['Course']['web_path'],
                'description' => $data['Course']['description'],
                'author' => $data['Group']['name'],
                'pubDate' => ''
        );
}
?>