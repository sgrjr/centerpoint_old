
const path = require('path');

const ruleChildren = loader =>
  loader.use || loader.oneOf || (Array.isArray(loader.loader) && loader.loader) || [];

const findIndexAndRules = (rulesSource, ruleMatcher) => {
  let result = undefined;
  const rules = Array.isArray(rulesSource) ? rulesSource : ruleChildren(rulesSource);
  rules.some(
    (rule, index) =>
      (result = ruleMatcher(rule)
        ? {
            index,
            rules,
          }
        : findIndexAndRules(ruleChildren(rule), ruleMatcher)),
  );
  return result;
};

const createLoaderMatcher = loader => rule =>
  rule.loader && rule.loader.indexOf(`${path.sep}${loader}${path.sep}`) !== -1;
const fileLoaderMatcher = createLoaderMatcher('file-loader');

const addBeforeRule = (rulesSource, ruleMatcher, value) => {
  const { index, rules } = findIndexAndRules(rulesSource, ruleMatcher);
  rules.splice(index, 0, value);
};

function rewireMD(config) {
  const mdLoader = {
    test: /\.md$/,
    use: [
      { loader: require.resolve('raw-loader') }
    ],
  };

  addBeforeRule(config.module.rules, fileLoaderMatcher, mdLoader);

  config.output.path =  path.resolve(__dirname, '../..') + "/public/compiled"
  return config;
}

module.exports = rewireMD;