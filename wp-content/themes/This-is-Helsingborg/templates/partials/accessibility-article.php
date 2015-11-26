<?php
    global $wp;
    $current_url = home_url(add_query_arg(array(), $wp->request));
    $easyToRead = get_post_meta($post->ID, 'hbg_easy_to_read', true);
?>
<ul class="article-accessibility list list-plain list-horizontal clearfix">
    <li>
        <a href="http://app.eu.readspeaker.com/cgi-bin/rsent?customerid=5507&amp;lang=sv_se&amp;readid=article&amp;url=<?php echo $current_url; ?>" onclick="javascript:readpage(this.href, 'read-speaker-player'); return false;" title="Lyssna på: <?php the_title(); ?>">
            <i class="fa fa-volume-up"></i> Lyssna
        </a>
        </li>
    <?php if ($easyToRead) : ?>
    <li><a href="<?php echo $easyToRead; ?>" title="Lättläst: <?php the_title(); ?>"><i class="fa hbgic-easy-to-read"></i> Lättläst</a></li>
    <?php endif; ?>
</ul>

<div id="read-speaker-player" class="rs_skip rs_preserve"></div>
<script>
    jQuery(document).ready(function() {
        var rspkrElm;
        ReadSpeaker.q(function() {
            rspkrElm = $rs.get('#listen');
            rspkr.c.addEvent('onUIShowPlayer', function() {
                rspkrElm.innerHTML = 'Sluta lyssna';
                $rs.setAttr(rspkrElm, 'onclick', 'rspkr.ui.getActivePlayer().close(); return false;');
                rspkrElm.onclick = new Function("rspkr.ui.getActivePlayer().close(); return false;");
            });
            rspkr.c.addEvent('onUIClosePlayer', function() {
                rspkrElm.innerHTML = 'Lyssna';
                $rs.setAttr(rspkrElm, 'onclick', 'readpage(this.href, "read-speaker-player"); return false;');
                rspkrElm.onclick = new Function('readpage(this.href, "read-speaker-player"); return false;');
            });
        });
    });
</script>