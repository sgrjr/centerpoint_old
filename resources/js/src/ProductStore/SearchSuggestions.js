import * as React from 'react';
import ImageList from '@mui/material/ImageList';
import ImageListItem from '@mui/material/ImageListItem';
import ImageListItemBar from '@mui/material/ImageListItemBar';
import IconButton from '@mui/material/IconButton';
import StarBorderIcon from '@mui/icons-material/StarBorder';
import WithRouter from '../components/WithRouter'

function srcset(image, width, height, rows = 1, cols = 1) {
  return {
    src: `${image}?w=${width * cols}&h=${height * rows}&fit=crop&auto=format`,
    srcSet: `${image}?w=${width * cols}&h=${
      height * rows
    }&fit=crop&auto=format&dpr=2 2x`,
  };
}

function CustomImageList({itemData, navigate}) {
  return (
    <ImageList
      sx={{
        width: 1000,
        height:"100%",
        // Promote the list into its own layer in Chrome. This costs memory, but helps keeping high FPS.
        transform: 'translateZ(0)',
      }}
      rowHeight={200}
      gap={1}
      style={{overflow:"hidden"}}
    >
      {itemData.map((item, k) => {
        const cols = item.featured ? 2 : 1;
        const rows = item.featured ? 2 : 1;
        return (
          <ImageListItem key={k} cols={cols} rows={rows} >
            {item.url}
            <img
              {...srcset(item.coverArt, 250, 200, rows, cols)}
              alt={item.TITLE}
              loading="lazy"
              onClick={() => navigate(item.url)}
            />
            <ImageListItemBar
              sx={{
                background:
                  'linear-gradient(to bottom, rgba(0,0,0,0.7) 0%, ' +
                  'rgba(0,0,0,0.3) 70%, rgba(0,0,0,0) 100%)',
              }}
              title={item.TITLE}
              position="top"
              actionIcon={
                <IconButton
                  sx={{ color: 'white' }}
                  aria-label={`star ${item.TITLE}`}
                >
                  <StarBorderIcon />
                </IconButton>
              }
              actionPosition="left"
            />
          </ImageListItem>
        );
      })}
    </ImageList>
  );
}

export default WithRouter(CustomImageList)