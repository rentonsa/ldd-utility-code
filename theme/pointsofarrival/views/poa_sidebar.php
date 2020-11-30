<div class="poa-sidebar">
    <!-- HOME -->
    <a href="./"><button class="non-accordion acc-btn">Home</button></a>
    <!-- INTRO/HOW TO -->
    <a href="./pointsofarrival/introduction"><button class="accordion acc-btn">Introduction</button></a>
    <a href="./pointsofarrival/introduction#howto-title"><button class="accordion acc-btn">How to use this site</button></a>
    <!-- FILMS -->
    <a href="./pointsofarrival/films"><button class="accordion acc-btn">Points of Arrival Films</button></a>
    <a href="../pointsofarrival/goldwag"><button class="accordion acc-btn">Hilda Goldwag Film</button></a>
    <a href="./pointsofarrival/hirshow"><button class="accordion acc-btn">Isaac Hirshow Film</button></a>
    <a href="./pointsofarrival/lindey"><button class="accordion acc-btn">Annie Lindey Film</button></a>
    <a href="./pointsofarrival/sim"><button class="accordion acc-btn">Dorrith Sim Film</button></a>
    <a href="./pointsofarrival/wuga"><button class="accordion acc-btn">Henry Wuga Film</button></a>
    <!-- THEMES -->
    <a href="./pointsofarrival/themes"><button class="accordion acc-btn">Full Theme List</button></a>
    <!--<a href="./pointsofarrival/adnan"><button class="accordion acc-btn">Adnan Shamdin</button></a>-->
    <a href="./pointsofarrival/antisemitism"><button class="accordion acc-btn">Antisemitism</button></a>
    <a href="./pointsofarrival/family"><button class="accordion acc-btn">Family</button></a>
    <a href="./pointsofarrival/gorbals"><button class="accordion acc-btn">The Gorbals</button></a>
    <a href="./pointsofarrival/greatmigration"><button class="accordion acc-btn">The Great Migration</button></a>
    <a href="./pointsofarrival/history"><button class="accordion acc-btn">History of Jews in Scotland</button></a>
    <a href="./pointsofarrival/arts"><button class="accordion acc-btn">Jewish Art and Artists</button></a>
    <a href="./pointsofarrival/culture"><button class="accordion acc-btn">Jewish Culture</button></a>
    <a href="./pointsofarrival/food"><button class="accordion acc-btn">Jewish Food</button></a>
    <a href="./pointsofarrival/easterneurope"><button class="accordion acc-btn">Jewish Life in Eastern Europe</button></a>
    <a href="./pointsofarrival/languages"><button class="accordion acc-btn">Jewish Languages</button></a>
    <a href="./pointsofarrival/nazigermany"><button class="accordion acc-btn">Jewish Life in Nazi Germany</button></a>
    <a href="./pointsofarrival/religion"><button class="accordion acc-btn">Jewish Religion</button></a>
    <a href="./pointsofarrival/kindertransport"><button class="accordion acc-btn">Kindertransport</button></a>
    <a href="./pointsofarrival/music"><button class="accordion acc-btn">Music as a Global Language</button></a>
    <a href="./pointsofarrival/synagoguemusic"><button class="accordion acc-btn">Synagogue Music</button></a>
    <a href="./pointsofarrival/holocaust"><button class="accordion acc-btn">War and Holocaust</button></a>
    <a href="./pointsofarrival/welfare"><button class="accordion acc-btn">Welfare</button></a>
    <!-- RESOURCES -->
    <a href="./pointsofarrival/resources"><button class="accordion acc-btn">Resources List</button></a>
</div>

<!-- Probably depricated since removal of accordion sidebar -->
<!-- Kept in just in-case it effects functionality -->
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