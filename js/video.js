threshold = 100;
DEBUG = false;

photos = Photos.map(Image.load);

//var width = document.documentElement.clientWidth;
//var height = document.documentElement.clientHeight;

var width2 = screen.availWidth;
var height = 0;
var aspectRatio = 0;
var display = null;
var videoCanvas = document.createElement('canvas');
var raster = null;
var param = null;
var resultMat = null;
var detector = null;
var ctx = null;

var times = [];
var pastResults = {};
var lastTime = 0;
var images = [];

var detected = null;

var video = document.createElement('video');
video.loop = true;
video.volume = 0;
video.autoplay = true;
video.controls = true;
var pivotScale = 200;
var pivotScalePrev = pivotScale;
var cubes = {};
var canvas = document.createElement('canvas');
var debugCanvas = document.createElement('canvas');
var glCanvas = document.createElement('canvas');
var videoTex = null;

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

var URL = window.URL || window.webkitURL;
var createObjectURL = URL.createObjectURL || webkitURL.createObjectURL;
if (!createObjectURL) {
    throw new Error("URL.createObjectURL not found.");
}

function gumSuccess(stream) {
   console.log("Success! Device Name: " + stream.getVideoTracks()[0].label);
};

function gumFailed(error){
    console.error("Failed!",error);
};

//if (MediaStreamTrack) {
//    MediaStreamTrack.getSources(function (sourceInfos){
//        sources=sourceInfos;
//        for (var i=0, iLen=sourceInfos.length; i<iLen; i++) {
//            if (sourceInfos[i].label.indexOf("Webcam") > -1){
//                result.push(sourceInfos[3]);
//            }
//        }         
//        constraints = {
//            video: {
//                optional: [{
//                    sourceId: "152529b6da600f6fb1fd32cf3c5fb977794d89d554b798e5a0043a0021a7e6e8"
//                }]
//            }
//        };
//    });
//};


    getUserMedia(
//        {video: {
//            optional: [{
//                sourceId: "ef2522a85c7fc0cbf5ee76fbd1e689a47c6e5ed6f0438a6598116e42aeb55ce5"
//            }]
//        }},
        (constraints.propertyIsEnumerable('video') ? constraints :
        {video: true}),
        function(stream) {
            var url = createObjectURL(stream);
            video.src = url;
        },
        function(error) {
            alert("No se ha podido acceder a la cámara.");
        }
    );
    
    document.body.appendChild(video);
    $(video).bind("loadedmetadata", function () {
//        alert(this.videoWidth + 'x' + this.videoHeight);
//        alert(screen.availWidth + 'x' + screen.availHeight);
        width = this.videoWidth;
        height = this.videoHeight;
    
        aspectRatio = height / width;
        
        if(width2 > 1000)
            width2 /= 2;
        height2 = width2 * aspectRatio;
        
//        width2 = 480;
//        height2 = 640;
//        width2 = width;
//        height2 = height;
//        width = width2;
//        height = height2;
        
        video.style.display = 'none';
        video.width = width;
        video.height = height;

        canvas.style.display = 'block';        
        canvas.width = video.width;
        canvas.height = video.height;
        

//        debugCanvas.style.webkitTransform = 'scale(1.0, 1.0)';
//        debugCanvas.style.MozTransform = 'scale(1.0, -1.0)';
        ////////////////
//        videoCanvas.style.webkitTransform = 'scale(1.0, 1.0)';
//        videoCanvas.style.MozTransform = 'scale(-1.0, -1.0)';
        ////////////////
//        canvas.style.webkitTransform = 'scale(-1.0, 1.0)';
//        canvas.style.MozTransform = 'scale(-1.0, -1.0)';
        ////////////////
        videoCanvas.width = width2;
        videoCanvas.height = height2;
        ////////////////
        ctx = canvas.getContext('2d');
//        ctx.translate(0, height);
//        ctx.scale(1, -1);
        ctx.font = "24px URW Gothic L, Arial, Sans-serif";
        
        
        ctx2 = videoCanvas.getContext('2d');
        ctx2.translate(0, height2);
        ctx2.scale(1, -1);         
        ///////////////

        raster = new NyARRgbRaster_Canvas2D(canvas);
        param = new FLARParam(width,height);

        resultMat = new NyARTransMatResult();

        detector = new FLARMultiIdMarkerDetector(param, 120);
        detector.setContinueMode(true);

        glCanvas.style.webkitTransform = 'scale(1.0, 1.0)';
        glCanvas.style.MozTransform = 'scale(1.0, 1.0)';
        //////////////////
        glCanvas.width = width2;
        glCanvas.height = height2;
        //////////////////
        //////////////////
        debugCanvas.width = width2;
        debugCanvas.height = height2;
        //////////////////
        var s = glCanvas.style;
        document.body.appendChild(glCanvas);
        
        $(debugCanvas).attr('id', 'debugCanvas');
        document.body.appendChild(debugCanvas);
        
        display = new Magi.Scene(glCanvas);
        display.drawOnlyWhenChanged = true;
        param.copyCameraMatrix(display.camera.perspectiveMatrix, 10, 10000);
        display.camera.useProjectionMatrix = true;
        videoTex = new Magi.FlipFilterQuad();
        videoTex.material.textures.Texture0 = new Magi.Texture();
        videoTex.material.textures.Texture0.image = videoCanvas;
        videoTex.material.textures.Texture0.generateMipmaps = false;
        display.scene.appendChild(videoTex);                
//        videoCanvas.getContext('2d').translate(width2, 0);
//        videoCanvas.getContext('2d').scale(-1, -1);
//        videoCanvas.style.MozTransform = 'scale(1.0, -1.0)';   
            
       

        window.updateImage = function() {
          display.changed = true;
        };

//        $('body').on('touchstart', function (ev) {
//            jPinch.init(ev);
//            pivotScalePrev = pivotScale;
//        });
//
//        $('body').on('touchmove', function (ev) {
//            if (ev.originalEvent.touches.length == 2) {
//                pivotScale = pivotScalePrev * jPinch.relativeDistance(ev);
//                cubes[64].setScale(pivotScale);
//            }
//        });    

        setInterval(function(){
            if (video.ended) video.play();
            if (video.paused) return;
            if (window.paused) return;
            if (video.currentTime == video.duration) {
              video.currentTime = 0;
            }
            if (video.currentTime == lastTime) return;
            lastTime = video.currentTime;
            ctx2.drawImage(video, 0, 0, width2, height2);
            ctx.drawImage(videoCanvas, 0,0,width,height);

            videoTex.material.textures.Texture0.changed = true;

            canvas.changed = true;
            display.changed = true;

            detected = detector.detectMarkerLite(raster, threshold);
            for (var idx = 0; idx<detected; idx++) {
              var id = detector.getIdMarkerData(idx);
              //read data from i_code
              var currId;
              if (id.packetLength > 4) {
                currId = -1;
              }else{
                currId=0;
                
                for (var i = 0; i < id.packetLength; i++ ) {
                  currId = (currId << 8) | id.getPacketData(i);
                  //console.log("id[", i, "]=", id.getPacketData(i));
                }
              }
              //console.log("[add] : ID = " + currId);
              if (!pastResults[currId]) {
                pastResults[currId] = {};
              }
              detector.getTransformMatrix(idx, resultMat);
              pastResults[currId].age = 0;
              pastResults[currId].transform = Object.asCopy(resultMat);
            }
            for (var i in pastResults) {
              var r = pastResults[i];
              if (r.age > 1) {
                delete pastResults[i];
              }
              r.age++;
            }
            $("#infoButtons ul").html('');
            for (var i in cubes) cubes[i].display = false;
            for (var i in pastResults) {
                if (!cubes[i]) {
                    var pivot = new Magi.Node();
                    pivot.transform = mat4.identity();
                    pivot.setScale(pivotScale);
                    var image = new Magi.Image();
                    image
                        .setAlign(image.centerAlign, image.centerAlign)
                        .setPosition(0, 0, 0)
                        .setAxis(0,0,1)
                        .setAngle(Math.PI)
                        .setSize(1.5);
                    image.setImage = function(src) {
                        var img = E.canvas(width,height);
                        Magi.Image.setImage.call(this, img);
                        this.texture.generateMipmaps = false;
                        var self = this;
                        src.onload = function(){
                            var w = this.width, h = this.height;
                            var f = Math.min(width/w, width/h);
                            w = (w*f);
                            h = (h*f);
                            img.getContext('2d').drawImage(this, (width-w)/2,(width-h)/2,w,h);
                            self.texture.changed = true;
                            self.setSize(1.1*Math.max(w/h, h/w));
                        };
                        if (Object.isImageLoaded(src)) {
                            src.onload();
                        }
                    };
                    image.setImage(cuadros2[i] != "0" ? Image.load("img/cuadros/" + cuadros2[i] + ".jpg") : Image.load("img/cuadros/0.jpg"));
                    images.push(image);
                    pivot.image = image;
                    pivot.appendChild(image);
                    /*var txt = new Magi.Text(i);
                    txt.setColor('#f0f0d8');
                    txt.setFont('URW Gothic L, Arial, Sans-serif');
                    txt.setFontSize(32);
                    txt.setAlign(txt.leftAlign, txt.bottomAlign)
                        .setPosition(-0.45, -0.48, -0.51)
                        .setScale(1/190);*/
                    display.scene.appendChild(pivot);
                    cubes[i] = pivot;
                }
                cubes[i].display = true;
                var mat = pastResults[i].transform;
                var cm = cubes[i].transform;
                cm[0] = mat.m00;
                cm[1] = -mat.m10;
                cm[2] = mat.m20;
                cm[3] = 0;
                cm[4] = mat.m01;
                cm[5] = -mat.m11;
                cm[6] = mat.m21;
                cm[7] = 0;
                cm[8] = -mat.m02;
                cm[9] = mat.m12;
                cm[10] = -mat.m22;
                cm[11] = 0;
                cm[12] = mat.m03;
                cm[13] = -mat.m13;
                cm[14] = mat.m23;
                cm[15] = 1;
                
                if (cuadros2[i])
                    $("#infoButtons ul").append("<li><img src='img/cuadros/" + cuadros2[i] + ".jpg' alt='' style='max-width: 10%;' onclick=\"InitAddCuadroModalDialog(" + cuadros2[i] + ");\"/></li>");
            }
        }, 30);
    });