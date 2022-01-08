import graphql from '../fetchGraphQL'
import post from '../fetchPost'

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
        return { type: 'FORM_UPDATE_SUCCESS', form: form, field: field, input: input, message:{message:"Form changed.", severity:"info"} }
      }
  },

  UPDATE_PROFILE_IMAGE_SOURCE_SUCCESS: 
  {
      type: 'UPDATE_PROFILE_IMAGE_SOURCE_SUCCESS',   
      creator: (form, field, input) => {
        return { type: 'FORM_UPDATE_SUCCESS', form: form, field: field, input: input, message: {message:"Profile Photo Updated.", severity:"success"} }
      }
  },
  UPLOAD: 
  {
    type: 'UPLOAD',   
    creator: (file) => {

      const query = {
        query: `mutation($file: Upload!) {
        userProfilePhoto(profilePicture:$file){
            photo
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
        if(payload.userProfilePhoto.photo !== null){
          return { type: 'UPLOAD_SUCCESS', payload: payload.userProfilePhoto.photo, message:{message:"File Uploaded.", severity:"success"} }
        }else if(payload.errors){
          return { type: 'UPLOAD_ERROR', errors: payload.errors }
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
        return { type: 'UPLOAD_ERROR', errors: errors }
      }
  },

  UPDATE_PROFILE_IMAGE_SOURCE: 
  {
      type: 'UPDATE_PROFILE_IMAGE_SOURCE',   
      creator: (form, field, value) => {
        return { type: 'UPDATE_PROFILE_IMAGE_SOURCE', input: value }
      }
  },

   DOWNLOAD_ALL_MARCS: 
  {
    type: 'DOWNLOAD_ALL_MARCS',   
    creator: ({isbns}) => {

      const query = {
        query: `mutation($isbns: [String]!) {
        getMarcs(isbns:$isbns){
            zip
            isbns
        }
      }`,
    variables: {
      isbns: isbns
    }
  };
      const actions = {
        pending: form.DOWNLOAD_MARCS_PENDING.creator,
        success: form.DOWNLOAD_MARCS_SUCCESS.creator,
        error: form.DOWNLOAD_MARCS_ERROR.creator
      }

      const opt = {}
    
      return graphql(query, actions, opt)
    }
  },

  DOWNLOAD_MARCS_PENDING: 
  {
      type: 'DOWNLOAD_MARCS_PENDING',   
      creator: (opts) => {
            let isbns = ''

            opts.isbns.map(function(isbn){
              isbns += ", " + isbn
            })

        return { type: 'DOWNLOAD_MARCS_PENDING', opts: opts, message:{message:"Marcs are being zipped with " + isbns, severity:"success"}}
      }
  },

  DOWNLOAD_MARCS_SUCCESS: 
  {
      type: 'DOWNLOAD_MARCS_SUCCESS',   
      creator: (payload) => {
        return { type: 'DOWNLOAD_MARCS_SUCCESS', payload: payload.getMarcs, message:{message:"Marcs are downloading.["+payload.getMarcs.isbns.length+"]", severity:"success"} }
      }
  },

  CLEAR_MARC:{
      type: 'CLEAR_MARC',   
      creator: () => {
        return { type: 'CLEAR_MARC', message:{message:"Marcs cleared.", severity:"success"} }
      }
  },


  DOWNLOAD_MARCS_ERROR: 
  {
      type: 'DOWNLOAD_MARCS_ERROR',   
      creator: (errors) => {
        
        let error = {
          message: "Zipping Marcs failed!",
          extensions: {
            "category": "file zipping"
          },
          locations: [
            {
              "line": 1,
              "column": 1
            }
          
        ]};

        errors.push(error)
        
        return { type: 'DOWNLOAD_MARCS_ERROR', errors: errors }
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