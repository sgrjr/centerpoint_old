export default (REMOTEADDR) => {
  let variables = {}

  return {
    query:`  mutation ($REMOTEADDR:String){
                deleteCart(REMOTEADDR:$REMOTEADDR){
                    user {
                      vendor {
                        carts(first:100){
                         data{
                           INDEX
                            KEY
                            DATE
                            PO_NUMBER
                            TRANSNO
                            REMOTEADDR
                            ISCOMPLETE
                            items{
                              INDEX
                              PROD_NO
                              TITLE
                              REQUESTED
                              SALEPRICE
                              defaultImage
                              AUTHORKEY
                              url
                            }
                         }
                        }
                      }
                    }
                  }
            }  
          `, 
    variables: variables
  }
  
  };