    <!-- PARALLAX SCROLL BODY -->
    <!-- Contains the content of the different information blocks -->
    <div id="skrollr-body">

        <!-- GAP DIVS ENFORCE "BACKGROUND" SPACE FOR IMAGES -->
        <div id="page-gap" class="gap">
 
            <!-- MAIN UNIVERSITY LOGO -->
            <div id="#home-anchor" class="logo-container">
                <a href="<?php base_url() ?>" alt="Home button to return you to library exhibitions home page">
                    <img id="top-nav" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/uofe_logo.png" alt="University of Edinburgh Logo" title="Link to University of Edinburgh Library Exhibitions Home Page">
                </a>
            </div>

            <!-- STATIC NAVIGATION BAR TEMPLATE -->
            <div id="top-nav" class="nav-container">
                <ul>
                    <div class="smol"><a class="nav-link" href="#visit-anchor" alt="Jump to visit us section" title="Jump to visit us section"><li>Visit Us</li></a></div>
                    <div><a class="nav-link" href="#exhibitions-anchor" alt="Jump to exhibitions section" title="Jump to exhibitions section"><li>Exhibitions</li></a></div>
                    <div class="smol"><a class="nav-link" href="#events-anchor" alt="Jump to events section" title="Jump to events section"><li>Events</li></a></div>
                    <div><a class="nav-link" href="#support-anchor" alt="Jump to support us section" title="Jump to support us section"><li>Support Us</li></a></div>
                </ul>
            </div>
            

            <!-- HEADER FOR NEXT BLOCK MAINTAINED INSIDE PREVIOUS PAGE GAP -->
            <!-- Header ids also used for 'jumps' to blocks throughout site -->
            <div class="block-title">
                <h1 id="home" class="block-title-head" alt="Library Exhibitions main title">Library Exhibitions</h1>
            </div>

        </div>
    
        <!-- PARALLAX (SCROLLING) BLOCKS -->
        <!-- Contain the content for each block/section of the page 
            * to be update for new exhibitions or information changes -->

        <!-- WELCOME BLOCK -->
        <div id="block-one" class="body-text content">

            <!-- SECTION CONTAINER -->
            <div id="welcome-container" class="exhibition-container" alt="Welcome section">

                <!-- SECTION LOGO -->
                <div id="exhibit-logo">         
                    <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/discover_ed_logo.png" alt="University of Edinurgh Library Discovery Logo" title="University of Edinurgh Library Discovery Logo">
                </div>

                <!-- SECTION INFO -->
                <div id="info-container" class="exhibit-info">
                    <h2 class="right-align-h" alt="welocme statement">Welcome to the University of Edinburgh Library Exhibitions</h2>

                    <p class="right-align-p" alt="description of collections">                       
                        From meteorites, to World War II escape maps, rare books, anatomical specimens, and contemporary art, our exciting exhibition programme showcases the University’s vast and varied heritage collections<br>    
                    </p>
                    <p id="link-p" class="right-align-p" alt="description of collections">
                        If you would like find out more about the University’s collections, please visit the <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc" alt="Link to the University of Edinburgh's Centre for Research Collection site" title="External link to the University of Edinburgh's Centre for Research Collection site" target="_blank">Centre for Research Collections</a>
                    </p>

                    <div class="image-box-xtra-smol">
                        <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/current_exhibition_logo.png" alt="Current main exhibition logo" title="current exhibtion logo">
                    </div>

                    <p class="right-align-p" alt="Current main exhibition title">
                    CURRENT EXHIBITION: BODY LANGUAGE                      
                    </p>

                    <!-- OPENING TIMES FOR TODAY -->
                    <!-- generated using javascript file "openingtimes.js" -->
                    <p id="opening-times" class="right-align-p" alt="Library opening times for today">
                    </p>

                    <!-- SECTION BUTTONS -->
                    <div id="quick-links">
                        <a href="#events-anchor" alt="Jump to events section" title="Jump to events section" alt="Link to upcoming events section" title="Link to upcoming events section">
                            <button id="" class="exhibit-button">
                                <p>Upcoming Events</p>
                            </button>
                        </a>
                        <a href="#current-exhibition-anchor" alt="Link to current main exhibition" title="Link to current main exhibition section">
                            <button id="quick-button" class="exhibit-button">
                                <p>Current Exhibition</p>
                            </button>
                        </a>
                    </div>

                </div>
            </div>

        </div>

        <div id="page-gap" class="gap">

            <!-- BLOCK ANCHOR -->
            <div class="index-anchor" id="visit-anchor"></div>

            <!-- ANIMATED NAVIGATION BAR TEMPLATE -->
            <!-- * only used for blocks that are scrolled over -->
            <div class="nav-container" data-100-bottom-top="transform: translateY(-500px); opacity: -10" data-center-top="transform: translateX(0px); opacity: 1">
                <ul>
                    <div class="smol"><a class="nav-link" href="#visit-anchor" alt="Jump to visit us section" title="Jump to visit us section"><li>Visit Us</li></a></div>
                    <div><a class="nav-link" href="#exhibitions-anchor" alt="Jump to exhibitions section" title="Jump to exhibitions section"><li>Exhibitions</li></a></div>
                    <div class="smol"><a class="nav-link" href="#events-anchor" alt="Jump to events section" title="Jump to events section"><li>Events</li></a></div>
                    <div><a class="nav-link" href="#support-anchor" alt="Jump to support us section" title="Jump to support us section"><li>Support Us</li></a></div>
                    <div><a class="nav-link" href="#home-anchor" alt="Jump to top of page" title="jump back to the top of the page"><li>Back to Top</li></a></div>
                </ul>
            </div>

            <!-- BLOCK TITLE -->
            <div class="block-title">
                <h1 class="block-title-head" alt="Visit us section title">Visit Us</h1>
            </div>

        </div>

        <!-- VISIT US BLOCK -->
        <div id="block-two" class="body-text content">
            
            <div id="visit-container" data-100-bottom-top="transform: translateY(150px); opacity: 0" data-center-top="transform: translateY(0px); opacity: 1">

                <!-- OPENING TIMES -->      
                <div class="visit-block" alt="Main library Opening times">
                    <p id="visit-main" class="left-align-p">                       
                        FREE ADMISSION<br/>
                        <!--OPEN TO ALL<br/>-->
                    </p>
                    <p id="visit-main-2" class="left-align-p" alt="exhibition space accessibility">
                        OPEN TO ALL
                    </p>
                    <img id="open" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/open.png" alt="Opening times icon" title="Opening times icon">
                    <p id="visit-first" class="left-align-p" id="opening" alt="opening times for main library exhibition gallery">   
                        Monday to Saturday<br/> 
                        10am - 5pm<br/> 
                    </p>
                    <img id="wheelchair" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/wheelchair.png" alt="Wheelchair access icon" title="Wheelchair access icon">
                    <p id="visit-second" class="left-align-p" alt="Wheelchair access details" alt="Wheelchair access details for main library exhibition gallery">
                        Wheelchair accessible via ramp at front of the building. Push pad door entry.
                    </p>
                </div>

                <!-- LIBRARY FACILITIES -->
                <div class="visit-block" alt="Main library facilities">
                    <p id="visit-main" class="left-align-p" >                       
                        FACILITIES<br/>
                    </p>
                    <img id="cafe" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/cafe.png" alt="Cafe icon" title="Cafe icon"> 
                    <p id="visit-first" class="left-align-p">                           
                        The Library Café is accessed to the right of the building's main entrance. 
                    </p>
                    <img id="toilet" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/toilet.png" alt="Toilets icon" title="Toilet facilities icon">
                    <p id="visit-second" class="left-align-p"> 
                        Toilets, including accessible toilets, are located in the Library café. Term time Monday to Sunday. Non term time Monday to Friday.
                    </p>
                </div>

                <!-- LIBRARY EXHIBITIONS SPACE LOCATION -->
                <div class="visit-block" id="address" alt="Main library location details">
                    <p id="visit-main" class="left-align-p" >                       
                        HOW TO FIND US<br/>
                    </p>
                    <img id="floor" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/location.png" alt="Map location icon" title="Location pon icon">
                    <p id="visit-first" class="left-align-p" alt="Main library exhibition gallery address">
                        Ground Floor<br/>
                        University of Edinburgh<br>
                        Main Library<br/>                          
                        30 George Square<br/>
                        Edinburgh<br> 
                        EH8 9LJ 
                    </p>
                </div>

                <!-- CONTACT DETAILS -->
                <div class="visit-block" id="contact" alt="Main library contact details">
                    <p id="visit-main" class="left-align-p" >                       
                        CONTACT US<br/>
                    </p>
                    <img id="email" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/email.png" alt="Email icon" title="Email icon">
                    <p id="visit-first-email" class="left-align-p">
                        <a id="email-link" href="mailto: museums@ed.ac.uk" title="click to email library exhibtions" target="_blank">museums@ed.ac.uk</a><br/>
                    </p>
                    <img id="phone" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/phone.png" alt="Phone icon" title="Phone icon">
                    <p id="visit-second-phone" class="left-align-p" alt="library phone number" title="click to call library exhibitions">                             
                        <a id="email-link" href="tel:(0131) 650 2600" aria-label="(0 1 3 1) 0 5 0 2 6 0 0">(0131) 650 2600</a><br>(Tueday to Saturday) 
                    </p>

                </div>

                <!-- GOOGLE MAPS API DIV -->
                <!-- generated by javascript "googlemaps.js" -->
                <div id="google-map" alt="Interactive Google Map" title="Interactive Google Map"></div>
            </div>
               
        </div>

        <!-- BLOCK GAP -->
        <div id="page-gap" class="gap">

            <!-- BLOCK ANCHOR -->
            <div class="index-anchor" id="exhibitions-anchor"></div>
        
            <!-- ANIMATED NAVIGATION BAR -->
            <div class="nav-container" data-100-bottom-top="transform: translateY(-500px); opacity: -10" data-center-top="transform: translateX(0px); opacity: 1">
                <ul>
                    <div class="smol"><a class="nav-link" href="#visit-anchor" alt="Jump to visit us section" title="Jump to visit us section"><li>Visit Us</li></a></div>
                    <div><a class="nav-link" href="#exhibitions-anchor" alt="Jump to exhibitions section" title="Jump to exhibitions section"><li>Exhibitions</li></a></div>
                    <div class="smol"><a class="nav-link" href="#events-anchor" alt="Jump to events section" title="Jump to events section"><li>Events</li></a></div>
                    <div><a class="nav-link" href="#support-anchor" alt="Jump to support us section" title="Jump to support us section"><li>Support Us</li></a></div>
                    <div><a class="nav-link" href="#home-anchor" alt="Jump to top of page" title="jump back to the top of the page"><li>Back to Top</li></a></div>
                </ul>
            </div>

            <!-- BLOCK TITLE -->
            <div class="block-title">
                <h1  class="block-title-head" alt="Library exhibitions title">Exhibitions</h1>
            </div>
    
        </div>

        <!-- EXHIBITION BLOCK -->
        <div id="block-three" class="body-text content">

            <!-- SECTION TITLE -->
            <h1 id="current-exhibitions" class="left-align-h1" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">Current Exhibition</h1>

            <!-- SECTION CONTAINER -->
            <div class="exhibition-container">

                <!-- SECTION LOGO -->
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">         
                    <a>
                        <div class="image-box" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/current_exhibition_logo.png" alt="Current main library exhibition logo" title="Body Language logo">
                        </div>
                    </a>
                </div>

                <!-- SECTION INFO -->
                <div id="info-container" class="exhibit-info" data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <div class="anchor" id="current-exhibition-anchor" ></div>
                    <h2 class="right-align-h" alt="current main exhibition title">Body Language</h2>

                    <p class="right-align-p" alt="current main exhibition description">                       
                        Delve into the archives of Dunfermline College of Physical Education, Scottish Gymnastics, and the influential dance pioneer Margaret Morris (1891-1980), and discover Scotland’s significant contributions to movement and dance
                    </p>

                    <p id="info-gap" class="right-align-p" alt="current main exhibition location">                       
                        MAIN LIBRARY EXHIBITION GALLERY<br>
                        GROUND FLOOR
                    </p>
                    <p class="right-align-p" alt="current main exhibition open dates">
                        26 JULY 2019 - 26 OCTOBER 2019
                    </p>
                    <p class="right-align-p" id="last-p" alt="current main exhibition opening times">
                        MONDAY to SATURDAY 10:00 - 17:00 (Plus Sundays Throughout August)
                    </p>

                    <!-- BUTTON TO CURRENT EXHIBITION COLLECTION -->
                    <!-- * commented out as none exists currently -->
                    <!--<a id="info-gap" href="<?php base_url()?>bodylanguage">
                        <button class="exhibit-button">
                            <p>View Exhibition</p>
                        </button>
                    </a>-->

                    <!-- SECTION ADDITIONAL LOGOS -->
                    <img class="associated-logo" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/welcome-trust-logo-long.png" alt="The Welcome Trust Logo" title="The Welcome Trust Logo">
                    <img class="associated-logo" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/fringe-logo-white.png" alt="Edinburgh Fringe Festival Logo" title="Edinburgh Fringe Festival Logo">
                    <img class="associated-logo" id="pandk" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/culture-perth-kinross-logo.png" alt="Culture: Perth and Kinroos Logo" title="Culture: Perth and Kinroos Logo">

                </div>
                    
            </div>

            <!-- SECTION DIVIDER -->
            <div id="past-container" class="divider" data-100-bottom-top="transform: translateY(0px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1"></div>

            <!-- SECTION TITLE --> 
            <h1 id="coming-exhibitions" class="left-align-h1" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1" alt="exhibitons coming soon">Coming Soon</h1>

            <!-- SECTION CONTAINER -->
            <div class="exhibition-container">

                <!-- SECTION LOGO -->
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                    <a>
                        <div class="image-box" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/box_2.png" alt="Forthcoming Exhibit logo" title="Embroidered Stories logo">
                        </div>
                    </a>
                </div>

                <!-- SECTION INFO -->
                <div id="coming-exhibit-info" >
                    <div data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                        <h2 class="right-align-h" alt="forthcoming exhibition title">
                            Embroidered Stories
                        </h2>
            
                        <p class="right-align-p" alt="forthcoming exhibition description">                       
                            Come and discover the University’s Needlework Development Scheme (NDS), an unique group of 17th-20th century textiles from around the world. 
                            Discover how the pieces have inspired students at ECA for generations and how they are now being revitalised through digital technologies and community engagement. 
                            Get hands-on with the specially created handling samples and feel the stitches get under your fingers.
                        </p>
                        <br>
                        <p class="right-align-p" alt="forthcoming exhibition description continued"> 
                            Explore this collection at Edinburgh College of Art’s <strong><a href="https://embroideredstories.eca.ed.ac.uk/" alt="link to forthcoming exhibition contributors external website" title="External link Edinburgh College of Art’s Embroided Stories extenal collection website" target="_blank">Embroidered Stories Collection</a></strong>
                        </p> 

                        <p id="info-gap" class="right-align-p" alt="forthcoming exhibition location">                       
                            MAIN LIBRARY EXHIBITION GALLERY<br>
                            GROUND FLOOR 
                        </p>
                        <p class="right-align-p" alt="forthcoming exhibition open dates">
                            29 NOVEMBER 2019 – 29 FEBUARY 2020
                        </p>
                        <p class="right-align-p" alt="forthcoming exhibition opening times">
                            MONDAY to SATURDAY 10:00 - 17:00
                        </p>

                        <!-- BUTTON TO CURRENT EXHIBITION COLLECTION -->
                        <!-- * commented out as none exists currently -->
                        <!--<a id="info-gap" href="https://embroideredstories.eca.ed.ac.uk/">
                            <button class="exhibit-button">
                                <p>View Exhibition</p>
                            </button>
                        </a>-->

                    </div>
                </div>
            </div>

            <!-- SECTION DIVIDER -->
            <div id="past-container" class="divider" data-100-bottom-top="transform: translateY(0px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1"></div>

            <!-- SECTION CONTAINER -->
            <div class="exhibition-container" id="exhibition-divide">

                <!-- SECTION LOGO -->
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                    <a>
                        <div class="image-box" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/box_3.png" alt="Forthcoming Exhibit logo" title="Lu Xun: A Legacy In Print logo">
                        </div>
                    </a>
                </div>

                <!-- SECTION INFO -->
                <div id="coming-exhibit-info" >
                    <div data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                        <h2 class="right-align-h" alt="forthcoming exhibition title">
                            Lu Xun: A Legacy In Print
                        </h2>
            
                        <p class="right-align-p" alt="forthcoming exhibition description">                       
                            Lu Xun (1881-1936) is the pen name of the revolutionary Chinese writer Zhou Shuren. A leading left-wing printmaker and writer, Lu Xun was a passionate critic of the cultural and political conditions in 20th century China. 
                            Drawn from the collections of the Muban Educational Trust, this travelling exhibition will explore Lu Xun’s revolutionary woodcuts, the marked difference between prints made for propaganda and those for ‘art’s sake’, 
                            Lu Xun’s  technical and stylistic influence, and prints made from the 1950s to present day
                        </p>
                        <br>
                        <p class="right-align-p" alt="forthcoming exhibition description continued">                       
                            Courtesy of the <a href="http://mubaneducationaltrust.org/" alt="link to forthcoming exhibition contributors website" title="External link to Muban Educational Trust website" target="_blank">Muban Educational Trust</a>.
                        </p>
                        <p id="info-gap" class="right-align-p" alt="forthcoming exhibition location">                       
                            MAIN LIBRARY EXHIBITION GALLERY<br>
                            GROUND FLOOR 
                        </p>
                        <p class="right-align-p" alt="forthcoming exhibition dates">
                            APRIL - SEPTEMBER 2020
                        </p>
                        <p class="right-align-p" id="last-p" alt="forthcoming exhibition opening times">
                            MONDAY to SATURDAY 10:00 - 17:00
                        </p>

                        <!-- SECTION ADDITIONAL LOGOS -->
                        <img class="associated-logo" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/muban-trust-logo.png" alt="Muban Trust Logo" title="Muban Trust Logo">

                    </div>

                </div>
            </div>

            <!-- SECTION DIVIDER -->
            <div id="past-container" class="divider" data-100-bottom-top="transform: translateY(0px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1"></div>

            <!-- SECTION TITLE -->
            <h1 id="coming-exhibitions" class="left-align-h1" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1" alt="past exhibitions section">Past Exhibitions</h1>

            <!-- SECTION CONTAINER -->
            <div id="past-container">

                                                          
                <div  data-100-bottom-top="transform: translateY(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">

                    <!-- SECTION LOGOS --> 
                    <div id="smol-image-block" >
                        <div class="image-box-smol" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/past_1.jpg" alt="Highlands to Hindustan Exhibit logo" title="Highlands to Hindustan Exhibit logo">
                        </div>
                        <div class="image-box-smol" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/past_2.jpg" alt="Towards Dolly Exhibit logo" title="Towards Dolly Exhibit logo">
                        </div>
                        <div class="image-box-smol" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/past_3.jpg" alt="Rashid-al-Din Exhibit logo" title="Rashid-al-Din Exhibit logo">
                        </div>
                        <div class="image-box-smol" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/past_4.jpg" alt="Emma Gillies Exhibit logo" title="Emma Gillies Exhibit logo">
                        </div>
                        <span class="stretch"></span>
                    </div>

                    <!-- SECTION INFO -->
                    <div id="smol-text-block" >
                        <div class="text-box-smol">
                            <h3 class="past-exhibit-h" alt="past exhibition title">Highlands to Hindustan</h3>
                            <p class="past-exhibit-p" alt="past exhibition dates">Jul 2017 - Nov 2017</p>
                            <a href="./highlandstohindustan"><button id="past-button" class="exhibit-button" alt="link to past exhibition details" title="link to Highlands to Hindustan exhibition page">
                                <p>View Exhibition</p>
                            </button></a>
                        </div>
                        <div class="text-box-smol">
                            <h3 class="past-exhibit-h" alt="past exhibition title">Towards Dolly</h3>
                            <p class="past-exhibit-p" alt="past exhibition dates">Nov 2017 - Mar 2018</p>
                            <a href="./towardsdolly"><button id="past-button" class="exhibit-button" alt="link to past exhibition details" title="link to Towards Dolly exhibition page">
                                <p>View Exhibition</p>
                            </button></a>
                        </div>
                        <div class="text-box-smol">
                            <h3 class="past-exhibit-h" alt="past exhibition title">Rashid-al-Din</h3>
                            <p class="past-exhibit-p" alt="past exhibition dates">Jan 2017 - Aug 2017</p>
                            <a href="./rashid"><button id="past-button" class="exhibit-button" alt="link to past exhibition details" title="link to Rashid-al-Din exhibition page">
                                <p>View Exhibition</p>
                            </button></a>
                        </div>
                        <div class="text-box-smol">
                            <h3 class="past-exhibit-h" alt="past exhibition title">Emma Gillies</h3>
                            <p class="past-exhibit-p" alt="past exhibition dates">Dec 2014 - Mar 2015</p>
                            <a href="./emmagillies"><button id="past-button" class="exhibit-button" alt="link to past exhibition details" title="link to Emma Gillies exhibition page">
                                <p>View Exhibition</p>
                            </button></a>
                        </div>
                        <span class="stretch"></span>
                    </div>
                </div>

            </div>

            <!-- BUTTON TO PAST EXHIBITIONS COLLECTION -->
            <div id="past-icon" class="past-icon">
                <a href="<?php base_url()?>past" alt="link to full list of past exhibitions" title="Link to view a list off all past exhibitions">
                    <img id="past-link" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/list.png" alt="list icon">
                    <p class="left-align-p">View the full past exhibitions list</p>
                </a>
            </div>
    
        </div>

        <!-- BLOCK GAP -->
        <div id="page-gap" class="gap">

            <!-- BLOCK ANCHOR -->
            <div class="index-anchor" id="events-anchor"></div>
        
            <!-- ANIMATED NAVIGATION -->
            <div class="nav-container" data-100-bottom-top="transform: translateY(-500px); opacity: -10" data-center-top="transform: translateX(0px); opacity: 1">
                <ul>
                    <div class="smol"><a class="nav-link" href="#visit-anchor" alt="Jump to visit us section" title="Jump to visit us section"><li>Visit Us</li></a></div>
                    <div><a class="nav-link" href="#exhibitions-anchor" alt="Jump to exhibitions section" title="Jump to exhibitions section"><li>Exhibitions</li></a></div>
                    <div class="smol"><a class="nav-link" href="#events-anchor" alt="Jump to events section" title="Jump to events section"><li>Events</li></a></div>
                    <div><a class="nav-link" href="#support-anchor" alt="Jump to support us section" title="Jump to support us section"><li>Support Us</li></a></div>
                    <div><a class="nav-link" href="#home-anchor" alt="Jump to top of page" title="jump back to the top of the page"><li>Back to Top</li></a></div>
                </ul>
            </div>

            <!-- BLOCK TITLE -->
            <div class="block-title">
                <h1 class="block-title-head" alt="Library events title">Events</h1>
            </div>
    
        </div>

        <!-- EVENTS BLOCK -->
        <div id="block-four" class="body-text content">

            <!-- SECTION TITLE -->
            <h1 id="current-exhibitions" class="left-align-h1" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">Current Events</h1>

            <!-- SECTION CONTAINER -->
            <div class="exhibition-container">

                <!-- SECTION LOGO -->
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">         
                    <a href="https://test.exhibitions.ed.ac.uk/conectando">
                        <div class="image-box" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/current_exhibition_logo.png" alt="Current main library exhibition logo" title="Body Language logo">
                        </div>
                    </a>
                </div>

                <!-- SECTION INFO -->
                <div id="info-container" class="exhibit-info" data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <div class="anchor" id="current-exhibition-anchor" ></div>
                    <h2 class="right-align-h" alt="current main exhibition title">Body Language: Exhibition Tours </h2>

                    <p class="right-align-p" alt="current main exhibition description">                       
                        JJoin our exhibitions officer for a tour of Body Language. Featuring gym wear, films, photographs and trophies, this display explores the pioneering role women play in Scotland’s physical education and dance.
                    </p>

                    <p id="info-gap" class="right-align-p" alt="current main exhibition location">                       
                            EXHIBITION GALLERY<br>
                            GROUND FLOOR, MAIN LIBRARY<br>
                    </p>
                    <br>
                    <p class="right-align-p" alt="current main exhibition dates">
                        7 AUGUST 2019 15:00  |  14 AUGUST 2019 14:00  |  21 AUGUST 2019 14:00  |  27 AUGUST 2019 14:00<br>
                        <br>
                        10 SEPTEMBER 2019 14:00 | 11 SEPTEMBER 2019 14:00 | 13 SEPTEMBER 2019 14:00<br>
                        <br>
                        16 OCTOBER 2019 14:00<br>
                        <br>
                        FREE ENTRY
                    </p>

                    <!-- BUTTON TO CURRENT EXHIBITION COLLECTION -->
                    <!-- * commented out as none exists currently -->
                    <a id="info-gap" href="<?php base_url()?>bltoursevent" alt="Link to view full event details" title="Link to view full event details">
                        <button class="exhibit-button">
                            <p>View Event</p>
                        </button>
                    </a>

                </div>
                    
            </div>

            <!-- SECTION DIVIDER -->
            <div id="past-container" class="divider" data-100-bottom-top="transform: translateY(0px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1"></div>

            <!-- SECTION CONTAINER -->
            <div class="exhibition-container">

                <!-- SECTION LOGO -->
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">         
                    <a href="https://test.exhibitions.ed.ac.uk/conectando">
                        <div class="image-box" id="event-divide" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/current_exhibition_logo.png" alt="Current main library exhibition logo" title="Body Language logo">
                        </div>
                    </a>
                </div>

                <!-- SECTION INFO -->
                <div id="info-container" class="exhibit-info" data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <div class="anchor" id="current-exhibition-anchor" ></div>
                    <h2 class="right-align-h" id="event-divide" alt="current main exhibition title">Body Language: Design Your Own Gym Wear </h2>

                    <p class="right-align-p" alt="current main exhibition description">                       
                        From heavy calico dresses worn with woolen tights to spandex and lyrca, women’s gym wear has certainly changed over the last century! Delve into the archives of Dunfermline College of Physical Education, Scottish Gymnastics, and the dancer Margaret Morris, to discover the different trends of the 20th century before taking to the coloured pens and paper to create your own gym-ready trend!
                    </p>

                    <p id="info-gap" class="right-align-p" alt="current main exhibition location">                       
                        MAIN LIBRARY<br>
                    </p>
                    <br>
                    <p class="right-align-p" alt="current main exhibition dates">
                        6 SEPTEMBER 2019 14:00 - 16:00<br>
                        <br>
                        2 OCTOBER 2019 14:00 - 16:00<br>
                        <br>
                        FREE ENTRY
                    </p>

                    <!-- BUTTON TO CURRENT EXHIBITION COLLECTION -->
                    <a id="info-gap" href="<?php base_url()?>gymwearevent" alt="Link to view full event details" title="Link to view full event details">
                        <button class="exhibit-button">
                            <p>View Event</p>
                        </button>
                    </a>

                </div>
            </div>

            <!-- SECTION DIVIDER -->
            <div id="past-container" class="divider" data-100-bottom-top="transform: translateY(0px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1"></div>

            <!-- SECTION CONTAINER -->
            <div class="exhibition-container">

                <!-- SECTION LOGO -->
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">         
                    <a href="https://test.exhibitions.ed.ac.uk/conectando">
                        <div class="image-box" id="event-divide" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/current_exhibition_logo.png" alt="Current main library exhibition logo" title="Body Language logo">
                        </div>
                    </a>
                </div>

                <!-- SECTION INFO -->
                <div id="info-container" class="exhibit-info" data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <div class="anchor" id="current-exhibition-anchor" ></div>
                    <h2 class="right-align-h" id="event-divide" alt="current main exhibition title">The Dancer & the Gymnast</h2>

                    <p class="right-align-p" alt="current main exhibition description">                       
                    In this talk, Richard Emerson examines how the dancer, Margaret Morris transformed her London stage school into a worldwide movement promoting the remedial benefits of dance and exercise.
                    </p>
                    <br>
                    <p class="right-align-p" alt="current main exhibition dates">
                        CENTRE FOR RESEARCH COLLECTIONS<br>
                        <br>
                        6TH FLOOR, MAIN LIBRARY<br>
                        <br>
                        24 OCTOBER 2019 12:30 - 13:30 <br>
                        <br>
                        FREE ENTRY
                    </p>

                    <!-- BUTTON TO CURRENT EXHIBITION COLLECTION -->
                    <!-- * commented out as none exists currently -->
                    <a id="info-gap" href="<?php base_url()?>dancergymnastevent" alt="Link to view full event details" title="Link to view full event details">
                        <button class="exhibit-button">
                            <p>View Event</p>
                        </button>
                    </a>

                </div>
                    
            </div>

            <!-- SECTION DIVIDER -->
            <div id="past-container" class="divider" data-100-bottom-top="transform: translateY(0px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1"></div>

            <!-- SECTION CONTAINER -->
            <div class="exhibition-container">

                <!-- SECTION LOGO -->
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">         
                    <a href="https://test.exhibitions.ed.ac.uk/conectando">
                        <div class="image-box" id="event-divide" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/current_exhibition_logo.png" alt="Current main library exhibition logo" title="Body Language logo">
                        </div>
                    </a>
                </div>

                <!-- SECTION INFO -->
                <div id="info-container" class="exhibit-info" data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <div class="anchor" id="current-exhibition-anchor" ></div>
                    <h2 class="right-align-h" id="event-divide" alt="current main exhibition title">Introduction to Margaret Morris Movement</h2>

                    <p class="right-align-p" alt="current main exhibition description">                       
                        Join Sara Lockwood for an introduction to Margaret Morris Movement and look after your health and well-being through creative dance.
                    </p>
                    <br>
                    <p class="right-align-p" alt="current main exhibition dates">
                        V/A LOCATIONS<br>
                        <br>
                        <strong>PLEASANCE SPORT COMPLEX</strong> : 11 OCTOBER 2019 14:00 - 16:00<br>
                        <br>
                        <strong>DANCE BASE</strong> : 27 OCTOBER 2019 10:00 - 12:00<br>
                        <br>
                        FREE ENTRY<br>
                    </p>

                    <!-- BUTTON TO CURRENT EXHIBITION COLLECTION -->
                    <!-- * commented out as none exists currently -->
                    <a id="info-gap" href="<?php base_url()?>morrisevent" alt="Link to view full event details" title="Link to view full event details">
                        <button class="exhibit-button">
                            <p>View Event</p>
                        </button>
                    </a>

                </div>
                    
            </div>

            <div class="past-icon skrollable skrollable-after">
                <a href="events" alt="link to full list of past exhibitions" title="Link to view all events">
                    <img id="past-link" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/list.png" alt="list icon">
                    <p class="left-align-p">View the full events list</p>
                </a>
            </div>

        </div>

        <!-- BLOCK GAP -->
        <div id="page-gap" class="gap">

            <!-- BLOCK ANCHOR -->
            <div  class="index-anchor" id="support-anchor"></div>

            <!-- ANIMATED NAVIGATION BAR -->       
            <div class="nav-container" data-100-bottom-top="transform: translateY(-500px); opacity: -10" data-center-top="transform: translateX(0px); opacity: 1">
                <ul>
                    <div class="smol"><a class="nav-link" href="#visit-anchor" alt="Jump to visit us section" title="Jump to visit us section"><li>Visit Us</li></a></div>
                    <div><a class="nav-link" href="#exhibitions-anchor" alt="Jump to exhibitions section" title="Jump to exhibitions section"><li>Exhibitions</li></a></div>
                    <div class="smol"><a class="nav-link" href="#events-anchor" alt="Jump to events section" title="Jump to events section"><li>Events</li></a></div>
                    <div><a class="nav-link" href="#support-anchor" alt="Jump to support us section" title="Jump to support us section"><li>Support Us</li></a></div>
                    <div><a class="nav-link" href="#home-anchor" alt="Jump to top of page" title="jump back to the top of the page"><li>Back to Top</li></a></div>
                </ul>
            </div>

            <!-- BLOCK TITLE -->
            <div class="block-title">
                <h1 class="block-title-head"alt="Library support us section">Support Us</h1>
            </div>
    
        </div>


        <!-- SUPPORT US BLOCK -->
        <div id="block-one" class="body-text content">

            <!-- SECTION LOGO -->
            <div id="discover-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/discover_ed_logo.png" alt="library Discovery logo" title="Library Discovery logo">
            </div>

            <!-- SECTION INFO -->
            <div id="info-container" data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <h2 id="support-h" class="right-align-h" >Support the University of Edinburgh Library Exhibitions</h2>

                <h3 id="support-h3" class="right-align-h" alt="links tolibrary social media accounts">Follow us:</h3>

                <!-- SOCIAL MEDIA LOGOS -->
                <div id="social-image-block" >
                    <div class="social-image-box">
                        <a href=" https://twitter.com/UoE_Exhibitions?lang=en" alt="external link to library exhibitions twitter account" title="External link to Library Exhibitions Twitter account" target="_blank">
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/socialicons/twittericon.png" alt="Twitter Icon">
                        </a>
                    </div>
                    <div class="social-image-box">
                        <a href=" https://en-gb.facebook.com/crc.edinburgh/" alt="external link to library exhibitions facebook account" title="External link to Library Exhibitions Facebook account" target="_blank">
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/socialicons/facebookicon.png" alt="Facebook Icon">
                        </a>
                    </div>
                    <div class="social-image-box">
                        <a href="http://libraryblogs.is.ed.ac.uk/" alt="link to library exhibitions wordpress account"title="External link to Library Exhibitions Wordpress account" target="_blank">
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/socialicons/wordpressicon.png" alt="Wordpress Icon" >
                        </a>
                    </div>
                    
                </div>

                <p id="support-p" class="right-align-p" alt="supporting the library description">
                    Opportunities are available throughout the year to help with visitor experience, events, exhibition installs, and evaluation. If you are interested in volunteering with us please complete our 
                    <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/volunteers-interns/volunteer-enquiry-form" alt="link to volunteer enquirery form for those that wish to get involved" title="Link to volunteer enquirery form" traget="_blank">volunteering enquiry form</a> 
                </p>               
        
            </div>

        </div>

<!-- END OF FILE -->