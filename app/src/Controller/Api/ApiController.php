<?php
namespace App\Controller\Api;

use Cake\Event\Event;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\Http\ServerRequest;
use Cake\I18n\Time;

class ApiController extends AppController {
    
    /**
     * Initialize & enable allowed actions wihtout authentication
     *
     * @return void
     */
    public function initialize(): void {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Cocktails');


        $this->Auth->allow(['login', 'register', 'token', 'addCocktail']);
        $this->Authentication->addUnauthenticatedActions(['login', 'register', 'token', 'addCocktail']);
    }

    /**
     * Token function
     * generate the token based off a user's login data
     * 
     */
    public function token() {
        $this->request->allowMethod(['get', 'post']);
        $response = ['success' => false, 'msg' => "Invalid Request", 'errors' => ''];
        $token = '';
        $result = $this->Authentication->getResult();

        if($result->isValid()){
            $key = Security::getSalt();
            $response = ['success' => true, 'msg' => "Logged in successfully", 'errors' => ""];
            $token = JWT::encode([
                'alg' => 'HS256',
                'id' => $result->getData()['id'],
                'sub' => $result->getData()['id'],
                'iat' => time(),
                'exp' =>  time() + 86400, // One Day
            ],
            $key);
        }

        extract($response);
        $this->set(compact('success', 'msg', 'errors', 'token'));
        $this->viewBuilder()->setOption('serialize', ['success', 'msg', 'errors', 'token']);
    }

    /**
     * Login method
     * Login user and generate a jwt (uses jwt token)
     * @return void
    */
    public function login() {
        $response = ['success' => false, 'msg' => "Invalid Request", 'errors' => ''];
        $token = "";
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException("Login Failed !, Invalid Login Credentials");
        }else{
            $key = Security::getSalt();
            $response = ['success' => true, 'msg' => "Logged in successfully", 'errors' => ""];
            $token = JWT::encode([
                'alg' => 'HS256',
                'id' => $user['id'],
                'sub' => $user['id'],
                'iat' => time(),
                'exp' =>  time() + 86400, // One Day
            ],
            $key);
        }

        extract($response);
        // $this->set(['success' => $success, 'msg' => $msg, 'errors' => $errors, 'token' => $token]);
        $this->set(compact('success', 'msg', 'errors', 'token'));
        $this->viewBuilder()->setOption('serialize', ['success', 'msg', 'errors', 'token']);

    }

         
    /**
     * Register User
     *
     * @return void
     */
    public function register() {
        $response = ['success' => false, 'msg' => "Invalid Request", 'errors' => '', 'token' => 'Null'];
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {

                //make token when a user registers
                $token = "";
                $key = Security::getSalt();
                $response = ['success' => true, 'msg' => "Logged in successfully", 'errors' => ""];
                $token = JWT::encode([
                    'alg' => 'HS256',
                    'id' => $user['id'],
                    'sub' => $user['id'],
                    'iat' => time(),
                    'exp' =>  time() + 86400, // One Day
                ],
                $key);

                $response = ['success'=> true, 'msg' => 'Registered Successfully', 'errors' => '', 'token' => $token];
            } else {
                $response = ['success'=> false, 'msg' => 'Unable to Register', 'errors' => $user->getErrors(), 'token' => 'Null'];
            }
        }

        extract($response);
        $this->set(compact('success', 'msg', 'errors', 'token'));
        $this->viewBuilder()->setOption('serialize', ['success', 'msg', 'errors', 'token']);

    }

        
    /**
     * index
     *
     * @return void
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Groups'],
        ];
        $users = $this->paginate($this->Users);
        
        
        $this->set(compact('users'));
        $this->viewBuilder()->setOption('serialize', ['users']);
    }
	

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $response = ['success' => false, 'msg' => "Invalid Request", 'errors' => ''];
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $response = ['success'=> true, 'msg' => 'Updated Successfully', 'errors' => ''];
            } else {
                $response = ['success'=> false, 'msg' => 'Enable to Update', 'errors' => $user->getErrors()];
            }
        }

        extract($response);
        $this->set(compact('success', 'msg', 'errors'));
        $this->viewBuilder()->setOption('serialize', ['success', 'msg', 'errors']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => ['Groups'],
        ]);

        $this->set(compact('user'));
        $this->viewBuilder()->setOption('serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $response = ['success' => false, 'msg' => "Invalid Request", 'errors' => ''];
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $response = ['success'=> true, 'msg' => 'Deleted Successfully', 'errors' => ''];
        } else {
            $response = ['success'=> false, 'msg' => 'Enable to Delete', 'errors' => $user->getErrors()];
        }

        extract($response);
        $this->set(compact('success', 'msg', 'errors'));
        $this->viewBuilder()->setOption('serialize', ['success', 'msg', 'errors']);
    }
    

    /**
     * Add Cocktail method
     * allows user to add new cocktails with a post request and the headers: name & description
     * 
     * @return null
     */
    public function addCocktail() {
        $cocktail = $this->Cocktails->newEmptyEntity();
        if ($this->request->is('post')) {
            $cocktail = $this->Cocktails->patchEntity($cocktail, $this->request->getData());
            if ($this->Cocktails->save($cocktail)) {
                $response = ['success'=> true, 'msg' => 'Cocktail Added', 'errors' => '', 'cocktail' => $cocktail];
            } else {
                $response = ['success'=> false, 'msg' => 'Unable to add Cocktail', 'errors' => $cocktail->getErrors(), 'cocktail' => ''];
            }
        }

        extract($response);
        $this->set(compact('success', 'msg', 'errors', 'cocktail'));
        $this->viewBuilder()->setOption('serialize', ['success', 'msg', 'errors', 'cocktail']);

    }

}