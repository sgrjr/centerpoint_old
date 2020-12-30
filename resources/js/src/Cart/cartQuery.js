export default (variables) => {

  return {

    query:`query {
        viewer {
          vendor {
            carts {
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
                    items {
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