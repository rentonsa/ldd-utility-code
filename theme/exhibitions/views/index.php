    <!-- PARALLAX SCROLL BODY -->
    <!-- Contains the content of the different information blocks -->
    <div id="skrollr-body">

        <!-- GAP DIVS ENFORCE "BACKGROUND" SPACE FOR IMAGES -->
        <div id="page-gap" class="gap">
 
            <!-- MAIN UNIVERSITY LOGO -->
            <div id="#home-anchor" class="logo-container">
                <a href="<?php base_url() ?>">
                    <img id="top-nav" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/uofe_logo.png" alt="University of Edinburgh Logo">
                </a>
            </div>

            <!-- STATIC NAVIGATION BAR TEMPLATE -->
            <div id="top-nav" class="nav-container">
                <ul>
                    <div class="smol"><a class="nav-link" href="#visit-anchor"><li>Visit Us</li></a></div>
                    <div><a class="nav-link" href="#exhibitions-anchor"><li>Exhibitions</li></a></div>
                    <div class="smol"><a class="nav-link" href="#events-anchor"><li>Events</li></a></div>
                    <div><a class="nav-link" href="#support-anchor"><li>Support Us</li></a></div>
                </ul>
            </div>
            

            <!-- HEADER FOR NEXT BLOCK MAINTAINED INSIDE PREVIOUS PAGE GAP -->
            <!-- Header ids also used for 'jumps' to blocks throughout site -->
            <div class="block-title">
                <h1 id="home" class="block-title-head">Library Exhibitions</h1>
            </div>

        </div>
    
        <!-- PARALLAX (SCROLLING) BLOCKS -->
        <!-- Contain the content for each block/section of the page 
            * to be update for new exhibitions or information changes -->

        <!-- HEAD BLOCK -->
        <div id="block-one" class="body-text content">

            <div id="welcome-container" class="exhibition-container">
                <div id="exhibit-logo">         
                    <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/discover_ed_logo.png">
                </div>

                <div id="info-container" class="exhibit-info">
                    <h2 class="right-align-h">Welcome to the University of Edinburgh Library Exhibitions</h2>

                    <p class="right-align-p" >                       
                        From meteorites, to World War II escape maps, rare books, anatomical specimens, and contemporary art, our exciting exhibition programme showcases the University’s vast and varied heritage collections<br>    
                    </p>
                    <p id="link-p" class="right-align-p">
                        If you would like find out more about the University’s collections, please visit the <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc">Centre for Research Collections</a>
                    </p>

                    <div class="image-box-xtra-smol">
                        <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/current_exhibition_logo.png" alt="Forthcoming Exhibit">
                    </div>

                    <p class="right-align-p" >
                    CURRENT EXHIBITION: BODY LANGUAGE                      
                    </p>

                    <p id="opening-times" class="right-align-p">
                    </p>

                    <div id="quick-links">
                        <a href="#events-anchor">
                            <button id="" class="exhibit-button">
                                <p>Upcoming Events</p>
                            </button>
                        </a>
                        <a href="#current-exhibition-anchor">
                            <button id="quick-button" class="exhibit-button">
                                <p>Curent Exhibition</p>
                            </button>
                        </a>
                    </div>

                </div>
            </div>

        </div>

        <div id="page-gap" class="gap">

            <div class="index-anchor" id="visit-anchor"></div>

            <!-- ANIMATED NAVIGATION BAR TEMPLATE * only used for blocks that are scrolled over -->
            <div class="nav-container" data-100-bottom-top="transform: translateY(-500px); opacity: -10" data-center-top="transform: translateX(0px); opacity: 1">
                <ul>
                    <div class="smol"><a class="nav-link" href="#visit-anchor"><li>Visit Us</li></a></div>
                    <div><a class="nav-link" href="#exhibitions-anchor"><li>Exhibitions</li></a></div>
                    <div class="smol"><a class="nav-link" href="#events-anchor"><li>Events</li></a></div>
                    <div><a class="nav-link" href="#support-anchor"><li>Support Us</li></a></div>
                    <div><a class="nav-link" href="#home-anchor"><li>Back to Top</li></a></div>
                </ul>
            </div>

            <div class="block-title">
                <h1 class="block-title-head">Visit Us</h1>
            </div>

        </div>

        <!-- VISIT US BLOCK -->
        <div id="block-two" class="body-text content">
            
            <div id="visit-container" data-100-bottom-top="transform: translateY(150px); opacity: 0" data-center-top="transform: translateY(0px); opacity: 1">
                           
                <div class="visit-block" >
                    <p id="visit-main" class="left-align-p">                       
                        FREE ADMISSION<br/>
                        <!--OPEN TO ALL<br/>-->
                    </p>
                    <p id="visit-main-2" class="left-align-p">
                        OPEN TO ALL
                    </p>
                    <img id="open" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/open.png">
                    <p id="visit-first" class="left-align-p" id="opening">   
                        Monday  to Saturday<br/> 
                        10am - 5pm<br/> 
                    </p>
                    <img id="wheelchair" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/wheelchair.png">
                    <p id="visit-second" class="left-align-p">
                        Wheelchair accessible via ramp at front of the building. Push pad door entry.
                    </p>
                </div>
                <div class="visit-block" >
                    <p id="visit-main" class="left-align-p" >                       
                        FACILITIES<br/>
                    </p>
                    <img id="cafe" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/cafe.png"> 
                    <p id="visit-first" class="left-align-p">                           
                        The Library Caféis accessed to the right of the building's main entrance. 
                    </p>
                    <img id="toilet" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/toilet.png">
                    <p id="visit-second" class="left-align-p">
                        
                    Toilets, including accessible toilets, are located in the Library café. Term time Mon-Sun. Non term time Mon-Fri.
                    </p>
                </div>
                <div class="visit-block" id="address">
                    <p id="visit-main" class="left-align-p" >                       
                        HOW TO FIND US<br/>
                    </p>
                    <img id="floor" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/location.png">
                    <p id="visit-first" class="left-align-p">
                        Ground Floor<br/>
                        University of Edinburgh<br>
                        Main Library<br/>                          
                        30 George Square<br/>
                        Edinburgh<br> 
                        EH8 9LJ 
                    </p>
                </div>
                <div class="visit-block" id="contact">
                    <p id="visit-main" class="left-align-p" >                       
                        CONTACT US<br/>
                    </p>
                    <img id="email" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/email.png">
                    <p id="visit-first-email" class="left-align-p">
                        <a id="email-link" href="museums@ed.ac.uk">museums@ed.ac.uk</a><br/>
                    </p>
                    <img id="phone" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/phone.png">
                    <p id="visit-second-phone" class="left-align-p">                             
                        0131 6502600<br>(Tue-Sat) 
                    </p>

                </div>

                <div id="google-map"></div>
            </div>
               
        </div>

        <div id="page-gap" class="gap">

            <div class="index-anchor" id="exhibitions-anchor"></div>
        
            <div class="nav-container" data-100-bottom-top="transform: translateY(-500px); opacity: -10" data-center-top="transform: translateX(0px); opacity: 1">
                <ul>
                    <div class="smol"><a class="nav-link" href="#visit-anchor"><li>Visit Us</li></a></div>
                    <div><a class="nav-link" href="#exhibitions-anchor"><li>Exhibitions</li></a></div>
                    <div class="smol"><a class="nav-link" href="#events-anchor"><li>Events</li></a></div>
                    <div><a class="nav-link" href="#support-anchor"><li>Support Us</li></a></div>
                    <div><a class="nav-link" href="#home-anchor"><li>Back to Top</li></a></div>
                </ul>
            </div>

            <div class="block-title">
                <h1  class="block-title-head">Exhibitions</h1>
            </div>
    
        </div>

        <!-- EXHIBITION BLOCK -->
        <div id="block-three" class="body-text content">

            <h1 id="current-exhibitions" class="left-align-h1" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">Current Exhibition</h1>

            <div class="exhibition-container">
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">         
                    <a href="https://test.exhibitions.ed.ac.uk/conectando">
                        <div class="image-box" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/current_exhibition_logo.png" >
                        </div>
                    </a>
                </div>

                <div id="info-container" class="exhibit-info" data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <div class="anchor" id="current-exhibition-anchor" ></div>
                    <h2 class="right-align-h">Body Language</h2>

                    <p class="right-align-p" >                       
                        Delve into the archives of Dunfermline College of Physical Education, Scottish Gymnastics, and the influential dance pioneer Margaret Morris (1891-1980), and discover Scotland’s significant contributions to movement and dance
                    </p>

                    <p id="info-gap" class="right-align-p" >                       
                            MAIN LIBRARY EXHIBITION GALLERY<br>
                            GROUND FLOOR
                    </p>
                    <p class="right-align-p">
                            26 JULY 2019 - 26 OCTOBER 2019
                    </p>
                    <p class="right-align-p" id="last-p">
                            MONDAY to SATURDAY 10:00 - 17:00 (Plus Sundays Throughout August)
                    </p>

                    <!--<a id="info-gap" href="<?php base_url()?>bodylanguage">
                        <button class="exhibit-button">
                            <p>View Exhibition</p>
                        </button>
                    </a>-->
                    <img class="associated-logo" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/welcome-trust-logo-long.png" alt="The Welcome Trust Logo">
                    <img class="associated-logo" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/fringe-logo-white.png" alt="Edinburgh Fringe Festival Logo">
                    <img class="associated-logo" id="pandk" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/culture-perth-kinross-logo.png" alt="Culture: Perth and Kinroos Logo">

                </div>
                    
            </div>

            <div id="past-container" class="divider" data-100-bottom-top="transform: translateY(0px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1"></div>
                
            <h1 id="coming-exhibitions" class="left-align-h1" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">Coming Soon</h1>

            <div class="exhibition-container">
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                        <a>
                            <div class="image-box" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                                <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/box_2.png" alt="Forthcoming Exhibit">
                            </div>
                        </a>
                </div>
                <div id="coming-exhibit-info" >
                    <div data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                        <h2 class="right-align-h">
                            Needlework Development Scheme
                        </h2>
            
                        <p class="right-align-p" >                       
                            Come and discover the University’s Needlework Development Scheme (NDS), an unique group of 17th-20th century textiles from around the world. 
                            Discover how the pieces have inspired students at ECA for generations and how they are now being revitalised through digital technologies and community engagement. 
                            Get hands-on with the specially created handling samples and feel the stitches get under your fingers.
                        </p>
                        <br>
                        <p class="right-align-p" > 
                            Explore this collection at Edinburgh College of Art’s Embroidered Stories <strong><a href="https://embroideredstories.eca.ed.ac.uk/">here</a></strong>
                        </p> 

                        <p id="info-gap" class="right-align-p" >                       
                            MAIN LIBRARY EXHIBITION GALLERY<br>
                            GROUND FLOOR 
                        </p>
                        <p class="right-align-p" >
                            29 NOVEMBER 2019 – 29 FEBUARY 2020
                        </p>
                        <p class="right-align-p" >
                            MONDAY to SATURDAY 10:00 - 17:00
                        </p>

                        <!--<a id="info-gap" href="https://embroideredstories.eca.ed.ac.uk/">
                            <button class="exhibit-button">
                                <p>View Exhibition</p>
                            </button>
                        </a>-->

                    </div>
                </div>
            </div>

            <div id="past-container" class="divider" data-100-bottom-top="transform: translateY(0px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1"></div>

            <div class="exhibition-container" id="exhibition-divide">
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                        <a>
                            <div class="image-box" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                                <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/box_3.png" alt="Forthcoming Exhibit">
                            </div>
                        </a>
                    </div>
                <div id="coming-exhibit-info" >
                    <div data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                        <h2 class="right-align-h">
                            Lu Xun: A Legacy In Print
                        </h2>
            
                        <p class="right-align-p" >                       
                            Lu Xun (1881-1936) is the pen name of the revolutionary Chinese writer Zhou Shuren. A leading left-wing printmaker and writer, Lu Xun was a passionate critic of the cultural and political conditions in 20th century China. 
                            Drawn from the collections of the Muban Educational Trust, this travelling exhibition will explore Lu Xun’s revolutionary woodcuts, the marked difference between prints made for propaganda and those for ‘art’s sake’, 
                            Lu Xun’s  technical and stylistic influence, and prints made from the 1950s to present day
                        </p>
                        <br>
                        <p class="right-align-p" >                       
                            Courtesy of the <a href="http://mubaneducationaltrust.org/">Muban Educational Trust</a>.
                        </p>
                        <p id="info-gap" class="right-align-p" >                       
                            MAIN LIBRARY EXHIBITION GALLERY<br>
                            GROUND FLOOR 
                        </p>
                        <p class="right-align-p" >
                            APRIL - SEPTEMBER 2020
                        </p>
                        <p class="right-align-p" id="last-p">
                            MONDAY to SATURDAY 10:00 - 17:00
                        </p>

                        <img class="associated-logo" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/muban-trust-logo.png" alt="Muban Trust Logo">

                    </div>

                </div>
            </div>

            <div id="past-container" class="divider" data-100-bottom-top="transform: translateY(0px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1"></div>

            <h1 id="coming-exhibitions" class="left-align-h1" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">Past Exhibitions</h1>

            <div id="past-container">
                                           
                    <div  data-100-bottom-top="transform: translateY(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                        <div id="smol-image-block" >
                            <div class="image-box-smol" >
                                <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/past_1.jpg" alt="Forthcoming Exhibit">
                            </div>
                            <div class="image-box-smol" >
                                <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/past_2.jpg" alt="Forthcoming Exhibit">
                            </div>
                            <div class="image-box-smol" >
                                <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/past_3.jpg" alt="Forthcoming Exhibit">
                            </div>
                            <div class="image-box-smol" >
                                <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/exhibitboxes/past_4.jpg" alt="Forthcoming Exhibit">
                            </div>
                            <span class="stretch"></span>
                        </div>
                        <div id="smol-image-block" >
                            <div class="text-box-smol">
                                <h3 class="past-exhibit-h">Highlands to Hindustan</h3>
                                <p class="past-exhibit-p">Jul 2017 - Nov 2017</p>
                                <a href="./highlandstohindustan"><button id="past-button" class="exhibit-button">
                                    <p>View Exhibition</p>
                                </button></a>
                            </div>
                            <div class="text-box-smol">
                                <h3 class="past-exhibit-h">Towards Dolly</h3>
                                <p class="past-exhibit-p">Nov 2017 - Mar 2018</p>
                                <a href="./towardsdolly"><button id="past-button" class="exhibit-button">
                                    <p>View Exhibition</p>
                                </button></a>
                            </div>
                            <div class="text-box-smol">
                                <h3 class="past-exhibit-h">Rashid-al-Din</h3>
                                <p class="past-exhibit-p">Jan 2017 - Aug 2017</p>
                                <a href="./rashid"><button id="past-button" class="exhibit-button">
                                    <p>View Exhibition</p>
                                </button></a>
                            </div>
                            <div class="text-box-smol">
                                <h3 class="past-exhibit-h">Emma Gillies</h3>
                                <p class="past-exhibit-p">Dec 2014 - Mar 2015</p>
                                <a href="./emmagillies"><button id="past-button" class="exhibit-button">
                                    <p>View Exhibition</p>
                                </button></a>
                            </div>
                            <span class="stretch"></span>
                        </div>
                    </div>

            </div>

            <div id="past-icon" class="past-icon" data-100-bottom-top="transform: translateY(50px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <a href="<?php base_url()?>past">
                    <img id="past-link" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/list.png">
                    <p class="left-align-p">View the full past exhibitions list</p>
                </a>
            </div>
    
        </div>

        <div id="page-gap" class="gap">

            <div class="index-anchor" id="events-anchor"></div>
        
            <div class="nav-container" data-100-bottom-top="transform: translateY(-500px); opacity: -10" data-center-top="transform: translateX(0px); opacity: 1">
                <ul>
                    <div class="smol"><a class="nav-link" href="#visit-anchor"><li>Visit Us</li></a></div>
                    <div><a class="nav-link" href="#exhibitions-anchor"><li>Exhibitions</li></a></div>
                    <div class="smol"><a class="nav-link" href="#events-anchor"><li>Events</li></a></div>
                    <div><a class="nav-link" href="#support-anchor"><li>Support Us</li></a></div>
                    <div><a class="nav-link" href="#home-anchor"><li>Back to Top</li></a></div>
                </ul>
            </div>

            <div class="block-title">
                <h1 class="block-title-head">Events</h1>
            </div>
    
        </div>

        <!-- EVENTS BLOCK -->
        <div id="block-four" class="body-text content">

            <div class="anchor" id="current-events-anchor" ></div>

            <h2 id="current-events" class="left-align-h" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">Coming Soon...</h2>

            <!-- COMMENTED OUT UNTIL WE RECIEVE CONTENT -->
            <!--<h2 id="current-events" class="left-align-h" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">Up-Coming Events</h2>

            <div class="exhibition-container">
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">         
                    <a href="https://test.exhibitions.ed.ac.uk">
                        <div class="image-box" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/eventboxes/box_1.png" >
                        </div>
                    </a>
                </div>

                <div id="info-container" class="exhibit-info" data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                    <h2 id="first-event" class="right-align-h">
                        Event Example One
                    </h2>

                    <p class="right-align-p" >                       
                        A strong and clear event description excites punters: tell them what will happen at the event, who will be speaking, and what they might get out of attending. Your event may be brilliant, but no one else will know without you telling and convincing them.
                    </p>

                    <p id="info-gap" class="right-align-p" >                       
                            MAIN LIBRARY EXHIBITION GALLERY
                    </p>
                    <p class="right-align-p">
                            5 APRIL 2018 - 29 JUNE 2019
                    </p>
                    <p class="right-align-p">
                            Ground Floor - Monday to Saturday
                    </p>

                    <a id="info-gap" href="https://test.exhibitions.ed.ac.uk/conectando">
                        <button class="exhibit-button">
                            <p id="event-button">View Event</p>
                        </button>
                    </a>

                </div>
            </div>

            <div id="central-event" class="exhibition-container">
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">         
                    <a href="https://test.exhibitions.ed.ac.uk">
                        <div class="image-box" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/eventboxes/box_2.png" >
                        </div>
                    </a>
                </div>

                <div id="info-container" class="exhibit-info" data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                    <h2 id="first-event" class="right-align-h">
                        Event Example Two
                    </h2>

                    <p class="right-align-p" >                       
                        A strong and clear event description excites punters: tell them what will happen at the event, who will be speaking, and what they might get out of attending. Your event may be brilliant, but no one else will know without you telling and convincing them.
                    </p>

                    <p id="info-gap" class="right-align-p" >                       
                            MAIN LIBRARY EXHIBITION GALLERY
                    </p>
                    <p class="right-align-p">
                            5 APRIL 2018 - 29 JUNE 2019
                    </p>
                    <p class="right-align-p">
                            Ground Floor - Monday to Saturday
                    </p>

                    <a id="info-gap" href="https://test.exhibitions.ed.ac.uk/conectando">
                        <button class="exhibit-button">
                            <p id="event-button">View Event</p>
                        </button>
                    </a>

                </div>
            </div>

            <div id="last-event" class="exhibition-container">
                <div id="exhibit-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">         
                    <a href="https://test.exhibitions.ed.ac.uk">
                        <div class="image-box" >
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/eventboxes/box_3.png" >
                        </div>
                    </a>
                </div>

                <div id="info-container" class="exhibit-info" data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                    <h2 id="first-event" class="right-align-h">
                        Event Example Three
                    </h2>

                    <p class="right-align-p" >                       
                        A strong and clear event description excites punters: tell them what will happen at the event, who will be speaking, and what they might get out of attending. Your event may be brilliant, but no one else will know without you telling and convincing them.
                    </p>

                    <p id="info-gap" class="right-align-p" >                       
                            MAIN LIBRARY EXHIBITION GALLERY
                    </p>
                    <p class="right-align-p">
                            5 APRIL 2018 - 29 JUNE 2019
                    </p>
                    <p class="right-align-p">
                            Ground Floor - Monday to Saturday
                    </p>

                    <a id="info-gap" href="https://test.exhibitions.ed.ac.uk/conectando">
                        <button class="exhibit-button">
                            <p id="event-button">View Event</p>
                        </button>
                    </a>

                </div>
            </div>

            <div id="event-icon" class="past-icon" data-100-bottom-top="transform: translateY(50px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <a href="https://test.exhibitions.ed.ac.uk/past">
                    <img id="past-list" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/icons/list.png">
                    <p class="left-align-p">View the full events programme</p>
                </a>
            </div>-->

        </div>


        <div id="page-gap" class="gap">

            <div  class="index-anchor" id="support-anchor"></div>
        
            <div class="nav-container" data-100-bottom-top="transform: translateY(-500px); opacity: -10" data-center-top="transform: translateX(0px); opacity: 1">
                <ul>
                    <div class="smol"><a class="nav-link" href="#visit-anchor"><li>Visit Us</li></a></div>
                    <div><a class="nav-link" href="#exhibitions-anchor"><li>Exhibitions</li></a></div>
                    <div class="smol"><a class="nav-link" href="#events-anchor"><li>Events</li></a></div>
                    <div><a class="nav-link" href="#support-anchor"><li>Support Us</li></a></div>
                    <div><a class="nav-link" href="#home-anchor"><li>Back to Top</li></a></div>
                </ul>
            </div>

            <div class="block-title">
                <h1 class="block-title-head">Support Us</h1>
            </div>
    
        </div>


        <!-- SUPPORT US BLOCK -->
        <div id="block-one" class="body-text content">

            <div id="discover-logo" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/logos/discover_ed_logo.png">
            </div>
            <div id="info-container" data-100-bottom-top="transform: translateX(75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
                <h2 id="support-h" class="right-align-h" >Support the University of Edinburgh Library Exhibitions</h2>

                <h3 id="support-h3" class="right-align-h">Follow us:</h3>

                <div id="social-image-block" >
                    <div class="social-image-box">
                        <a href=" https://twitter.com/UoE_Exhibitions?lang=en">
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/socialicons/twittericon.png" alt="twittericon.png">
                        </a>
                    </div>
                    <div class="social-image-box">
                        <a href=" https://en-gb.facebook.com/crc.edinburgh/">
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/socialicons/facebookicon.png" alt="facebookicon.png">
                        </a>
                    </div>
                    <div class="social-image-box">
                        <a href="http://libraryblogs.is.ed.ac.uk/">
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/socialicons/wordpressicon.png" alt="wordpress.png">
                        </a>
                    </div>
                    <!--<div class="social-image-box">
                        <a href="http://libraryblogs.is.ed.ac.uk/">
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/socialicons/flickricon.png" alt="flickr.png">
                        </a>
                    </div>-->
                    
                </div>

                <p id="support-p" class="right-align-p">
                    Opportunities are available throughout the year to help with visitor experience, events, exhibition installs, and evaluation. If you are interested in volunteering with us please complete our 
                    <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/volunteers-interns/volunteer-enquiry-form">volunteering enquiry form</a> 
                </p>               
        
            </div>

        </div>