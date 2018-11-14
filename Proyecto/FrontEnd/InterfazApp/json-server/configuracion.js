// script que configura al json-server con HTTPS
// Referencia: https://github.com/typicode/json-server/issues/244

/*para crear los archivos "key.pem" y "cert.pem" se utilizo el comando:
    openssl req -x509 -newkey rsa:2048 -keyout key.pem -out cert.pem -days 120 -nodes
*/

var fs = require('fs'),
  https = require('https'),
  jsonServer = require('json-server'),
  server = jsonServer.create(),
  router = jsonServer.router('db.json'),
  middlewares = jsonServer.defaults();

var options = {
  key: fs.readFileSync('./key.pem'),
  cert: fs.readFileSync('./cert.pem')
};

//agrego reglas o rutas falsas simulando REST API
server.use(jsonServer.rewriter({
  '/restaurant/read.php': '/read',
  '/restaurant/create.php': '/salida'
}));

server.use(middlewares);
server.use(router);

https.createServer(options, server).listen(3003, function() {
  console.log("\tjson-server started on port " + 3003);
  console.log("Rutas:")
  console.log("/restaurant/read.php <- GET de TODOS los marcadores.");
  console.log("/restaurant/create.php <- POST 1 nuevo marcador.");
  
  
});