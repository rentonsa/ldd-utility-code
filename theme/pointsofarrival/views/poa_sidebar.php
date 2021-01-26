<div class="poa-sidebar">
    <!-- HOME -->
    <a href="./"><button class="non-accordion acc-btn">Home</button></a>
    <!-- INTRO/HOW TO -->
    <a href="./introduction"><button class="accordion acc-btn">Information</button></a>
    <!--<div class="panel">
        <a href="./introduction"><button class="accordion acc-btn">Introduction</button></a>
        <a href="./introduction#howto-title"><button class="accordion acc-btn">How to use this site</button></a>
    </div>-->
    <!-- FILMS -->
    <a href="./films"><button class="accordion acc-btn">Points of Arrival Films</button></a>
    <!--<div class="panel">
        <a href="./films"><button class="accordion acc-btn">Full Film List</button></a>
        <a href="../goldwag"><button class="accordion acc-btn">Hilda Goldwag Film</button></a>
        <a href="./hirshow"><button class="accordion acc-btn">Isaac Hirshow Film</button></a>
        <a href="./lindey"><button class="accordion acc-btn">Annie Lindey Film</button></a>
        <a href="./sim"><button class="accordion acc-btn">Dorrith Sim Film</button></a>
        <a href="./wuga"><button class="accordion acc-btn">Henry Wuga Film</button></a>
    </div>-->
    <!-- THEMES -->
    <a href="./themes"><button class="accordion acc-btn">Themes</button></a>
    <!--<div class="panel">
        <a href="./themes"><button class="accordion acc-btn">Full Theme List</button></a>
        <a href="./adnan"><button class="accordion acc-btn">Adnan Shamdin</button></a>
        <a href="./antisemitism"><button class="accordion acc-btn">Antisemitism</button></a>
        <a href="./family"><button class="accordion acc-btn">Family</button></a>
        <a href="./gorbals"><button class="accordion acc-btn">The Gorbals</button></a>
        <a href="./greatmigration"><button class="accordion acc-btn">The Great Migration</button></a>
        <a href="./history"><button class="accordion acc-btn">History of Jews in Scotland</button></a>
        <a href="./arts"><button class="accordion acc-btn">Jewish Art and Artists</button></a>
        <a href="./culture"><button class="accordion acc-btn">Jewish Culture</button></a>
        <a href="./food"><button class="accordion acc-btn">Jewish Food</button></a>
        <a href="./easterneurope"><button class="accordion acc-btn">Jewish Life in Eastern Europe</button></a>
        <a href="./languages"><button class="accordion acc-btn">Jewish Languages</button></a>
        <a href="./nazigermany"><button class="accordion acc-btn">Jewish Life in Nazi Germany</button></a>
        <a href="./religion"><button class="accordion acc-btn">Jewish Religion</button></a>
        <a href="./kindertransport"><button class="accordion acc-btn">Kindertransport</button></a>
        <a href="./music"><button class="accordion acc-btn">Music as a Global Language</button></a>
        <a href="./synagoguemusic"><button class="accordion acc-btn">Synagogue Music</button></a>
        <a href="./holocaust"><button class="accordion acc-btn">War and Holocaust</button></a>
        <a href="./welfare"><button class="accordion acc-btn">Welfare</button></a>
    </div>-->
    <!-- RESOURCES -->
    <a href="./resources"><button class="accordion acc-btn">Resource List</button></a>
    <!-- CONTACT -->
    <a href="./contact"><button class="accordion acc-btn">Contact</button></a>
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