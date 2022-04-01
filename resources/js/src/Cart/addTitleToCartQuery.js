export default (variables) => {

  return {

    query:`mutation($input: UpdateCartTitleInput!) {
        updateOrCreateCartTitle(input: $input){

              vendor {
                carts(first:12){
                  paginatorInfo{
                    total
                    count
                  }
                  data{
                    INDEX
                    KEY
                    DATE
                    PO_NUMBER
                    TRANSNO
                    REMOTEADDR
                    items{
                      id
                      INDEX
                      PROD_NO
                      TITLE
                      REQUESTED
                      SALEPRICE
                      coverArt
                      AUTHOR
                      AUTHORKEY
                      STATUS
                      INVNATURE
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