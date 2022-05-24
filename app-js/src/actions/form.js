import graphql from '../fetchGraphQL'

/* FORM TYPES AND CREATORS */ 
const form = { 

  FORM_UPDATE: 
  {
      type: 'FORM_UPDATE',   
      creator: (e) => {
        const actions ={
          updateInput: form.FORM_UPDATE_SUCCESS.creator,
          updateProfileImageSource: form.UPDATE_PROFILE_IMAGE_SOURCE.creator
        }
        return validateInput(e, actions);
      }
  },

  FORM_UPDATE_SUCCESS: 
  {
      type: 'FORM_UPDATE_SUCCESS',   
      creator: (form, field, input) => {
        return { type: 'FORM_UPDATE_SUCCESS', form: form, field: field, input: input }
      }
  },

  UPDATE_PROFILE_IMAGE_SOURCE_SUCCESS: 
  {
      type: 'UPDATE_PROFILE_IMAGE_SOURCE_SUCCESS',   
      creator: (form, field, input) => {
        return { type: 'FORM_UPDATE_SUCCESS', form: form, field: field, input: input }
      }
  },
  UPLOAD: 
  {
    type: 'UPLOAD',   
    creator: (file) => {

      const query = {
        query: `mutation($file: Upload!) {
        userprofilephoto(profilePicture:$file){
          user{
            photo
          }
        }
      }`,
    variables: {
      file: file
    }
  };

      const actions = {
        pending: form.UPLOAD_PENDING.creator,
        success: form.UPLOAD_SUCCESS.creator,
        error: form.UPLOAD_ERROR.creator
      }

      const opt = {
        contentType: "multipart/form-data",
        file:file
      }
    
      return graphql(query, actions, opt)
    }
  },
  
  UPLOAD_PENDING: 
  {
      type: 'UPLOAD_PENDING',   
      creator: () => {
        return { type: 'UPLOAD_PENDING' }
      }
  },
  UPLOAD_SUCCESS: 
  {
      type: 'UPLOAD_SUCCESS',   
      creator: (payload) => {
        if(payload.userprofilephoto.user.photo !== null){
          return { type: 'UPLOAD_SUCCESS', payload: payload.userprofilephoto.user.photo }
        }else{
          const error = {
            message: "Upload Failed!",
            extensions: {
              "category": "graphql"
            },
            locations: [
              {
                "line": 3,
                "column": 5
              }
            
          ]};

          return { type: 'UPLOAD_ERROR', errors: [error] }
        }
        
      }
  },

  UPLOAD_ERROR: 
  {
      type: 'UPLOAD_ERROR',   
      creator: (errors) => {
        
        let error = {
          message: "Upload Failed!",
          extensions: {
            "category": "graphql"
          },
          locations: [
            {
              "line": 3,
              "column": 5
            }
          
        ]};
        
        return { type: 'UPLOAD_ERROR', errors: [error] }
      }
  },

  UPDATE_PROFILE_IMAGE_SOURCE: 
  {
      type: 'UPDATE_PROFILE_IMAGE_SOURCE',   
      creator: (form, field, value) => {
        return { type: 'UPDATE_PROFILE_IMAGE_SOURCE', input: value }
      }
  },
}

export default form;

/**
 * 
 * 

  const checkMimeType = (event)=>{
    //getting file object
    let files = event.target.files 
    //define message container
    let err = ''
    // list allow mime type
   const types = ['image/png', 'image/jpeg', 'image/gif']
    // loop access array
    for(var x = 0; x<files.length; x++) {
     // compare file type find doesn't matach
         if (types.every(type => files[x].type !== type)) {
         // create error message and assign to container   
         err += files[x].type+' is not a supported format\n';
       }
     };
  
   if (err !== '') { // if message not same old that mean has error 
        event.target.value = null // discard selected file
        setFeedback(err)
         return false; 
    }
   return true;
  
  }

  const checkFileSize = (event)=>{
    let files = event.target.files
    let size = 50000 
    let err = ""; 
    for(var x = 0; x<files.length; x++) {
      setFeedback("Size: " + files[x].size)
    if (files[x].size > size) {
     err += files[x].type+' is too large, please pick a smaller file\n';
   }
 };
 if (err !== '') {
    event.target.value = null
    setFeedback(err)
    return false
}

return true;

}
 */

 const validateInput = (e, actions) => {
      const formName = e.target.form.name
      const fieldName = e.target.name

      return dispatch => {

        switch(formName){
          case 'photo':

            var files = e.target.files[0]
            // if(checkMimeType(event) && checkFileSize(event)){ 
               var reader = new FileReader();
           
               reader.onload = function (event) {
                  dispatch(actions.updateProfileImageSource(formName, "imageSource", event.target.result))
              }
              
              reader.readAsDataURL(files)
            
                dispatch(
                  actions.updateInput(
                    formName, fieldName, files
                  )
                )
               
           //}

            break;
          default:
            dispatch(
              actions.updateInput(formName, fieldName, e.target.value)
                )
        }
      }
 }