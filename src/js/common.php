<?php header("Content-type","text/javascript") ?>
const gostMode = document.querySelector("#gostMode");
// set gost mode
var xml = new XMLHttpRequest()
xml.open("GET",`api/gostMode.php`);
xml.onload = function(){
    if(this.status == 200){
        gostMode.checked = this.responseText == 1 ? true : false;
    }
}
xml.send();
// change gost mode
gostMode.addEventListener("click",()=>{
    var xml = new XMLHttpRequest()
    xml.open("POST","api/gostMode.php");
    xml.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xml.send(`id=${gostMode.value}`);
})
// logout
function logout(){
    var xml = new XMLHttpRequest()
    xml.onload = function(){
        if(this.status == 200){
        window.location.href = "../login/login.html";
        }
    }
    xml.open("POST","api/logout.php");
    xml.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xml.send();
}
// createGroup
const createGroup = document.getElementById("createGroup");
// const addMember = document.querySelectorAll("addMember");
var addedMembers = [];
var addedMembersImage = [];
var hiddenParents = [];
function addMember(file){
var image = document.querySelector("#addedImage"+file.value).src;
addedMembers.push(file.value);
addedMembersImage.push(image);
hiddenParents.push(file.value);
document.querySelector(`#parent${file.value}`).style.display = "none";
document.querySelector(".addedMembersProfile").innerHTML = "";
for(i = 0; i < addedMembersImage.length;i++)
    document.querySelector(".addedMembersProfile").innerHTML += `<img src='${addedMembersImage[i]}' width="70px" height="70px" class="rounded-circle">`;
}
function clearAddedMembers(){
for(i = 0; i < addedMembers.length; i++){
    document.querySelector(`#parent${hiddenParents[i]}`).style.display = "grid";
}
for(i = 0; i < addedMembers.length; i++){
    addedMembersImage.shift();
    addedMembers.shift();
    hiddenParents.shift();
}
document.querySelector(".addedMembersProfile").innerHTML = "";

}

createGroup.addEventListener("click",()=>{
    var groupName = document.getElementById("groupName");
    groupName = groupName.value.trim();
        if(groupName == "" || groupName.length > 10 || groupName.length < 3){
            alert(`invalid group name
            group name shold not be empty
            group name characters should not be 
            greater than 10 or less than 3`);
        } else {
            send();
        }
})
function send(){
    if(addedMembersImage.length < 1){
        alert('please Add Members')
        return
    }  
    var groupName = document.getElementById("groupName");
    groupName = groupName.value.trim();
    var xml = new XMLHttpRequest()
    xml.onload = function(){
        if(this.status == 200){
            if(this.responseText == "true"){
                window.location.href = "groupList.php";
            } else {
                alert('Name Exits '+this.responseText)
            }
        }
    }
    xml.open("POST","api/createGroup.php");
    xml.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xml.send("file="+addedMembers+"&groupName="+groupName)
}

// search

function searchData(value){
    if(value == "")
        return
    let xml = new XMLHttpRequest()
    xml.open("POST","api/search.php")
    xml.setRequestHeader("Content-type","application/x-www-form-urlencoded")
    xml.onload = function(){
        if(this.status == 200){
            let appendFile = this.responseText
            document.querySelector(".searchData").innerHTML = appendFile;
        }
    }
    xml.addEventListener("loadstart",loadstart)
    xml.send(`username=${value}`)
}

function loadstart(){
    document.querySelector(".searchData").innerHTML = ""
    let image = document.createElement("img")
    image.src = "../asset/photo/8puiO.gif"
    image.style.margin = "auto"
    image.style.width = "200px"
    document.querySelector(".searchData").appendChild(image)
}
