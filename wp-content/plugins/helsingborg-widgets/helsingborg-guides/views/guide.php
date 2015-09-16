<?php
$guide = '<section class="guide-section">';
        $guide .= '<h2 class="section-title">' . $post->post_title . '</h2>';

        $guide .= '<div class="row"><div class="columns large-12"><ul class="guide-list">';

        if (count($article_steps_meta["guide_step"])) {
            for ($i = 0; $i < count($article_steps_meta["guide_step"]); $i++){

                if ($i == 0) {
                    $guide .= '<li class="box current">';
                } else {
                    $guide .= '<li class="box">';
                }

                if (isset($article_steps_meta["guide_step_image"][$i])){
                    $kk = wp_get_attachment_image_src( $article_steps_meta["guide_step_image"][$i], 'full', true );
                    $guide .= '<img src="'.$kk[0].'" alt="" >';
                }

                $guide .= '<h3 class="title">' . $article_steps_meta["guide_step"][$i] . ' </h3>';
                $guide .= '<div class="box-content padding-x2 description">' . wpautop($article_steps_meta["guide_step_title"][$i], true) . '';
                if (strlen($article_steps_meta["guide_note"][$i]) > 0) {
                  $guide .= '<p class="notes">' . $article_steps_meta["guide_note"][$i] . '</p>';
                }
                $guide .= '</div></li>';
            }
        }

        $guide .= '</ul></div></div>'; //<!-- /.guide-list -->

        $guide .= '<div class="row"><div class="columns large-12"><ul class="pagination" arial-label="pagination" role="menubar">';
        $guide .= '<li><a href="#" class="button radius prev-step">&laquo; ' . __(Föregående) . '</a></li>';

        for($i=0;$i<count($article_steps_meta["guide_step"]);$i++){
            $guide .= '<li' . ($i==0?' class="current-pager"':'') . '><a href="#">' . ($i+1) . '</a></li>';
        }

        $guide .= '<li><a href="#" class="button radius next-step">' . __ (Nästa) . ' &raquo;</a></li>';
        $guide .= '</ul></div></div>';
        $guide .= '</section>';