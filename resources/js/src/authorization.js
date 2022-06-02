
const auth = {
    token: function(){
        return localStorage.getItem("centerpoint_authorization_token");
    },

    destroy: function(){
        return localStorage.removeItem("centerpoint_authorization_token")
    },

    store: function(token){
        return localStorage.setItem("centerpoint_authorization_token", token)
    }
}

export default auth;

