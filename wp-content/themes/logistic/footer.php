        <div class="clear"></div>
        
        </div><!--.container--> 
   
        <?php
            /* footer slider */
            global $ozy_data;
            ozy_put_footer_slider($ozy_data->footer_slider);

            /*footer widget bar and footer*/
            include('include/footer-bars.php');
            
            /*post side navigation bars*/
            include('include/single-post-navigation.php'); 
        ?>

        
    </div><!--#main-->

    <?php 
		if($ozy_data->is_animsition_active) echo '</div>';
		wp_footer(); 
	?>


<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter47728093 = new Ya.Metrika({
                    id:47728093,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/47728093" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


<link rel="stylesheet" href="https://cdn.envybox.io/widget/cbk.css">
<script type="text/javascript" src="https://cdn.envybox.io/widget/cbk.js?wcb_code=e9ac1113de5232970422074af500fd4a" charset="UTF-8" async></script>
 
</body>
 
</html>