import q from './reducers/queries'

export default (query, fragments=[],variables={}) => {

 if(!variables.cartsLimit) {variables['cartsLimit'] = 100}

  return {
    query: q.fragments(fragments,query), 
    variables: variables
  }
  
  };