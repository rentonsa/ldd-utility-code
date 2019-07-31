/**
 * openingtimes.js
 * 
 * simple script to check date and print appropriate opening times for UofE library main gallery
 * 
 * @author bparkes.ed.ac.uk
 */

var dt = new Date("June 12, 2019 00:00:00");
    if (dt.getDay()!==0){
        document.getElementById("opening-times").innerHTML = "OPEN TODAY: 10:00 - 17:00";
    }
    else {
        document.getElementById("opening-times").innerHTML = "CLOSED TODAY";
    }