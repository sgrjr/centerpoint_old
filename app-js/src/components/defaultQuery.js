export default (variables = {}) => {
  return {
  
  query:`{viewer{csrftoken}}`, 
  variables: variables
}

};