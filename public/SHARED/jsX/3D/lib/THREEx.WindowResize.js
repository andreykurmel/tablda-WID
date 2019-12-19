var THREEx	= THREEx 		|| {};
var resized = false;
var UIoffset = 0;
var zoom = 1;

THREEx.WindowResize	= function(renderer, camera){
	var callback	= function(){
		var SCREEN_WIDTH = window.innerWidth; 
		var SCREEN_HEIGHT = window.innerHeight;
		camera.aspect = SCREEN_WIDTH / SCREEN_HEIGHT;
		renderer.setSize(SCREEN_WIDTH,SCREEN_HEIGHT); 
		/*
		The next line zooms the camera and tries to keep the onject at a 
		relatively same size independent of window or screen size.
		*/
		camera.fov = SCREEN_HEIGHT / 15;

		camera.updateProjectionMatrix();
	}
	window.addEventListener('resize', callback, false);
	return {
		/*
		  Stop watching window resize
		*/
		stop	: function(){
			window.removeEventListener('resize', callback);
		}
	};
}

function forceResize () {
	if(resized){
		UIoffset = 0;
		resized = false;}  
	else{
		UIoffset = 288;
		resized = true;} 

	var SCREEN_WIDTH = window.innerWidth + UIoffset; 
	var SCREEN_HEIGHT = window.innerHeight;
	renderer.setSize( SCREEN_WIDTH, SCREEN_HEIGHT );
	camera.aspect	= SCREEN_WIDTH / SCREEN_HEIGHT;
	renderer.setSize(SCREEN_WIDTH,SCREEN_HEIGHT); 
	camera.updateProjectionMatrix();
}

function interpolate(x1,x2,x3,y1,y3){
  var y2 = (((x2 - x1)*(y3 - y1))/(x3 - x1)) + y1;
  return(y2);
}

