<?php
session_start();


//flash message
//

function flash($name = '', $message = '', $class = 'alert alert-success')
{
    //provera da li je uneto ime, proveravamo da li postoji sesija, 
    //ako postoji uklanjamoje: zatim je postavljamo
    if(!empty($name))
    {
        if(!empty($message) && empty($_SESSION[$name])){
            if(!empty($_SESSION[$name])){
              unset($_SESSION[$name]);
            }
     
            if(!empty($_SESSION[$name. '_class'])){
              unset($_SESSION[$name. '_class']);
            }
    
            $_SESSION[$name] = $message;
            $_SESSION[$name. '_class'] = $class;
          } elseif(empty($message) && !empty($_SESSION[$name]))//obrnuto od prvog,ako postoji sesija
          {
            $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
            echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name. '_class']);
          }
        }
      }
    
      function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
          return true;
        } else {
          return false;
        }
      }
    





?>