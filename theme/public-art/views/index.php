<div class="content">
    <!-- todo replace two with sass or less -->
<div class="home">
    <!--to have images set up-->
    <ul class="cb-slideshow">
        <li><span></span><div><h3></h3></div></li>
        <li><span></span></li>
        <li><span></span></li>
        <li><span></span></li>
    </ul>
    <div class="text-center home-search-buttons col-xs-12">
        <a href= "./search/*:*/" class="home-search col-xs-4">
            <i class="fa fa-search" aria-hidden="true"></i><br>
            Search art on campus
        </a>
        <a href= "./search/*:*/?map=true" class="home-search col-xs-4">
            <i class="fa fa-search" aria-hidden="true"></i><br>
            View by location
        </a>
        <a href="./paolozzi" class="home-search col-xs-4">
            <i class="fa fa-info" aria-hidden="true"></i><br>
            Paolozzi Mosaic Project
        </a>
    </div>

</div>


    <script>
        $(function () {
            $(window).on("scroll", function () {
                if ($(window).scrollTop() > 50) {
                    $(".navbar").addClass("active");
                } else {
                    $(".navbar").removeClass("active");
                }
            });
        });
    </script>
