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
    color: white;
    text-transform: capitalize;
    font-weight : bold;
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
::-webkit-scrollbar {
    display: none;
    z-index: -1;
  }
/* -----------common--------------------- */

.message-background{
    background:linear-gradient( rgba(0, 0, 0, 0.2) 100%, rgba(0, 0, 0, 0.5)100%), url("../../asset/photo/pexels-юли-трофимова-13719430.jpg");
    background-position:center;
    background-repeat: no-repeat;
    background-size:cover;
    display: grid;
    grid-template-rows: auto;
    max-height: 88vh; 
    max-width: 100%;
    overflow-y: scroll;
}

.userNav button{
    color: white;
    text-transform: capitalize;
    font-weight : bold;
}


.sender-message{
    text-align: right;
    background-color: #FFFFFF;
    margin: 1em 47%;
    color: black;
    border-radius: 2em 2em 0 2em;
    width: 40%;
    word-wrap:break-word;
    
}


.reciever-message{
    <!-- width : 100px; -->
    <!-- float: left; -->
    color: white;
    background-color: var(--main-color);
    margin: 1em;
    width: fit-content;
    border-radius: 2em 2em  2em 0;
    width: 40%;
}

.sender-message > div{
    word-wrap:break-word;
}


.text-message{
    margin: .2em;
    font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    font-size: normal;
    padding: .1em;
    
}

.send{
    background-color:var(--sidebar-color);
    max-width : 181vh;
    
}

.message-image{
    border-radius: 1em;
    width: 100%;
}


@media only screen and (max-width:700px) {
    .custom-file-input{
        max-width: 36px;
    }
}

.send-input{
    margin-bottom: 1em;
    width: 50%;
    padding: .3em;
    border: none;
    border-radius: .4em;
}

.sender-pro{
    display: grid;
    grid-template-columns: repeat(3,1fr);
}

.chat-img{
    padding: .3em;
}

.chat-username{
    
}

.light{
    margin:2em;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    padding: .1em;
    margin: auto;
}

.custom-file-input::-webkit-file-upload-button {
    visibility: hidden;
  }
  .custom-file-input::before {
    content: url("../../asset/photo/image.svg");
    display: inline-block;
    background: white;
    border: 1px solid #999;
    border-radius: 3px;
    padding: 5px 8px;
    outline: none;
    white-space: nowrap;
    -webkit-user-select: none;
    cursor: pointer;
    font-weight: 700;
    font-size: 10pt;
    color: white;

  }
  .custom-file-input:hover::before {
    border-color: rgb(255, 255, 255);
  }
  .custom-file-input:active::before {
    background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
  }