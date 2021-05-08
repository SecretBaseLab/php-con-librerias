<?php
namespace App\Controllers;

use App\Models\user;
use Respect\Validation\Validator as v;

class UsersController extends BaseController{
    public function getAddUserAction($request){
        return $this->renderHTML('addUser.twig');
    }

    public function postSaveUserAction($request){
        $responseMessage = null;

        if ( $request->getMethod() == 'POST') {
            //? v::attribute para objs V::key para arrays
            $postData = $request->getParsedBody();

            $projectValidator = v::key('email', v::stringType()->noWhitespace()->email())
                ->key('password', v::stringType()->notEmpty()->noWhitespace());
            try {   
                $projectValidator->assert($postData);

                $user = new user();
                $user->email = $postData['email'];
                $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);
                $user->save();
                $responseMessage = 'Saved';
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }
        }
        // include '../views/addProject.php';
        return $this->renderHTML('addUser.twig', [
            'responseMessage' => $responseMessage
        ]);
    }
}