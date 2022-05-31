import actions from '../actions'

const initState = {
        login: {
            email: "",
            password: "",
            errors: {
                email:"",
                password: ""
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

export default (state = initState, action)=>{
    let ns = null

    switch (action.type) {

        case actions.auth.AUTH_ERROR.type:
            ns = Object.assign({}, state)
            ns.login.errors.email = ""
            ns.login.errors.password = ""
            action.errors.map((er)=>{
                if(er.extensions.category === "validation"){
                    ns.login.errors.email += er.extensions.validation.EMAIL? er.extensions.validation.EMAIL.join(","):""
                    ns.login.errors.password += er.extensions.validation.password? er.extensions.validation.password.join(","):""
                }
            })
            return ns;

        case actions.auth.AUTH_SUCCESS.type:
            ns = Object.assign({}, state)
            ns.login.errors.email = null
            ns.login.errors.password = null
            return ns;

        case actions.form.FORM_UPDATE_SUCCESS.type:
            ns = Object.assign({}, state)
            ns[action.form][action.field] = action.input
            return ns;
        
        case actions.form.UPDATE_PROFILE_IMAGE_PENDING.type:
            ns = Object.assign({}, state)

            if(action.input === false){
                ns.photo = {
                    selectedFile: {},
                    completed: [],
                    imageSource: null,
                    errors: {
                        selectedFile:null
                    }
                }
            }else{
                ns.photo.imageSource = action.input;
            }
            
            return ns;

        default:
            return state
      }
}