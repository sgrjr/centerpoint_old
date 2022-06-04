import React from 'react';
import Carousel from 'react-material-ui-carousel'
import Box from '@material-ui/core/Box'
import {Link} from 'react-router-dom'

function getSlides(slider){
     if(slider && slider !== null){
            return slider.slides
        }else{
            return [];
    }
}

export default function WelcomeSlider(props)
{
    const slides = getSlides(props.slider)
    return (
        <Carousel interval={5000} animation={"slide"}>
            {
                slides.map(function(item, i){
                   return <Slide key={i} item={item} />
                })
            }
        </Carousel>
    )


}
 
const Slide = function(props)
{

    return (
        <Box>
            <Link to={props.item.link? props.item.link:""}><img src={props.item.image} style={{width:"100%", minHeight:"190px"}} alt={"slide"}/></Link>
        </Box>
    )
}
