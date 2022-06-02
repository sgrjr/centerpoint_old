<template>
<div :class="[isActive ? 'cart-is-open' : 'cart-is-closed']">
    <button @click="isActive = !isActive" type="button" aria-label="open drawer">
        <Icon name="shopping-cart"/>
        <Icon name="show-more"/>
    </button>
    <div class="cart" style="transform: none; transition: transform 225ms cubic-bezier(0, 0, 0.2, 1) 0ms;">
        <CustomButton 
            class="default-contained" 
            startIcon="minimize" 
            endIcon="shopping-cart2" 
            text="shop" 
            id="" 
            clickHandler=""/>
        <button tabindex="0" type="button">
            <span class="MuiButton-label">Create New Cart
                <span class="MuiButton-endIcon MuiButton-iconSizeMedium">
                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-i4bv87-MuiSvgIcon-root" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="AddIcon" style="font-size: unset;"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path></svg>
                </span>
            </span>
        </button>
    <div>
        <div class="MuiButtonBase-root MuiAccordionSummary-root Mui-expanded" tabindex="0" role="button" aria-disabled="false" aria-expanded="true" aria-controls="panel1a-content" id="panel1a-header" style="background-color: rgba(0, 0, 0, 0.12);">
            <div class="MuiAccordionSummary-content Mui-expanded">
                <span class="MuiBadge-root">
                    <p class="MuiTypography-root makeStyles-heading-34 MuiTypography-body1"> (20220531)</p>
                    <button tabindex="0" type="button" aria-label="edit title"><span class="MuiIconButton-label">
                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-i4bv87-MuiSvgIcon-root" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="CreateIcon" style="font-size: unset;"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg></span>
                    </button>
                    <span class="MuiBadge-badge MuiBadge-anchorOriginTopLeftRectangular MuiBadge-colorPrimary MuiBadge-invisible">0</span>
                </span>
            </div>
            <div class="MuiButtonBase-root MuiIconButton-root MuiAccordionSummary-expandIcon Mui-expanded MuiIconButton-edgeEnd" aria-disabled="false" aria-hidden="true">
                <span class="MuiIconButton-label">
                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-i4bv87-MuiSvgIcon-root" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ExpandMoreIcon" style="font-size: unset;"><path d="M16.59 8.59 12 13.17 7.41 8.59 6 10l6 6 6-6z"></path></svg>
                </span>
            </div>
        </div>

        <div class="MuiCollapse-root MuiCollapse-entered" style="min-height: 0px;">
            <div class="MuiCollapse-wrapper">
                <div class="MuiCollapse-wrapperInner">
                    <div aria-labelledby="panel1a-header" id="panel1a-content" role="region">
                        <div class="MuiAccordionDetails-root">
                            <ul class="MuiList-root MuiList-padding">
                                <li class="MuiListItem-root MuiListItem-gutters">No items</li>
                            </ul>
                        </div>
                        <hr class="MuiDivider-root MuiDivider-middle"/>
                        <footer class="cart-footer">
                            <p class="MuiTypography-root MuiTypography-body1 total css-ahj2mt-MuiTypography-root">Cart total: <strong>$0.00</strong></p>
                            <button id="delete-cart" class="error-outlined">
                                <span class="text">delete cart</span>
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-i4bv87-MuiSvgIcon-root" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="DeleteIcon" style="font-size: unset;"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
                            </button>
                            <p>Add 5 more books to get free shipping!</p>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</template>

<style lang="scss">
.cart-is-open{
    .cart{
        display:block;
        left: auto;
        right: 0;
        top: 0;
        flex: 1 0 auto;
        height: 100%;
        display: flex;
        outline: 0;
        z-index: 1200;
        position: fixed;
        overflow-y: auto;
        flex-direction: column;
        box-shadow: 0px 8px 10px -5px rgb(0 0 0 / 20%), 0px 16px 24px 2px rgb(0 0 0 / 14%), 0px 6px 30px 5px rgb(0 0 0 / 12%);
        color: rgba(0, 0, 0, 0.87);
        transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        background-color: #fff;

        button{
            font-family: inherit;
            padding: 10px;
            margin: 0;
            border-radius: 0;
            font-size: 1em;
            text-align: center;
            vertical-align: middle;
            color: white;
            border: solid 1px #858585;
            background-color: #858585;
        }
    }
}

.cart-is-closed{
    .cart{
        display:none;
    }
}

.cart-img {
  width: 100px;
}

.cart-footer {
    display: grid;
    grid-template-columns: 1fr auto;
    grid-gap: 8px;
    padding: 8px 24px;
    align-items: center;

  .incentive {
    grid-column: span 2;
    font-size: .8rem;
    text-align: right;
  }
  .total {
    font-size: 1rem;
  }

}
  
.review-cart {
  width:100%;

  p{
  display:inline;
  } 

  .items-qty {
    float:right;
    position:absolute;
    top: $standard_margin+50;
    right: $standard_margin;
    width:150px;
  }

  .MuiAccordionDetails-root {
    width:100%;

    ul {
    width:100%;
    border:none;
    }
  }

  .cart-footer {
    #delete-cart{
      position:absolute;
      top: $standard_margin;
      right: $standard_margin;
      width:150px;
    }
  }

}
</style>

<script>
import Icon from './Icon.vue'
import CustomButton from './CustomButton.vue'

export default {
  props: ['status'],
  setup(props) {
    //console.log(props)
  },
  components: {
      CustomButton,
      Icon
  },
  data() {
    return {
      isActive: false,
    }
  },
}
</script>

