export default (REMOTEADDR, ISBN) => {
  let variables = {}
  variables.REMOTEADDR = REMOTEADDR;
  variables.ISBN = ISBN;

  return {
    query:`  mutation ($REMOTEADDR:String, $ISBN:String!){
      carttitledelete(REMOTEADDR:$REMOTEADDR, ISBN:$ISBN){
                    user {
                      vendor {
                        carts {
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