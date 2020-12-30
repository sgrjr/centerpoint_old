export default (REMOTEADDR, ISBN) => {
  let variables = {}
  variables.REMOTEADDR = REMOTEADDR;
  variables.ISBN = ISBN;

  return {
    query:`  mutation ($REMOTEADDR:String, $ISBN:String!){
      cartTitleDelete(REMOTEADDR:$REMOTEADDR, ISBN:$ISBN){

                      vendor {
                        carts {
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
                              coverArts
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