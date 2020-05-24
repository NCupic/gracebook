<?php
class Users extends Controller{
   public function __construct()
   {
    //load model- upucuje na User.php u modelima
    $this->userModel = $this->model('User');



   }
    public function register()
    { //prova metoda post
        if($_SERVER['REQUEST_METHOD']== 'POST')
        {   $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //procesuiraj formu--validacija
            $data = [

                'name'=>trim($_POST['name']),
                'email'=>trim($_POST['email']),
                'password'=>trim($_POST['password']),
                'confirm_password'=>trim($_POST['confirm_password']),
                'name_err'=>'',
                'email_err'=>'',
                'password_err'=>'',
                'confirm_password_err'=>''


           ];

           //validacija emaila

           if(empty($data['email']))
           {
               $data['email_err'] = 'Please enter email';
           }
           else
           {//!!!!!!provera emaila iz modela
            if($this->userModel->findUserByEmail($data['email']))
            {
                $data['email_err'] = 'Email is already taken';
            }

           }
           //validacija imena
           if(empty ($data['name']))
           {
            $data['name_err'] = 'Please enter your name';
           }

           //validacija passworda
           if(empty ($data['password']))
           {
            $data['password_err'] = 'Please enter password';
           }
           elseif (strlen($data['password'])<6)
           {
            $data['password_err'] = 'Password must have minimum 6 characters';
           }


            //validacija Confirm passworda
            if(empty ($data['confirm_password']))
            {
             $data['confirm_password_err'] = 'Please confirm  password';
            }
            else
            {
                if($data['password'] != $data['confirm_password'] )
                {
                    $data['confirm_password_err'] = 'Paswords do not match';
                }
            }

            // make sure that passwors are empty
            if(empty($data['name_err'])  && empty($data['email_err'])  && empty($data['password_err'])  && empty($data['confirm_password_err']))
            {
                //validated
                

                //podesavanja lozinke bitnaq za registaciju--nikada ne zelimo u bazi da sacuvamo password kao tekst koji je unet
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);

                //register user
                if($this->userModel->register($data))///!!!!ako je registaracija uspela redirect
                {
                    flash('register_success', 'You are registred, please login!');//fja flash, prima ime,poruku i pcionalno bootstarp klasu
                    redirect('users/login');//ovo smo omogucili u helepery, ne moramo stalno sa header
                }
                else{
                    die('error');
                }
            }
            else 
            {
                //load view with errors
                $this->view('users/register', $data);
            }


        }
        else
        {
               //popuni formu 
               //echo 'load form';

               //inicijalizovanje podataka


               $data = [

                    'name'=>'',
                    'email'=>'',
                    'password'=>'',
                    'confirm_password'=>'',
                    'name_err'=>'',
                    'email_err'=>'',
                    'password_err'=>'',
                    'confirm_password_err'=>''


               ];
               //load view
               $this->view('users/register', $data);
        }
    } 
    public function login()
    {//prova metoda post
        if($_SERVER['REQUEST_METHOD']== 'POST')
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //init data
            $data = [

               
                'email'=>trim($_POST['email']),
                'password'=>trim($_POST['password']),
                'email_err'=>'',
                'password_err'=>''];

                //validacija emaila

           if(empty($data['email']))
           {
               $data['email_err'] = 'Please enter email';
           }

            //validacija passworda
            if(empty ($data['password']))
            {
             $data['password_err'] = 'Please enter password';
            }

            //potrazi userov email---find uswer by email koristuili smo je i u register, samo obrnuta logika
            if($this->userModel->findUserByEmail($data['email']))
            {
                //user found
            }
            else
            {
                $data['email_err'] = 'No User found';
            }

            // make sure that errors are empty
            if( empty($data['email_err'])  && empty($data['password_err']))
            {
                //user postoji i idemo dalje--!!pozivanje LOGIN MODELA
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser)
                {
                    // kreiramo sesiju kada ustanovimo da je to user sa poznatim emailom i passwordom
                    $this->createUserSession($loggedInUser);
                }
                else{
                    $data['password_err'] = 'Password incorrect';
                    $this->view('users/login', $data);
                }
            }
            else
            {    //load view with errors--omogucava da i pored gresaka imamo view
                $this->view('users/login', $data);
            }
           


        }
        else
        {
               //popuni formu 
               //echo 'load form';

               //inicijalizovanje podataka


               $data = [  
                    'email'=>'',
                    'password'=>'',
                    'email_err'=>'',
                    'password_err'=>'',
                
               ];
               //load view
               $this->view('users/login', $data);
        }
    } 

    public function createUserSession($user)
    {
        
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;

        redirect('posts'); //kada smo ulogovani, odmah vidimo postove
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        session_destroy();
        redirect('users/login');
    }

    
}



?>