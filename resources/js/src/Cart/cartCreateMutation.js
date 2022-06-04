import q from '../reducers/queries'

export default () => {
  let variables = {
    input:{},
    cartsLimit:100
  }

  return {
    query: q.fragments([ 'order','orderItem'],` mutation ($input: UpdateCartInput!, $cartsLimit: Int!){
                updateOrCreateCart (input:$input) {
                      vendor {
                        carts(first:$cartsLimit){
                          data{
                            ...OrderFragment
                            items{
                              ...OrderItemFragment
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