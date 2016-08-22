var pitagoras = function (touch1, touch2) {
    var x, y, h;
    x = touch1.screenX - touch2.screenX;
    y = touch1.screenX - touch2.screenX;    
    h = Math.sqrt(x*x + y*y);

    return h;
};

var jPinch = {
    
    initDistance: null,
    
    init:
        function (ev) {
            touch1 = ev.originalEvent.touches[0];
            touch2 = ev.originalEvent.touches[1];
            initDistance = pitagoras(touch1, touch2);
        },
    
    relativeDistance:
        function (ev) {
            touch1 = ev.originalEvent.touches[0];
            touch2 = ev.originalEvent.touches[1];
            return (pitagoras(touch1, touch2) / initDistance);
        }
};

var getUserMedia = function(t, onsuccess, onerror) {
    if (navigator.getUserMedia) {
        return navigator.getUserMedia(t, onsuccess, onerror);
    } else if (navigator.webkitGetUserMedia) {
        return navigator.webkitGetUserMedia(t, onsuccess, onerror);
    } else if (navigator.mozGetUserMedia) {
        return navigator.mozGetUserMedia(t, onsuccess, onerror);
    } else if (navigator.msGetUserMedia) {
        return navigator.msGetUserMedia(t, onsuccess, onerror);
    } else {
        onerror(new Error("No getUserMedia implementation found."));
    }
};



var constraints = {};
var sources;
var result = [];

if (MediaStreamTrack) {
    MediaStreamTrack.getSources(function (sourceInfos){
        sources=sourceInfos;
        for (var i=0, iLen=sourceInfos.length; i<iLen; i++) {
            if (sourceInfos[i].label.indexOf("back") > -1){
                result.push(sourceInfos[i]);
            }
        }         
        constraints = {
            video: {
                optional: [{
                    sourceId: result[0].id
                }]
            }
        };
        console.log(constraints);
    });
};

getUserMedia(
//                    {video: {
//                        optional: [{
//                            sourceId: "ef2522a85c7fc0cbf5ee76fbd1e689a47c6e5ed6f0438a6598116e42aeb55ce5"
//                        }]
//                    }},
//                    constraints,
                    {video: true},
                    function(stream) {
                        
                    },
                    function(error) {
                        
                    }
                );