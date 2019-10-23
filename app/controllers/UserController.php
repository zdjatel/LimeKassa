<?php

class UserController extends Controller{

    

    function render(){

        $template=new Template;
        echo $template->render('login.html');
    }

    function beforeroute(){
    }

    function authenticate() {


        $username = $this->f3->get('POST.username');
        $password = $this->f3->get('POST.password');

        


        $user = new User($this->db);
        $user->getByName($username);

        // $nr = $this->db->exec(
        //     'SELECT doknr FROM tehing',
        //     'ORDER BY doknr DESC',
        //     'LIMIT 1'
        // );

       
       
       
       
        if($user->dry()) {
            $this->f3->reroute('/login');
        }

        $auth = new \Auth($user, array('id'=>'username', 'pw'=>'password'));
        $login_result = $auth->login($username, $password);

        //$nr = 1;

        $tehing = new Tehing($this->db);
        $tehing->listByCity();
        $nr= $tehing->doknr;

        if($login_result) {
           
            $this->f3->set('SESSION.user', $user->username);


            $this->f3->set('SESSION.doknr', $nr);
         

            $this->f3->reroute('/');
        } else {
            $this->f3->reroute('/login');
        }
    }

    function logout() {
        $this->f3->clear('CACHE');
        $this->f3->set('SESSION.user', null );
        $this->f3->set('SESSION.doknr', null );
        $this->f3->reroute('/login');
    }
}