<?php header("Content-type: text/css"); ?>

*{
    margin: 0;
    padding: 0;
}
:root{
    --main-color:rgb(0, 19, 104);    --main-color:#000527;
    --main-color:#000527;
}


.main{
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    height: 100vh;
    overflow: auto;
    display: flex;
    font-family: Arial, sans-serif;    

}

.left{
    width: 50%;
    background-color:  var(--main-color);
    color: white;
}

.left-head{
    max-width: 100%;
    font-size: xx-large;
    font-weight: bolder;
    padding: 1em;
    text-align : center; 

}
.left-para{
    max-width: fit-content;
    font-size: xx-large;
    padding: 1em;
    margin: auto;

}


.login {
    border: 1px solid var(--main-color);
    border-radius:.3em;
    color: gray;
    width: fit-content;
    height: fit-content;
    padding: .4em;
    margin: -1.2em auto;
}

a{
    text-decoration: none;
    color: inherit;
}

.login > a{
   color : white ;
   font-weight : bold ;
   cursor: pointer;
}




.right{
    width: 50%;
    background-color: rgb(255, 255, 255);
}

.right-head{
    position : relative;
    color:var(--main-color);
    max-width: 100%;
    height : 20%;
    display : flex;
}

.right-head > .p2{
    position : absolute;
    bottom : 0;
    left: 15%;
    opacity : 66%;
}

.right-head > .p1{
    position : absolute;
    bottom : 25%;
    left: 15%;
    font-size : x-large;
    font-weight : bold;
}

.form{
    text-align: center;
    padding: 1em;
    margin: .3em;
}
.input{
    border-radius:.3em;
    width: 30rem;
    padding: .7em;
    font-size: larger;
    margin: .7em 0;
    border: none;
    box-shadow: .1em .1em .3em 0 #A3A3A3;
    background : #EEEEEE;
}
input:focus {
  outline: none;
}

.error{
   border: 2px solid red;
}

.submit{
    cursor: pointer;
    width: fit-content;
    font-size: larger;
    border: none;
    background-color: var(--main-color);
    color: white;
    border-radius:.3em;
    padding: .4em 1em;
    margin : 1.5em 0;
}
.submit:hover{
   }

.avatars::-webkit-scrollbar{
    margin : 1em ;
    position : absolute; 
    border-radius: 1em;
    background-color: white;   
    width: 4px;
    height: 10px;
}
.avatars::-webkit-scrollbar-thumb {
    background-color: gray;
    border-radius: 1em;
    width : 10px;
  }

.avatars{
    display: flex;
    /* width: ; */
    gap : .3em ;
    background : var(--main-color);
    overflow-x: scroll;
    padding: .5em;
    box-shadow:  .8em .8em 1em .1em rgb(175, 174, 171);
    border-radius: .9em;
    width: 98%;
}

  
.images-div{
    
    width: 100px;
    margin-right: .2em;
}

.avatar-img{
    height: 90px;
    width: 90px;
    border-radius: 50%;
    border: 3px solid #010022;
    cursor:pointer;
}

.avatar-img:hover{
    border: 3px solid white;
}




@media screen and (max-width:1165px){
        .main{
            display: grid;
            grid-template-rows:repeat(2,1fr);
            grid-template-columns: 100%;         
        }
        .left,.right{
            width: 100%;
        }
        .left{
            width: 100%;
            border-radius: 0 0 1em 1em ;
        }
        .right-head{
            font-size: 30px;
            font-weight: bold;
            margin: auto;
        }
        input{
            max-width:fit-content ;
        }
}





