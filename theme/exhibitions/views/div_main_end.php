              <footer>

            <div class="footer-container">
                <ul id="footer-list-l">
                    <div class="footer-link"><li><a href="https://www.ed.ac.uk/about/website/website-terms-conditions" alt="link to terms and conditions" title="External link to the University of Edinburgh online terms and conditions" traget="_blank">Terms &amp; 
conditions</a></li></div>
                    <div class="footer-link"><li><a href="https://www.ed.ac.uk/about/website/privacy" alt="link to privacy and cookies" title="External link to the University of Edinburgh online privacy and cookies policy" traget="_blank">Privacy &amp; cookies</a
></li></div>
                    <div class="footer-link"><li><a href="<?php echo base_url(); ?>/accessibility" alt="link to website accessibilty" title="Link to website accessibility statement">Website accessibility</a></li></div>
                </ul>
                <ul id="footer-list-r">
                    <div class="footer-link"><li><a href="https://www.myed.ed.ac.uk/" alt="link to myed login" title="External link to the University of Edinburgh Ease login page" traget="_blank"><span class="glyphicon glyphicon-log-in"></span>MyEd Login</a></li>
</div>
                </ul>
            </div>

            <!-- Custom scripts called in footer for on-load execution -->
            <!-- OPENING TIMES SCRIPTS -->
            <script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/openingtimes.js"></script>
            <!-- GOOGLE MAPS SCRIPTS -->
            <script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/googlemaps.js"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA29rpRdgUXPQoVfAhO5KlO4cV55CMSMi0&callback=initMap" async defer></script>

            <!-- SKROLLR SCRIPTS FOR PARALLAX SCROLLING FUNCTIONALITY -->
            <!-- * Must be called within page <body> tags to function -->
            <script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/skrollr.min.js"></script>
            <script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/skrollr.menu.js"></script>
            <script type="text/javascript">
                var s = skrollr.init();
                skrollr.menu.init(s, {
                    animate: true,
                    scale: 2,
                    duration: function(currentTop, targetTop) {
                    return 250;
                    return Math.abs(currentTop - targetTop) * 40;
                    },
                });
            </script>
            <!-- OTHER PARALLAX RELATED SCRIPTS -->
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <script src="http://cdn.tutorialzine.com/misc/enhance/v2.js" async></script>

            <script>
                var acc = document.getElementsByClassName("accordion");
                var i;

                for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    if (panel.style.display === "block") {
                    panel.style.display = "none";
                    } else {
                    panel.style.display = "block";
                    }
                });
                }
            </script>


        </footer>

        
    </div>
    </div>
    </div>
            </div>