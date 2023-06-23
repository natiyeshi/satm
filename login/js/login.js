    
    const username = document.querySelector(".username");
    const password = document.querySelector(".password");
    
    document.querySelector(".submit").addEventListener("click",submit)

    function submit(event){
        event.preventDefault()
        if(trimFile(username) == "" || trimFile(password) == ""){
            trimFile(username) == "" ? Err(username,"empty Username") : normal(username,"Username");
            trimFile(password) == "" ? Err(password,"empty Password") : normal(password,"Password");
        } else {
            clean()
            if(trimFile(username).length < 4 || trimFile(username).length > 10){
                Err(username,"Incorrect Username")
                Err(password,"Incorrect Password")
            } else {
                clean()
                sends(trimFile(username),trimFile(password))
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
    }
    function trimFile(path){
        return path.value.trim();
    }
    function sends(username,password){
        let xml = new XMLHttpRequest();
            xml.onload = function (){
                if(this.status == 200){
                    var result = false
                    result = JSON.parse(this.responseText)
                    if(result.form == true){
                        document.querySelector(".username").value = "";
                        document.querySelector(".password").value = "";
                        window.location.href = "../src/index.php";
                    } else {
                        document.querySelector(".username").value = "";
                        document.querySelector(".username").classList.add("error");
                        document.querySelector(".username").placeholder = "Username not found";
                        document.querySelector(".password").value = "";
                        document.querySelector(".password").classList.add("error");
                        document.querySelector(".password").placeholder = "Password not Found";
                    } 
                }
            }
            xml.open("POST","api/login.php",true);
            xml.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xml.send(`username=${username}&password=${password}`);
          
    }

