<style>
    .help-report-wrapper {
        padding: 15px;
    }

    .answers {
        display: inline-block;
        border-radius: 5px;
        color: #fff;
        font-size: 11pt;
        text-transform: uppercase;
        padding: 10px 20px;
        text-align: center;
        width: 50px;
    }

    .answers-yes {
        background-color: #53b743;
    }

    .answers-no {
        background-color: #b74343;
    }

    .answers-yes span,
    .answers-no span {
        display: block;
        font-size: 30pt;
        font-weight: bold;
        line-height: 100%;
    }

    #help-report-comments {
        border-top: 1px solid #E5E5E5;
        border-bottom: 1px solid #E5E5E5;
        margin: 0 -12px;
        display: none;
    }

    #help-report-comments li {
        padding: 10px;
    }

    #help-report-comments li + li {
        border-top: 1px solid #E5E5E5;
    }
</style>
<script>
    function showComments() {
        var e = document.getElementById('help-report-comments');
        if (e.style.display == 'block') {
            e.style.display = 'none';
        } else {
            e.style.display = 'block';
        }
    }
</script>

<div class="help-report-wrapper">
    <div class="answers answers-yes">
        Ja
        <span><?php echo $answers['yes']; ?></span>
        <?php echo round(($answers['yes']/($answers['yes'] + $answers['no']))*100, 2); ?>%
    </div>

    <div class="answers answers-no">
        Nej
        <span><?php echo $answers['no']; ?></span>
        <?php echo round(($answers['no']/($answers['yes'] + $answers['no']))*100, 2); ?>%
    </div>

    <p>
        <a href="#" class="button" class="hbg-help-show-comments" onclick="showComments();return false;">Visa kommentarer</a>
    </p>
</div>

<ul id="help-report-comments">
    <?php foreach ($comments as $comment) : ?>
    <li>
        <span class="rsswidget"><?php echo $comment['date']; ?></span>
        <span class="rss-date"><?php echo $comment['ip'] ?></span>
        <div class="rssSummary"><?php echo $comment['comment']; ?></div>
    </li>
    <?php endforeach; ?>
</ul>