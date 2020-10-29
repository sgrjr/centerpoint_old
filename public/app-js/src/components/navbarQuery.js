export default (variables = {}) => {
  return {
  
  query:`query {
    viewer{
      csrftoken
      browse{
        title
         items{
           url
           text
           icon
         }
       }
       catalog (id:"current_catalog"){
        image_link
        pdf_link
      }
  searchfilters
  slider {
    height
    background_color
    slides {
      image
      caption
      link
    }
  }
  links{
    main {
      url
      text
      icon
    }
    drawer {
      url
      text
      icon
    }
  }
      user {
        key
        name
        email
        authenticated
        token
        photo
        vendor{
          cartscount
          processingcount
        }
      }
    }
  }
  `, 
  variables: variables
}

};