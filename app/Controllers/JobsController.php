<?php

namespace App\Controllers;

use App\Models\job;
use Laminas\Diactoros\ServerRequest;
use Respect\Validation\Validator as v;

class JobsController extends BaseController{
    public function getAddJobAction(ServerRequest $request){
        // print_r($request->getMethod());
        // print_r((string)$request->getBody());    //contenido del cuerpo de la peticion http
        // print_r($request->getParsedBody());      //array con los datos del request
        $responseMessage = null;
        if ($request->getMethod() == 'POST') {

            //? v::attribute para objs V::key para arrays
            $postData = $request->getParsedBody();

            $jobValidator = v::key('title', v::stringType()->notEmpty())
                ->key('description', v::stringType()->notEmpty());

            try {
                $jobValidator->assert($postData);

                $files = $request->getUploadedFiles();                
                $logo = $files['logo'];

                if($logo->getError() == UPLOAD_ERR_OK ){
                    $fileName = $logo->getClientFilename();    
                    $extension = pathinfo($logo->getClientFilename(), PATHINFO_EXTENSION);
                    $fileName_hash = md5($fileName.date('Ymd')).'.'.$extension;
                    $logo->moveTo("uploads/$fileName_hash");

                    $job = new job();
                    $job->title = $postData['title'];
                    $job->description = $postData['description'];
                    $job->fileName = $fileName;
                    $job->fileName_hash = $fileName_hash;
                    $job->extension = $extension;
                    $job->save();
                }

                $responseMessage = 'Saved';
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }
        }
        // include "../views/addJob.php";
        return $this->renderHTML('addJob.twig', [
            'responseMessage' => $responseMessage
        ]);
    }
}
