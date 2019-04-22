<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\IoFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Service\FileUploader;

class RestController extends AbstractFOSRestController
{
    /**
     * @Route("/rest", name="rest")
     */
    public function index()
    {

        $data = ""; // get data, in this case list of users.
        $view = $this->view($data, 200)
            ->setTemplate("rest/index.html.twig")
            ->setTemplateVar('users')
        ;

        return $this->handleView($view,[
            'controller_name' => 'RestController',
        ]);

    }
    /**
     * @Rest\Put("/files/{id}")
     * @Rest\Post("/files/{id}")
     * @Rest\Get("/files/{id}")
     * @View
     */
    public function randomAction(IoFile $ioFile)
    {
        return $ioFile;
    }

    /**
     * @Rest\Post(
     *    path = "/iofiles",
     *    name = "app_iofiles_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("ioFile", converter="fos_rest.request_body")
     */
    public function createAction(IoFile $ioFile)
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($ioFile);
        $em->flush();

        return $this->view($ioFile, Response::HTTP_CREATED, ['Location' => $this->generateUrl('app_iofiles_show', ['id' => $ioFile->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
    }

    /**
     * @Rest\Get(
     *    path = "/iofiles/{id}",
     *    name = "app_iofiles_show"
     * )
     * @Rest\View()
     * @ParamConverter("ioFile", converter="fos_rest.request_body")
     */
    public function showAction(IoFile $ioFile)
    {

        return $ioFile;
    }
    /**
     * @Rest\Post(
     *    path = "/iofileupload",
     *    name = "app_iofiles_upload"
     * )
     * @Rest\View()
     */
    public function uploadAction(Request $request, FileUploader $fileUploader)
    {

        $em = $this->getDoctrine()->getManager();

        foreach($request->files as $file){
            $filename = $fileUploader->upload($file);
        }
        $device = $request->query->get('device');


        $ioFile = new IoFile();
        $ioFile->setFilename($filename);
        $ioFile->setDevice($device);
        $em->persist($ioFile);
        $em->flush();

        return $this->view($ioFile, Response::HTTP_CREATED, ['Location' => $this->generateUrl('app_iofiles_show', ['id' => $ioFile->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
    }
}
