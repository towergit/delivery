// cT - countTimer
var cT = function () {};
    cT.monthName =  ["January","February","March","April","May","June","July","August","September","October","November","December"];
    cT.monthDate = ['31', '29', '31', '30', '31', '30', '31', '31', '30', '31', '30', '31'];
    cT.nameClock = ['s','m','h','d'];
    cT.centerCircle = $('.seconds').width() / 2;
    //cT.cSec = document.getElementById('canvas-seconds');
    //cT.ctxSec = cT.cSec.getContext('2d');
    cT.cMin = document.getElementById('canvas-minutes');
    cT.ctxMin = cT.cMin.getContext('2d');
    cT.cHours = document.getElementById('canvas-hours');
    cT.ctxHours = cT.cHours.getContext('2d');
    cT.cDays = document.getElementById('canvas-days');
    cT.ctxDays = cT.cDays.getContext('2d');
    
    cT.refreshTime = function(x,date,ctx,nameClock){
        var radius = x*0.96, n = cT.nameClock.indexOf(nameClock);
            
        ctx.clearRect(0,0,125,125);
         
        ctx.beginPath();

        switch(n) {
            case 0:
                //$('.seconds').html(60 - date.getSeconds());
                //ctx.arc(x, x, radius, 0, 2 * Math.PI/60*(60-date.getSeconds()), false);
                break;
            case 1:
                $('.minutes').html(60 - date.getMinutes());
                ctx.arc(x, x, radius, 0, 2 * Math.PI/60*(60-date.getMinutes()), false);
                break;
            case 2:
                $('.hours').html(24 - date.getHours());
                ctx.arc(x, x, radius, 0, 2 * Math.PI/24*(24-date.getHours()), false);
                break;
            case 3:
                var d = cT.monthDate[new Date().getMonth()];
                $('.days').html(d - date.getDate()-23);
                ctx.arc(x, x, radius, 0, 2 * Math.PI/d*(d-date.getDate()), false);
                break;        
            default:
                break;
        }      
        ctx.lineWidth = 0;
        // line color
        //ctx.strokeStyle = 'white';
        //ctx.stroke();
    }

               
    setInterval( function() { 
            var  date = new Date();
            //cT.refreshTime(cT.centerCircle,date,cT.ctxSec,'s');
            cT.refreshTime(cT.centerCircle,date,cT.ctxMin,'m');
            cT.refreshTime(cT.centerCircle,date,cT.ctxHours,'h');
            cT.refreshTime(cT.centerCircle,date,cT.ctxDays,'d');        
    } , 1000)

                
