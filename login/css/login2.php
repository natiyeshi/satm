<?php header("Content-type: text/css"); ?>

*{
    margin: 0;
    padding: 0;
}
:root{
    --sub-color:rgb(203, 210, 253);
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
    color: white;
    /* background:linear-gradient( rgba(6, 0, 34, 0.5) 100%, rgba(0, 0, 0, 0.5)100%),url("../../asset/photo/1_JY-JZfN8GW_OsJoVrI7wBg.png"); */
    /* background-size: 50vw;  */
    /* background-repeat: no-repeat; */
    /* float: left; */

    background-color: var(--main-color);
    
}

.left-head{
    
    max-width: fit-content;
    font-size: 35px;
    font-weight: bolder;
    padding: 1em;
    margin: auto;
    
}
.left-para{
    opacity: .9;
    max-width: 100%;
    font-size: xx-large;
    padding: 1em;
    margin: auto;
    text-align: center;

}

a{
    text-decoration: none;
    color: inherit;
}
.left-form{
    border: 1px solid var(--main-color);
    border-radius:.3em;
    color: gray;
    width: fit-content;
    height: fit-content;
    padding: .4em;
    margin: -1.2em auto;
    
}

.left-form > a{
    color : white;
}

.left-form > a:hover{
}
 
.right{
    width: 50%;
    background-color: rgb(255, 255, 255);
    display : grid;
    
}


.right-head{
    position:relative;
    width : 100%;
    text-align: center;
    color:var(--main-color);
    display : grid;
}

.right-head > .p1{
    position : absolute;
    bottom : 25%;
    left: 12%;
    font-size : x-large;
    font-weight : bold;
}
.right-head > .p2{
    position : absolute;
    bottom : 0;
    left: 12%;
    opacity : 66%;
}

.form{
    padding: 1em;
    margin: 1em 4em;
}
.input{
    border-radius:.3em;
    width: 25rem;
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
}
.submit:hover{
    background-color: #040A32;
}

@media screen and (max-width:1165px){
        .main{
            display: grid;
            grid-template-rows:repeat(2,1fr);
            grid-template-columns: 100%;
            
        }
        .left,.right{
            width: 100%;
            background-size: 100vw; 
        }
        .left{
            width: 100%;
            border-radius:.3em;
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




