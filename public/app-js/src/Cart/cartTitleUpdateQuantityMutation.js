export default (cartIndex, titleIndex, cartId, titleId, quantity) => {
  let variables = {}
  variables.REMOTEADDR = cartId;
  variables.ISBN = titleId;
  variables.REQUESTED = quantity;
  variables.cartIndex = cartIndex
  variables.titleIndex = titleIndex

  return {
    query:`mutation ($REMOTEADDR:String!, $ISBN:String!, $REQUESTED:Int!){
      carttitleupdatequantity(REMOTEADDR:$REMOTEADDR, ISBN:$ISBN, REQUESTED: $REQUESTED){
                    user {
                      vendor {
                        carts{
                          INDEX
                          KEY
                          DATE
                          PO_NUMBER
                          TRANSNO
                          REMOTEADDR
                          ISCOMPLETE
                          details{
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
          `, 
    variables: variables
  }
  
  };