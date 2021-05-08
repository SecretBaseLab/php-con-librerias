<?php
namespace App\Controllers;

use App\Models\project;
use Respect\Validation\Validator as v;

class ProjectsController extends BaseController{
    public function getAddProjectAction($request){
        $responseMessage = null;

        if ( $request->getMethod() == 'POST') {
            //? v::attribute para objs V::key para arrays
            $postData = $request->getParsedBody();

            $projectValidator = v::key('title', v::stringType()->notEmpty())
                ->key('description', v::stringType()->notEmpty());
            try {
                $projectValidator->assert($postData);

                $project = new project();
                $project->title = $postData['title'];
                $project->description = $postData['description'];
                $project->save();
                $responseMessage = 'Saved';
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }
        }
        // include '../views/addProject.php';
        return $this->renderHTML('addProject.twig', [
            'responseMessage' => $responseMessage
        ]);
    }
}