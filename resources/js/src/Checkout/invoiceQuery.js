export default (variables) => {

  return {

    query:`query ( $REMOTEADDR:String!) {
      viewer {

            cart (REMOTEADDR:$REMOTEADDR){
              id
              INDEX
              KEY
              DATE
              PO_NUMBER
              TRANSNO
              REMOTEADDR
              ISCOMPLETE
              BILL_1
              BILL_2
              BILL_3
              BILL_4
              CINOTE
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
              invoice {
                id
                title
                dates
                headings
                totaling{
                  subtotal
                  shipping
                  paid
                  grandtotal
                }
                company_logo
                company_website
                company_name
                company_address
                company_telephone
                company_email
                customer_name
                customer_address
                customer_email
                thanks
                invoice_memo
                footer_memo
              }
            }
          }
        
      
    }  
    `, 
    variables: variables
  }
  
  };