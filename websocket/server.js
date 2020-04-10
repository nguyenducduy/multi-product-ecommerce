var http = require('http');
var socketio = require('socket.io');
var qs = require('querystring');
var users = {}; //This will hold all of our registered clients
var usersInternal = new Array();	//This will hold the session id of logged employees (Internal User)

var app = http.createServer(function(req, res) 
{
    var postData = "";
    req.on('data', function(chunk) {
        postData += chunk; //Get the POST data
    });

    req.on('end', function() {
        var POST = qs.parse(postData);


		if(typeof(POST.data) !== "undefined")
		{
			var dataObj = JSON.parse(POST.data);

			for(var i = 0; i < dataObj.messages.length; i++)
			{
				currentMessage = dataObj.messages[i];
				console.log(currentMessage);
				
				var currentsessionid = currentMessage.sessionid;
				//check internal session
				if(currentMessage.emittype == 'pushnotification')
					currentsessionid = "_" + currentsessionid;
				
				if(typeof(users[currentsessionid]) !== "undefined") {
					
					
					if(currentMessage.emittype == 'pushnotification')
					{
						users[currentsessionid].emit(currentMessage.emittype, {
			                type: currentMessage.type,
			                url: currentMessage.url,
			                icon: currentMessage.icon,
			                meta: currentMessage.meta
			            });
					}
					else
					{
						console.log('Not found Emit type');
					}
		            
		        }
			}
		}
/*
        if(typeof(users[POST.sessionid]) !== "undefined") {
            users[POST.sessionid].emit("push", {
                data: POST.data //Send it!
            });
        }
*/
    });
    res.end();
}).listen(8080);  //Use a non-standard port so it doesn't override your Apache

var io = socketio.listen(app); //Attach socket.io to port 8080

io.sockets.on('connection', function(socket) {
    socket.on('register', function(data) { //Client registers so we know where to send
        users[data.sessionid] = socket;
		
		//check this is Internal User (Employee)
		if(typeof(data.internaluser) != "undefined" && usersInternal.indexOf(data.sessionid) < 0)
			usersInternal.push(data.sessionid);
		
		console.log("Current Connection = " + Object.size(users));
		console.log("Current Internal user = " + usersInternal.length);
    });

	socket.on('disconnect', function () {
		console.log("Socket disconnected");
		var deletesession = '';
		for(var key in users)
		{
			if(users[key].id == socket.id)
				deletesession = key;
		}
		
		//found session id to delete
		if(deletesession.length > 0)
		{
			//remove from all session
			delete users[deletesession];
			
			//remove Internal users
			if(usersInternal.indexOf(deletesession) >= 0)
				usersInternal.splice(usersInternal.indexOf(deletesession), 1);
			
			console.log("Delete socket " + deletesession);
			console.log(".Current Connection = " + Object.size(users));
			console.log(".Current Internal user = " + usersInternal.length);
		}
		//io.sockets.emit('pageview', { 'connections': Object.keys(io.connected).length});
    });

});



Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};
