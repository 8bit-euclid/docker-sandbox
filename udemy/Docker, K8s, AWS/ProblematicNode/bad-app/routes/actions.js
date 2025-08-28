var express = require('express');
var process = require('process');

module.exports = function(app, toggleRequestAcceptance) {
  var router = express.Router();

  router.get('/crash', function(req, res, next) {
    process.exit();
  });
  
  router.get('/freeze', function(req, res, next) {
    while(true) {}
  });

  router.get('/mute', function(req, res, next) {
    toggleRequestAcceptance();
  });

  function heavyTask(chunkDuration, totalDuration, callback) {
    let start = Date.now();
    function chunk() {
        while (Date.now() - start < chunkDuration) {
            // Intensive task (busy loop)
        }
        if (Date.now() - start < totalDuration) {
            // Yield to the event loop and schedule the next chunk
            setTimeout(chunk, 0); // setTimeout with 0 to run at the next tick
        } else {
            if (typeof callback === "function") {
                callback();
            }
        }
        // Reset start time for the next chunk
        start = Date.now();
    }
    chunk();
  }

   
  router.get('/load', function(req, res, next) {
    heavyTask(100, 10000, function() {
      res.send('done!');
    });
  });

  return router;
}
