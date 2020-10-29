const rewireMD = require('./utils/cra-rewire-md');

module.exports = function override(config, env) {
  
  //do stuff with the webpack config...
  config = rewireMD(config, env);

  return config;
}