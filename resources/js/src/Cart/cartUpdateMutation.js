import q from '../reducers/queries'

export default (variables) => {

  if(!variables.cartsLimit) {variables['cartsLimit'] = 100}

  return {

    query: q.fragments([ 'order','orderItem','invoice'],` mutation ($input: UpdateCartInput!, $cartsLimit:Int!){
                updateOrCreateCart(input: $input){
                  vendor{
                    carts(first:$cartsLimit){
                      data{
                         ...OrderFragment
                          items{
                           ...OrderItemFragment
                          }
                          invoice {
                            ...InvoiceFragment
                          }
                      }
                    }
                  }
                         
                }
            }  
          `), 
    variables: variables
  }
  
  };