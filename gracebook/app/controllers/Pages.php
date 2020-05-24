<?php
  class Pages extends Controller {
    public function __construct()
    {
    }
      
    
    public function index(){


      if(isLoggedIn())
      {
        redirect('posts');//ako smo ulogovani , redirektujemo se na posts, to nam je umesto homepagea
      }
      
      
      $data = [
        'title' => 'Gracebook',
        'description'=> 'Simple social network'
       
      ];
     
      $this->view('pages/index', $data);
    }

    public function about(){
      $data = [
        'title' => 'About Gracebook',
        'description'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
         Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'



        
      
      ];

      $this->view('pages/about', $data);
    }
  }