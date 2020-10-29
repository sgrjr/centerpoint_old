const fs = require('fs')
const path = require('path');

const getHashedFile = function(dir, dir2){

        let fileList = [];
        
        var files = fs.readdirSync(dir);
        for(var i in files){
            if (!files.hasOwnProperty(i)) continue;

            if (!fs.statSync(dir+'/'+files[i]).isDirectory()){
                fileList.push(files[i]);
            }
        }

        let fileList2 = [];
     
        var files = fs.readdirSync(dir2);
        for(var i in files){

            if (!files.hasOwnProperty(i)) continue;

            if (files[i].indexOf("runtime") === -1){
                fileList2.push(files[i]);
            }
        }

       const f = {
       	css: fileList,
       	js: fileList2
       }

        console.log(f)
        fs.writeFileSync(path.resolve(__dirname, '../public') + "/built.json", JSON.stringify(f))
        return f;
}

getHashedFile(path.resolve(__dirname, '../public/compiled') + '/static/css', path.resolve(__dirname, '../public/compiled') + '/static/js');