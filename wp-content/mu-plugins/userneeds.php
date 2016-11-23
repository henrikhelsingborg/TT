<?php

     add_action('wp_head',function(){
        if(!is_admin() && !is_user_logged_in()) {
            ?>
            <script type="text/javascript">   var _wt = '811655';
               (function () {
                   if (document.cookie.indexOf('VISITED_5449') < 0) {
                       var ws = document.createElement('script'); ws.type = 'text/javascript'; ws.async = true;
                       ws.src = ('https:' == document.location.protocol ? 'https://ssl.' : 'http://') + 'survey.webstatus.v2.userneeds.dk/wsi.ashx?t=' + _wt + (location.href.indexOf('wsiNoCookie') >= 0 ? '&nc=1' : '');
                       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ws, s);
               }})();
            </script>
            <?php
        }
     });
