export default (variables) => {

  return {

    query:`query {
        viewer {
          vendor {
            carts (first:100){
                paginatorInfo{
                    total
                    count
                    perPage
                    currentPage
                }
                data{
                    INDEX
                    KEY
                    DATE
                    PO_NUMBER
                    TRANSNO
                    REMOTEADDR
                    ISCOMPLETE
                    items{
                        id
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