<?php header("Content-type: text/css"); ?>

:root{
    --main-color:#212529;
    --main-color-hover:#282d31;
    --sidebar-color:#364049;
    --subside-color:#464f58;
}
.scrollbar-hidden::-webkit-scrollbar {
    display: none;
    z-index: -1;
  }

.main_color{
    background-color: var(--sidebar-color);
    color: white;
}

.sub-side{
    background-color: var(--subside-color);
    color: white;
}

.white{
    color: white !important;
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

.profile{
    display: grid;    
}

.username{
    color: white;
    text-transform: capitalize;
    font-weight : bold;
    text-align: center;
    padding: 1em;
    font-size: normal;
}

.username-info{
    font-size: small;
    color: rgb(122, 122, 122);
}

.alternatives{
    left:0;
    right:0;
    top:0;
    width: 100%;
    background-color: var(--main-color);
    display: grid;
    grid-template-columns: repeat(3,1fr);
    color: white;
}
.user{
    padding: 1em;
    border: 1px solid #585355;
    background-color:#B1B1B143;
}

.group{
    border: 1px solid var(--main-color-hover);
    padding: 1em;
    background-color:#212526;
}

.notification{
    border: 1px solid var(--main-color-hover);
    padding: 1em;
    background-color:#212526;
}

.notification:hover,
.group:hover,
.user:hover{
    cursor: pointer;
    background:#313031;
}

.message{
    width: 100%;
    display: grid;
    grid-template-columns: 7% 83% 5% 5%;
    padding: 1em;
    margin-top:.1em ;
    justify-content: center;
    border: 1px solid var(--main-color);
}

.senderYou{
    color : red;
}

@media only screen and (max-width:600px){ 
    .message{
        width: 100%;
        /* background-color: rgb(255, 255, 255); */
        display: grid;
        grid-template-columns: 15% 55% 15% 15%;
        padding: 1em;
        margin-top:.1em ;
        justify-content: center;
        border: 1px solid var(--main-color);

    }   
}

.satm{
    font-size: x-large;
    font-family:monospace;
    
}

.message-image{
    display: grid;
    width : fit-content;
    grid-template-rows: repeat(2,1fr);
}

.message-main-image{
    margin: -4px;
    width : 50px !important;
    height : 50px !important;
}
.sender-username{
    color: white;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    text-transform: capitalize;
}

.message-main{
    text-align:left;
    overflow: hidden;
    margin-top: 1em;
    margin-left: .4em;
    max-height: 100%;
    max-width: 100%;
    cursor: pointer;
    color: #B9B9B9;
    font-size : small;

}

.message-notification{
 }

.notification-show{
    margin: .3em auto;
    width: 30px;
    height: 30px;
    color: white;
    background-color: blue;
    padding: .1em;
    border-radius: 50%;

}

.message-delete{

}
.delete{
    width: fit-content;
    height: fit-content;
    margin: auto;
    padding: .3em;
}

.light{
    margin:.4em;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    padding: .1em;
}
.line{
    display: flex;
}