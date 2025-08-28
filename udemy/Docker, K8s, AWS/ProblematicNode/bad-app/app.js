var createError = require('http-errors');
var express = require('express');
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');
var process = require('process');

var indexRouter = require('./routes/index');
var actionsRouter = require('./routes/actions');

var app = express();

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'jade');

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(express.static(path.join(__dirname, 'public')));

let acceptRequests = true;

// Middleware to check if the server should accept requests
app.use((req, res, next) => {
  if (!acceptRequests) {
    return; //  res.status(503).send('Server is temporarily not accepting requests.');
  }
  next();
});

// Example of toggling the flag
function toggleRequestAcceptance() {
  acceptRequests = !acceptRequests;
}

app.use('/', indexRouter);
app.use('/action', actionsRouter(app, toggleRequestAcceptance));

// catch 404 and forward to error handler
app.use(function(req, res, next) {
  next(createError(404));
});

// error handler
app.use(function(err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};

  // render the error page
  res.status(err.status || 500);
  res.render('error');
});

module.exports = app;
