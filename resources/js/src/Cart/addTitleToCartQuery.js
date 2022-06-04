import q from '../reducers/queries'

export default (variables) => {


 if(!variables.cartsLimit) {variables['cartsLimit'] = 100}

  return {
    
    query: q.fragments([ 'order','orderItem'],`mutation($input: UpdateCartTitleInput!, $cartsLimit: Int!) {
        updateOrCreateCartTitle(input: $input){

              vendor {
                carts(first:$cartsLimit){
                  paginatorInfo{
                    total
                    count
                  }
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