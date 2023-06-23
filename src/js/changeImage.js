
    IMAGES = []
    function showImage(check){
        let profileImage = document.getElementById("profileImage")   
        let currentImage = getCurrentImage()
        let currentIndex = sendIndex(currentImage)
        if(check == 1 && currentIndex < IMAGES.length - 1  && currentIndex > -1){
            profileImage.src = "profileImages/"+IMAGES[parseInt(currentIndex) + 1]
        }
       if(check == -1 && currentIndex > 0  && currentIndex < IMAGES.length){
            profileImage.src = "profileImages/"+IMAGES[currentIndex - 1]
        }  
    }
    
    function getCurrentImage(){
        let profileImage = document.getElementById("profileImage").src   
        let allPath = profileImage.split("/")
        return allPath[allPath.length - 1]
    }
    function sendIndex(file){
        for(let a in IMAGES){
            if(IMAGES[a] == file)
                return a
        }
     }
    (async function getImage(){
        let images = await fetch("api/imageArray.php")
        let img = await images.text();
        reciever(JSON.parse(img))
     })()
    
    function reciever(json){
        for(let i of json){
            let file = i.split("\n")
            IMAGES.push(file[0])
        }
        IMAGES[0] += ".jpg";
     }