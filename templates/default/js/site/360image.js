

var xoay360 =function(frames){
      $("#360frames").spritespin({
        width     : 550,
        height    : 450,
        frames    : frames.length,
        behavior  : "drag", // "hold"
        module    : "360",
        sense     : -1,
        source    : frames,
        animate   : true,
        loop      : true,
        frameWrap : true,
        frameStep : 1,
        frameTime : 90,
        enableCanvas : false
      });
}
var xoay360thumb = function(frames){
	 $("#360sprite").spritespin({
        width     : 400,
        height    : 400,
        frames    : frames.length,
        //framesX   : 6,
        behavior  : "drag",
        module    : "360",
        sense     : -1,
        source    : frames,
        animate   : true,
        loop      : true,
        frameWrap : true,
		frameStep : 1,
        frameTime : 90,
        enableCanvas : false
      });
}