<div class="poa-sidebar">
    <!-- HOME -->
    <a href="./"><button class="non-accordion">Home</button></a>
    <!-- INTRO/HOW TO -->
    <a href="./introduction"><button class="accordion">Introduction</button></a>
    <a href="./introduction#howto-title"><button class="accordion">How to use this site</button></a>
    <!-- FILMS -->
    <a href="./films"><button class="accordion">Points of Arrival Films</button></a>
    <a href="../goldwag"><button class="accordion">Hilda Goldwag Film</button></a>
    <a href="./hirshow"><button class="accordion">Isaac Hirshow Film</button></a>
    <a href="./lindey"><button class="accordion">Annie Lindey Film</button></a>
    <a href="./sim"><button class="accordion">Dorrith Sim Film</button></a>
    <a href="./wuga"><button class="accordion">Henry Wuga Film</button></a>
    <!-- THEMES -->
    <a href="./themes"><button class="accordion">Full Theme List</button></a>
    <a href="./adnan"><button class="accordion">Adnan Shamdin</button></a>
    <a href="./antisemitism"><button class="accordion">Antisemitism</button></a>
    <a href="./family"><button class="accordion">Family</button></a>
    <a href="./gorbals"><button class="accordion">The Gorbals</button></a>
    <a href="./greatmigration"><button class="accordion">The Great Migration</button></a>
    <a href="./history"><button class="accordion">History of Jews in Scotland</button></a>
    <a href="./arts"><button class="accordion">Jewish Art and Artists</button></a>
    <a href="./culture"><button class="accordion">Jewish Culture</button></a>
    <a href="./food"><button class="accordion">Jewish Food</button></a>
    <a href="./easterneurope"><button class="accordion">Jewish Life in Eastern Europe</button></a>
    <a href="./languages"><button class="accordion">Jewish Languages</button></a>
    <a href="./nazigermany"><button class="accordion">Jewish Life in Nazi Germany</button></a>
    <a href="./religion"><button class="accordion">Jewish Religion</button></a>
    <a href="./kindertransport"><button class="accordion">Kindertransport</button></a>
    <a href="./music"><button class="accordion">Music as a Global Language</button></a>
    <a href="./synagoguemusic"><button class="accordion">Synagogue Music</button></a>
    <a href="./holocaust"><button class="accordion">War and Holocaust</button></a>
    <a href="./welfare"><button class="accordion">Welfare</button></a>
    <!-- RESOURCES -->
    <a href="./resources"><button class="accordion">Resources List</button></a>
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