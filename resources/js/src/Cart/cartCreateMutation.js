export default () => {
  let variables = {}

  return {
    query:`  mutation {
                createCart {
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
          `, 
    variables: variables
  }
  
  };