export default (REMOTEADDR, ISBN) => {
  let variables = {}
  variables.REMOTEADDR = REMOTEADDR;
  variables.ISBN = ISBN;

  return {
    query:`  mutation ($REMOTEADDR:String, $ISBN:String!){
      deleteCartTitle(input:{REMOTEADDR:$REMOTEADDR, ISBN:$ISBN}){

                      vendor {
                        carts {
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
          `, 
    variables: variables
  }
  
  };