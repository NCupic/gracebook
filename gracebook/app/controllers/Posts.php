<?php
class Posts extends Controller 
{
    public function __construct(){
      if(!isLoggedIn()){
        redirect('users/login');//redirekcija na starnu za logovanje, ne mozemo videti postove ako nismo ulogovanič isLogegdIn je funkcija i session helpera, koja proverava da li traje userova sesijač
      }

      //pozivanje post modela
      $this->postModel = $this->model ('Post');
      //pozivanje user modela
      $this->userModel = $this->model('User');
    }

    public function index(){
        //get posts
        $posts = $this->postModel->getPosts();
      $data = [
          'posts'=>$posts//promenljiva posts , to su ssvi postovi u view-u pomocu forreacha izlazemo svaki posebno
      ];

      $this->view('posts/index', $data);
    }
    
    
    public function add()
    {  if($_SERVER['REQUEST_METHOD']== 'POST')
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

               $data=[  'title'=>trim($_POST['title']),
                        'body'=>trim($_POST['body']),
                        'user_id'=>$_SESSION['user_id'],
                        'title_err'=>'',
                        'body_err'=>''
               ] ;

               //validacija naslova
               if(empty($data['title']))
               {
                   $data['title_err'] = "Please enter the title";
               }

               //validacija bodija
               if(empty($data['body']))
               {
                   $data['body_err'] = "Please enter the text";
               }

               //make sure there is no errors
               if(empty($data['title_err'])  && empty($data['body_err']))
               {
                   //validacija uspela
                   if($this->postModel->addPost($data))//addPost je funkcija iz modela
                   {
                       flash('post_message', 'Post successfully added');
                       redirect('posts');
                   }
                   else
                   {
                       die('Something went wrong');
                   }
               }
               else{
                   //load view with errors
                   $this->view('posts/add', $data);
               }
        }
        else
        {
        $data = [
            'title'=>'',
            'body'=>''
        ];
  
        $this->view('posts/add', $data);
         }
    }


    public function edit($id)
    {  if($_SERVER['REQUEST_METHOD']== 'POST')
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

               $data=[  'id'=>$id,
                        'title'=>trim($_POST['title']),
                        'body'=>trim($_POST['body']),
                        'user_id'=>$_SESSION['user_id'],
                        'title_err'=>'',
                        'body_err'=>''
               ] ;

               //validacija naslova
               if(empty($data['title']))
               {
                   $data['title_err'] = "Please enter the title";
               }

               //validacija bodija
               if(empty($data['body']))
               {
                   $data['body_err'] = "Please enter the text";
               }

               //make sure there is no errors
               if(empty($data['title_err'])  && empty($data['body_err']))
               {
                   //validacija uspela
                   if($this->postModel->updatePost($data))//upPost je funkcija iz modela
                   {
                       flash('post_message', 'Post updated');
                       redirect('posts');
                   }
                   else
                   {
                       die('Something went wrong');
                   }
               }
               else{
                   //load view with errors
                   $this->view('posts/edit', $data);
               }
        }
        else
        {
           //pozivamo model u kome je omoguéno dohvatanje odredjenog posta
            $post=$this->postModel->getPostById($id);
            
            //obezbedjujemo da post moze da edituje samo onaj user ciji je post
            if($post->user_id != $_SESSION['user_id'])
            {
                redirect('posts');
            }


        $data = [
            'id'=>$id,
            'title'=>$post->title,
            'body'=>$post->body
        ];
  
        $this->view('posts/edit', $data);
         }
    }
    
    
    public function show($id)
    {
        $post=$this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);//dohvatanje pojedinacnog posta 
        
        $data=[
            'post'=>$post,
            'user'=>$user
        ];
        
        $this->view('posts/show', $data);
    }
   
    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $post=$this->postModel->getPostById($id);
            
            //obezbedjujemo da post moze da edituje samo onaj user ciji je post
            if($post->user_id != $_SESSION['user_id'])
            {
                redirect('posts');
            }
            if($this->postModel->deletePost($id))
            {
                flash('post_message', 'Post removed');
                redirect('posts');
            }
            else{
                die('Something went wrong');
            }
        }
        else
        {
            redirect('posts');
        }
    }
}
?>