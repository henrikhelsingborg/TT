<?php
/*
Template Name: Alarm RSS
*/

/**
 * Output header
 */
header('Content-Type: application/rss+xml; charset=utf-8;');

/**
 * Get the alarms from the alamrservice
 */

$alarms = $wpdb->get_results("
    SELECT DISTINCT
        a.CaseId,
        a.IDnr,
        a.SentTime,
        a.PresGrp,
        a.HtText,
        a.Address,
        a.AddressDescription,
        a.Name,
        a.Zone,
        a.Position,
        a.Comment,
        a.MoreInfo,
        a.Place,
        a.BigDisturbance,
        a.SmallDisturbance,
        a.ChangeDate,
        a.Station,
        a.Cities
    FROM
        alarm_alarms a
    ORDER BY a.SentTime DESC
    LIMIT 1000
", OBJECT);

echo '<?xml version="1.0" encoding="utf-8"?>';
?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Alarm RSS</title>
        <link><?php echo the_permalink(); ?></link>
        <description><![CDATA[<?php echo $seoMeta; ?>]]></description>
        <language>sv-se</language>
        <lastBuildDate><?php echo \Helsingborg\Helper\Rss::helsingborgRssDate($pages[$lastPage]->post_modified_gmt); ?></lastBuildDate>
        <pubDate><?php echo \Helsingborg\Helper\Rss::helsingborgRssDate($pages[$lastPage]->post_modified_gmt); ?></pubDate>
        <docs>http://www.rssboard.org/rss-specification</docs>
        <image>
            <url><?php echo get_template_directory_uri(); ?>/assets/img/images/hbg-logo-rss.jpg</url>
            <title><![CDATA[Helsingborg Stad]]></title>
            <link>http://www.helsingborg.se</link>
        </image>

        <atom:link href="http://<?php echo $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI]; ?>" rel="self" type="application/rss+xml" />

        <?php foreach ($alarms as $alarm) : ?>
        <item>
            <title><![CDATA[<?php echo $alarm->HtText . ' ' . $alarm->Place; ?>]]></title>
            <pubDate><?php echo $alarm->SentTime; ?></pubDate>
            <description><![CDATA[
                <strong>Tidpunkt:</strong> <?php echo $alarm->SentTime; ?><br>
                <strong>Händelse:</strong> <?php echo $alarm->HtText; ?><br>
                <strong>Station:</strong> <?php echo $alarm->Station; ?><br>
                <strong>Ärendeid:</strong> <?php echo $alarm->IDnr; ?><br>
                <strong>Larmnivå:</strong> <?php echo $alarm->PresGrp; ?><br>
                <strong>Adress:</strong> <?php echo $alarm->Address; ?><br>
                <strong>Plats:</strong> <?php echo $alarm->Place; ?><br>
                <strong>Insatsområde:</strong> <?php echo $alarm->AddressDescription; ?><br>
                <strong>Kommuner:</strong> <?php echo $alarm->Zone; ?><br>
            ]]></description>
        </item>
        <?php endforeach; ?>
    </channel>
</rss>
