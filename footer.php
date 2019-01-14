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
<script async src="https://stats.lptracker.ru/code/new/58157"></script>
ation: 0c9a6f45ffe36561</body>


<meta name="yandex-verification" content="0c9a6f45ffe36561" />
</html>

<style>
@media only screen and (max-width: 1024px) {
.elementor-row {
        all: unset;
    }
}
</style>
<!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ru/stat/?id=47728093&amp;from=informer"
target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/47728093/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="47728093" data-lang="ru" /></a>
<!-- /Yandex.Metrika informer -->

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


<div class="b-popup" >
	<div class="b-popup-content" id="form-content">
		<div class="b-content-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<div class="b-content-title">Оставить заявку</div>
		</div>
		<div class="b-popup-body">
			<?php  echo do_shortcode('[contact-form-7 id="2262" title="Всплывабщая"]'); ?>
		</div>
	
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script>

$(document).ready(function(){
//закрываем, форма больше не показывается
$(".close").click(function () {
$.cookie("popup", "1", {expires: 1} ); 
$(".b-popup").fadeOut('300');
});

//если форма успешно отправлена - не показываем
document.addEventListener( 'wpcf7mailsent', function( event ) {
	$.cookie("popup", "1", {expires: 1} );
}, false );



setTimeout(function(){
		//Проверяем, если первый раз на сайте - показываем форму.
		if ( $.cookie("popup") == null )
		{
		$(".b-popup").fadeIn('300');
		$('html, body').css('height', '100%');
		$('html, body').css('margin', '0');
		$('html, body').css('padding', '0');
		$('html, body').css('overflow', 'hidden');
		$('body').css('overflow', 'auto');
		
		}
		else { $(".b-popup").hide();
		}
}, 10000);
});
    </script>


  <!-- OuiBounce Modal -->
    <div id="ouibounce-modal">
      <div class="underlay"></div>
      <div class="modal">
        <div class="modal-title">
          <h3>Уважаемый посетитель!</h3>
        </div>

        <div class="modal-body">
          <p>Мы предоставляем бесплатную доставку документации по всей России, чтобы наши клиенты не брали на себя такие расходы.</p>
 
 
        </div>

        <div class="modal-footer">
          <p>Закрыть</p>
        </div>
      </div>
    </div>

    <!-- Example page JS        -->
    <!-- Used to fire the modal -->
    <script>

      // if you want to use the 'fire' or 'disable' fn,
      // you need to save OuiBounce to an object
      var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
        aggressive: true,
        timer: 0,
        callback: function() { console.log('ouibounce fired!'); }
      });

      $('body').on('click', function() {
        $('#ouibounce-modal').hide();
      });

      $('#ouibounce-modal .modal-footer').on('click', function() {
        $('#ouibounce-modal').hide();
      });

      $('#ouibounce-modal .modal').on('click', function(e) {
        e.stopPropagation();
      });
    </script>
<!--Start of PopMechanic script-->
<script id="popmechanic-script" src="https://static.popmechanic.ru/service/loader.js?c=3934"></script>
<!--End of PopMechanic script-->
</body>

  <!-- Add OuiBounce JS -->
    <script src="http://c-qc.com/ouibounce.js"></script>

    <link rel="stylesheet" href="http://c-qc.com/ouibounce.min.css">
</html>