export default () => {
  let variables = {input:{}}

  return {
    query:`  mutation ($input: CreateCartInput!){
                createCart (input:$input) {
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