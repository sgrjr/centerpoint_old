const chokidar = require('chokidar');

const watchThis = 'C:\\resources\\data\\Stephen_Reynolds\\WEBINFO\\RWDATA';

// Initialize watcher.
const watcher = chokidar.watch(watchThis, {
  ignored: /(^|[\/\\])\../, // ignore dotfiles
  persistent: true,
  depth:0
});

// Something to use when events are received.
const log = console.log.bind(console);
// Add event listeners.
watcher
  .on('add', path => log(`File ${path} has been added`))
  .on('change', (path, stats) => {
    log(`File ${path} has been changed`)
    if (stats) console.log(`File ${path} changed size to ${stats.mtime}`);
    })
  .on('unlink', path => log(`File ${path} has been removed`))
  .on('error', error => log(`Watcher error: ${error}`))
  .on('ready', () => log('Initial scan complete. Ready for changes'))
  .on('raw', (event, path, details) => { // internal
    //run even when a file is just opened
    //log('Raw event info:', event, path, details);
  });