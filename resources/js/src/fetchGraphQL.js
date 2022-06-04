import fetch from 'cross-fetch'
import auth from './authorization'

export default function(query, actions, opt1={}) {

  let opt = {
    method:"POST",
    url: "/graphql",
    headers: {
      'Accept': 'application/json',
      'Content-Type': "application/json"
    }
  }

if(auth.token() !== null){
  opt.headers.Authorization = "Bearer " + auth.token()
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

         let err = {
          debugMessage:error,
          message:"["+actions.action + "] Request failed!",
          severity:"warning",
          extensions:{
            reason:"Lazy Programmer cut a corner."
          }
         }

          dispatch(actions.error([err]));
      })

  }
}