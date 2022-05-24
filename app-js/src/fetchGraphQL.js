import fetch from 'cross-fetch'
import auth from './authorization'

export default function(query, actions, opt1={}) {

  let opt = {
    method:"POST",
    url: window.INITIAL_STATE.graphqlurl? window.INITIAL_STATE.graphqlurl:"http://localhost/graphql",
    headers: {
      'Accept': 'application/json',
      'Content-Type': "application/json",
      'Authorization' :"Bearer " + auth.token()
    }
  }


  let data = {
      method: opt.method,
      body: null,
      headers: opt.headers
  }

if(opt1.file !== undefined && opt1.file !== null && opt1.file !== ""){
  delete opt.headers['Content-Type'];
  
  data.body = new FormData();
  data.body.set('operations', JSON.stringify({
    'query':query.query,
    'variables': query.variables
  }));
  data.body.set('operationName', null);
  data.body.set('map', JSON.stringify({"file":["variables.file"]}));
  data.body.append('file', opt1.file);

}else{
  data.body = JSON.stringify(query)
}

  return dispatch => {
      dispatch(actions.pending(query.variables))

     return fetch(opt.url,data)
      .then(res => res.json())
      .then(res => {

          if(res.errors) {
              dispatch(actions.error(res.errors))
          }else{
            dispatch(actions.success(res.data));
          }
          
      })
      .catch(error => {
        
          dispatch(actions.error([error]));
      })
  }
}