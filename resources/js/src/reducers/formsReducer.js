import actions from '../actions'

const initState = {
        login: {
            email: "",
            password: "",
            errors: {
                email:null,
                password: null
            }
        },
        photoStaging:false,
        photo: {
            selectedFile: {},
            completed: [],
            imageSource: null,
            errors: {
                selectedFile:null
            }
        }
}

export default (state = initState,action)=>{

    switch (action.type) {

        case actions.form.FORM_UPDATE_SUCCESS.type:
            let ns = Object.assign({}, state)
            ns[action.form][action.field] = action.input
            return ns;
        
        case actions.form.UPDATE_PROFILE_IMAGE_PENDING.type:
            let ns1 = Object.assign({}, state)

            if(action.input === false){
                ns1.photo = {
                    selectedFile: {},
                    completed: [],
                    imageSource: null,
                    errors: {
                        selectedFile:null
                    }
                }
            }else{
                ns1.photo.imageSource = action.input;
            }
            
            return ns1;

        default:
            return state
      }
}