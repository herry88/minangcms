<?php header('Content-type: application/rss+xml;'); ?>
<?php  echo '<?xml version="1.0" encoding="utf-8"?>' . "\n"; ?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">
 
    <channel>
     
    <title><![CDATA[<?php echo $channel['title'] ?>]]></title>
 
    <link><?php echo $channel['link'] ?></link>
    <description><![CDATA[<?php echo $channel['description'] ?>]]></description>
    <dc:language><?php echo $channel['lang'] ?></dc:language>
    <dc:creator><?php echo optionGet('company_email'); ?></dc:creator>
 
    <dc:rights>Copyright <?php echo date('D, d M Y H:i:s O', strtotime($channel['pubdate'])) ?></dc:rights>
    <admin:generatorAgent rdf:resource="http://www.ilmuprogrammer.com/" />
 
    <?php foreach($items as $item): ?>
        <item>
            <title><![CDATA[<?php echo $item['title'] ?>]]></title>
            <author><?php echo $item['author'] ?></author>
            <link><?php echo $item['link'] ?></link>
            <guid isPermaLink="true"><?php echo $item['link'] ?></guid>
            <description><![CDATA[<?php echo $item['description'] ?>]]></description>
            <pubDate><?php echo date('D, d M Y H:i:s O', strtotime($item['pubdate'])) ?></pubDate>
        </item>
    <?php endforeach; ?>
     
    </channel>
</rss>