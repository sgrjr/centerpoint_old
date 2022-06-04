
function queries(list){

  const application = `fragment ApplicationFragment on Application {
     client
      domain
      appDescription
      siteName
      searchFilters

      browse {
        title
        items {
          url
          text
          icon
        }
      }

      catalog(id: $catalogId) {
        image_link
        pdf_link
      }

      links {
        drawer {
          url
          text
          icon
        }
        main {
          url
          text
          icon
        }
        shortCuts {
          url
          text
          icon
        }
      }

      slider {
        height
        background_color
        slides {
          image
          caption
          link
        }
      }
}`

const invoice = `fragment InvoiceFragment on Invoice{
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
}`

const orderItem = `fragment OrderItemFragment on OrderItem{
  id
  INDEX
  PROD_NO
  TITLE
  REQUESTED
  SALEPRICE
  coverArt
  AUTHOR
  AUTHORKEY
  url
  INVNATURE
}`

const order = `fragment OrderFragment on Order {
  id
  INDEX
  KEY
  DATE
  PO_NUMBER
  TRANSNO
  REMOTEADDR
  ISCOMPLETE               
  ATTENTION
  EMAIL
  CINOTE
  CXNOTE
  BILL_1
  BILL_2
  BILL_3
  BILL_4
}`

const paginator = `fragment PaginatorInfoFragment on PaginatorInfo{
  total
  count
  perPage
  currentPage
  firstItem
  lastItem
  hasMorePages
}`

const title = `fragment TitleFragment on Title {
              id
              INDEX
              ISBN
              TITLE
              INVNATURE
              FLATPRICE
              LISTPRICE
              isClearance
              PUBDATE
              coverArt
              AUTHORKEY
              AUTHOR
              STATUS
              FORMAT
              SUBTITLE
              HIGHLIGHT
              CAT
              PAGES
              MARC
              marcLink{
                view
                download
              }
        }`

const userData = `fragment UserDataFragment on UserData{
        isbn
        price
        discount
        purchased
        onstandingorder
      }`

const vendor = paginator + order + orderItem + ` fragment VendorFragment on Vendor {
    cartsCount
    processingCount
    carts(first:$cartsLimit){
      paginatorInfo{
          ...PaginatorInfoFragment
      }
      data{
        ...OrderFragment
          items {
            ...OrderItemFragment
          }
      }
    }
}`

const user = `fragment UserFragment on User {
    KEY
    name
    EMAIL
    photo
     id
}`

const fragments = {
  application: application,
  order:order,
  orderItem:orderItem,
  paginator:paginator,
  title:title,
  vendor:vendor,
  user:user,
  userData:userData
}

let fragmentString = ''

list.map((fr)=>{
  fragmentString += fragments[fr]
})
return fragmentString

}

export default {
  fragments: (frags, queryString) => {
      return queries(frags) + ` ` + queryString
    }
}