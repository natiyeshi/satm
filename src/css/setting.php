<?php header("Content-type: text/css"); ?>

:root{
    --main-color:#212529;
    --main-color-hover:#282d31;
    --sidebar-color:#364049;
    --subside-color:#464f58;
}
.main_color{
    background-color: var(--sidebar-color);
    color: white;
}

.sub-side{
    background-color: var(--subside-color);
    color: white;
}


.center{
    width: 100%;
    text-align: center;
}

.profile-image{
    max-width: 150px;
    height: 150px;
    border: 4px solid rgb(114, 114, 114);
    cursor: pointer;
}
.profile-image:hover{
    border: 4px solid rgb(156, 156, 156);
}

.username{
    color: blue;
    text-align: center;
    padding: 1em;
    font-size: normal;
}
.satm{
    font-size: x-large;
    font-family:monospace;
}

.username-info{
    font-size: small;
    color: rgb(122, 122, 122);
}
.scrollbar-hidden::-webkit-scrollbar {
    display: none;
    z-index: -1;
  }
/* -----------common--------------------- */
.profile-body{
    display: grid;
    grid-template-columns: 50% 50%;
}

.profile-body-sub{
    padding: 1em;
    display: grid;
    grid-template-rows: auto ;
    height: 86vh;
    overflow: hidden;
}

@media only screen and (max-width:900px) {
    .profile-body{
        display: block;
    }
    .profile-body-sub{
        height: 60vh;
    }
   
}

.profile-body-sub-file{
    display: grid;
    grid-template-columns: repeat(2,1fr);
}
.profile-body-sub-text{
}
.profile-body-sub-img{
    /* background-color: rgb(221, 221, 221); */
    display: flex;
    
    
}

.next-btn{
    display: grid;
    grid-template-columns: auto;
    justify-content: center;
    align-items: center;
}

.image-profile{
    width: 70%;
}

.profile-body-sub-file-name{
    display: flex;
    gap: 1em;
}
.question{
    font-size: larger;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;    
}
.answer{
    color: blue;
}
/* body2 */
.profile-body-sub2{

}
.sub-head{
    font-size: xx-large;    
    color: #212529;
    font-weight: bold;
    padding: 1em;
    text-align: center;
}
.sub-body{
    display: grid;
    grid-template-rows: auto;
}

.sub-body-file{
    margin-top:2em ;
    display: grid;
    grid-template-columns: repeat(2,1fr);
}
.sub-body-file-last{

}

/* modals */
.members-class{
    max-height: 300px;
    overflow:scroll;
}
.user-files{
    display: grid;
    grid-template-columns: repeat(3,1fr);   
    width: 100%;
    border: 2px solid rgb(221, 221, 221);
    padding: .3em;
    border-radius: 1em;
}

.user-img{
    width: 70px;
}
.user-image{
    width: 100%;
}