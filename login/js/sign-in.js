
    const username = document.querySelector(".username");
    const password = document.querySelector(".password");
    const confirmPass = document.querySelector(".confirmPass");
    const avatarImg = document.querySelectorAll(".avatar-img")
   
    var selected = "";
    
    document.querySelector(".submit").addEventListener("click",submit);
    
    function get_img(e){
        var num = -1;
        var file = 0;
        avatarImg.forEach(element => {
            num++
            if(element == e)
                file = num;
            
        });
        return file;
    }

    function select_img(path){
        avatarImg.forEach(element => {
            if(path == element)
                element.style.border = "6px solid #0800FF";
             else 
                element.style.border = "3px solid #010022";
                     
        });
    }

    avatarImg.forEach(element => {
        element.addEventListener("click",()=>{
            selected = element;
            select_img(element);
        })
    });

    function submit(event){

        event.preventDefault();
        
        if(trimFile(username) == "" || trimFile(password) == "" || trimFile(confirmPass) == "" || selected == ""){
            trimFile(username) == "" ? Err(username,"empty Username") : normal(username,"Username");
            trimFile(password) == "" ? Err(password,"empty Password") : normal(password,"Password");
            trimFile(confirmPass) == "" ? Err(confirmPass,"empty Confirm") : normal(confirmPass,"confirm Password");
            selected == "" ? imageErr(1) : imageErr(0);
        } else {
            clean()
            if(trimFile(username).length < 4 || trimFile(username).length > 10){
                trimFile(username).length < 4 ? Err(username,"Too Short Username"):"";
                trimFile(username).length > 10 ? Err(username,"Too Long Username"):"";
            } else {
                clean()
                if(trimFile(password) === trimFile(confirmPass)){

                    sends(trimFile(username),trimFile(password),get_img(selected))

                } else {
                    Err(confirmPass,"Confirm Password Does not Much")
                }
            }
        }
    }
    function Err(path,error){
        path.value = "";
        path.placeholder = error;
        path.classList.add("error")
    }
    function normal(path,placeholder){
        path.placeholder = placeholder
        path.classList.remove("error")        
    }
    function clean(){
        normal(username,"Username")
        normal(password,"Password")
        normal(confirmPass,"Confirm Password")
        document.querySelector(".avatars").classList.remove("error");
    }
    function trimFile(path){
        return path.value.trim();
    }
    function imageErr(check){
        if(check == 1){
            document.querySelector(".avatars").classList.add("error");
        } else if(check == 0){
            document.querySelector(".avatars").classList.remove("error");
        }
    }
    function sends(username,password,image){
        let xml = new XMLHttpRequest();
            xml.onload = function (){
                if(this.status == 200){
                    var result = false
                    result = JSON.parse(this.responseText)
                    console.log(this.responseText);
                    if(result.form == true){
                        window.location.href = "../src/index.php";
                    } else {
                        alert("sorry this username is taken");
                    }
                    
                }
            }
            xml.open("POST","api/sign-in.php",true);
            xml.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xml.send(`username=${username}&password=${password}&image=${image}`);
          
    }

