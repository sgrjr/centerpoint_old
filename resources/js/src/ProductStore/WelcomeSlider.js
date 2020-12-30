import React from 'react';
import Carousel from 'react-material-ui-carousel'
import Box from '@material-ui/core/Box'
import {Link} from 'react-router-dom'

export default function WelcomeSlider(props)
{

    return (
        <Carousel interval={5000} animation={"slide"}>
            {
                props.slider.slides.map(function(item, i){
                   return <Slide key={i} item={item} />
                })
            }
        </Carousel>
    )


}
 
const Slide = function(props)
{

    return (
        <Box style={{width:"100%", margin:0, padding:0}}>
            <Link to={props.item.link? props.item.link:""}><img src={props.item.image} style={{width:"100%"}} alt={"slide"}/></Link>
        </Box>
    )
}
