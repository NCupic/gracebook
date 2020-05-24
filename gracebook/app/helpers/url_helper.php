<?php

//page redirect

function redirect($page)
{
//ako smo ovde znaci da je true i da je korisnik registrovan:u tom slucaju zelimo redirekciju na login stranu
header('location:' . URLROOT . '/' . $page);
}


?>