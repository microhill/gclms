<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    <title><? __('Recently Published Courses') ?></title>
    <link>http://lms/courses/recent.rss</link>
    <language>en-us</language>
    <pubDate><? echo date("D, j M Y H:i:s", gmmktime()) . ' GMT';?></pubDate>
    <? echo $time->nice($time->gmt()) . ' GMT'; ?>
    <? foreach ($this->data as $course): ?>
    <item>
      <title><?= $course['Course']['title']; ?></title>
      <link><?= Configure::read('Site.domain') ?><?= $course['Group']['web_path']; ?>/<?= $course['Course']['web_path']; ?></link>
      <description><?= strip_tags($course['Course']['description']); ?></description>
      <?= $time->nice($course['Course']['created']) . ' GMT'; ?>
       <pubDate><?= $time->nice($time->gmt($course['Course']['created'])) . ' GMT'; ?></pubDate>
      <guid><?= Configure::read('Site.domain') ?><?= $course['Group']['web_path']; ?>/<?= $course['Course']['web_path']; ?></guid>
    </item>
    <? endforeach; ?>
  </channel>
</rss> 