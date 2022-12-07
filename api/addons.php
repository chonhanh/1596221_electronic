<?php
include "config.php";

$type = (!empty($_GET["type"])) ? htmlspecialchars($_GET["type"]) : '';
?>
<?php if ($type == 'fanpage-facebook') { ?>
    <div class="fb-page" data-href="<?= $optsetting['fanpage'] ?>" data-tabs="timeline" data-width="300" data-height="215" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
        <div class="fb-xfbml-parse-ignore">
            <blockquote cite="<?= $optsetting['fanpage'] ?>">
                <a href="<?= $optsetting['fanpage'] ?>">Facebook</a>
            </blockquote>
        </div>
    </div>
<?php } ?>

<?php if ($type == 'script-main') { ?>
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.async = true;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script src="//sp.zalo.me/plugins/sdk.js"></script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55e11040eb7c994c"></script>
<?php } ?>