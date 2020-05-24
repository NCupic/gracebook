<?php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


        public function register($data)//ovde je ukljucen i hash password
        {
                $this->db->query('INSERT INTO users (name,email,password) VALUES (:name,:email, :password)');
               
               //povezivanje vrednosti
                $this->db->bind(':name', $data['name']);
                $this->db->bind(':email', $data['email']);
                $this->db->bind(':password', $data['password']);

                //execute
                if($this->db->execute())
                {
                        return true;
                }
                else
                {
                        return false;
                }


        }

        //login user 

        public function login($email,$password)
        {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            $hashed_password = $row->password;//povezivanje kriptovane i obicne lozinke
            if(password_verify($password, $hashed_password))
            {
                return $row;
            }
            else
            {
                return false;
            }




        }
    
        //find user by email

    public function findUserByEmail($email)
    {//zovemo query koji ce da spremi stm
        $this->db->query('SELECT * FROM users WHERE email = :email');
        
        //povezivanje imenovanog parametra sa promenljivom
        $this->db->bind(':email', $email);


        //zelimo samo jedan red iz baze
        $row = $this->db->single();

        //check row, proveravamo da li postoji red koji trazimo, da li je rezultat veci od nula
        if($this->db->rowCount() >0)
        {
            return true;
        }
        else{
            return false;
        }

    }

    public function getUserById($id)
    {//zovemo query koji ce da spremi stm
        $this->db->query('SELECT * FROM users WHERE id = :id');
        
        //povezivanje imenovanog parametra sa promenljivom
        $this->db->bind(':id', $id);


        //zelimo samo jedan red iz baze
        $row = $this->db->single();

        return $row;

     
    }
}


?>