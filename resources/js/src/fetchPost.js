import fetch from 'cross-fetch'
import auth from './authorization'

export default function(url, data, options, actions) {

  let opt = {
    method:options.method? options.method:"POST",
    url: url,

    headers: {
      ...options.headers
    }
  }

if(auth.token() !== null){
  opt.headers.Authorization = "Bearer " + auth.token()
}

var formBody = [];
for (var property in data) {
  var encodedKey = encodeURIComponent(property);
  var encodedValue = encodeURIComponent(data[property]);
  formBody.push(encodedKey + "=" + encodedValue);
}
formBody = formBody.join("&");
  let requestData = {
      method: opt.method,
      body: formBody,
      headers: opt.headers
  }

  return dispatch => {
      dispatch(actions.pending(opt.url))

     return fetch(opt.url,requestData)
      .then(res => res.json())
      .then(res => {

          if(res.errors) {
              dispatch(actions.error(res.errors))
          }else{
            dispatch(actions.success(res));
          }
      })
      .catch(error => {
          dispatch(actions.error([error]));
      })
  }
}