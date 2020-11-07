<div class="poa-sidebar">
    <a href="./"><button class="non-accordion">Home</button></a>
    <!--<div class="panel"> 
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>-->

    <button class="accordion">Introduction</button>
    <div class="panel">
        <a href="./introduction"><p>Introduction</p></a>
        <a href="./introduction#howto-title"><p>How to use this site</p></a>
    </div>

    <button class="accordion">Points of Arrival Films</button>
    <div class="panel">
        <a href="./films"><p>Full Catalogue</p></a>
        <a href="./goldwag"><p>Hilda Goldwag</p></a>
        <a href="./hirshow"><p>Isaac Hirshow</p></a>
        <a href="./lindey"><p>Annie Lindey</p></a>
        <a href="./sim"><p>Dorrith Sim</p></a>
        <a href="./wuga"><p>Henry Wuga</p></a>
    </div>

    <button class="accordion">Themes</button>
    <div class="panel">
        <a href="./themes"><p>Full Theme List</p></a>
        <a href="./adnan"><p>Adnan Shamdin</p></a>
        <a href="./antisemitism"><p>Antisemitism</p></a>
        <a href="./family"><p>Family</p></a>
        <a href="./gorbals"><p>The Gorbals</p></a>
        <a href="./greatmigration"><p>The Great Migration</p></a>
        <a href="./history"><p>History of Jews in Scotland</p></a>
        <a href="./arts"><p>Jewish Art and Artists</p></a>
        <a href="./culture"><p>Jewish Culture</p></a>
        <a href="./food"><p>Jewish Food</p></a>
        <a href="./easterneurope"><p>Jewish Life in Eastern Europe</p></a>
        <a href="./languages"><p>Jewish Languages</p></a>
        <a href="./nazigermany"><p>Jewish Life in Nazi Germany</p></a>
        <a href="./religion"><p>Jewish Religion</p></a>
        <a href="./kindertransport"><p>Kindertransport</p></a>
        <a href="./music"><p>Music as a Global Language</p></a>
        <a href="./synagoguemusic"><p>Synagogue Music</p></a>
        <a href="./holocaust"><p>War and Holocaust</p></a>
        <a href="./welfare"><p>Welfare</p></a>
    </div>

    <button class="accordion">Resources</button>
    <div class="panel">
        <a href="./resources"><p>Full Resource List</p></a>
        <a href="./resources#learning"><p>My Jewish Learning</p></a>
        <a href="./resources#viruallibrary"><p>Jewish Virtual Library</p></a>
        <a href="./resources#virtualshetl"><p>Virtual Shetl</p></a>
        <a href="./resources#synagogues"><p>Synagogues Around the World</p></a>
        <a href="./resources#holocaustexplained"><p>The Holocaust Explained</p></a>
        <a href="./resources#holocaustencyclopedia"><p>Holocaust Encyclopedia</p></a>
        <a href="./resources#migration"><p>Migration Museum</p></a>
        <a href="./resources#artmusicculture"><p>Jewish Art, Music, and Culture</p></a>
        <a href="./resources#scotland"><p>Focus on Scotland</p></a>
    </div>
</div>

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