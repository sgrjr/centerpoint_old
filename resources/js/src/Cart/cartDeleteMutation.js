export default (variables) => {

  return {
    query:`  mutation ($REMOTEADDR:String!){
                deleteCart(input:{REMOTEADDR:$REMOTEADDR}){
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
                              coverArt
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