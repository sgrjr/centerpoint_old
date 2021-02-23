import fetch from 'cross-fetch'
import auth from './authorization'

export default function(url, actions, opt1={}) {

  let opt = {
    method:"POST",
    url: url,

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