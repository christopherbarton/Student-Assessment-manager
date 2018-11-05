<?php
header("Content-type: text/css");
?>

.flex-container {
  display: flex;
  height: auto;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  align-content: center;
  }
.table {
    table-layout: auto;
    word-wrap: break-word;
    width: auto;
    hight: auto;
    text-align: center;   
}
.footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: blue;
    color: white;
    text-align: center;
}
.img{
    width: 70; 
    height: 70;
}
.table-wrapper-scroll-y {
  display: block;
  max-height: 400px;
  overflow-y: auto;
  -ms-overflow-style: -ms-autohiding-scrollbar;
}
