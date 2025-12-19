<?php

namespace Eivorvch\ExternalThirdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\VchInnerBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

//#[Route('/external-third-bundle', name: 'external_third_bundle_debug')]
#[Route(name: 'external_third_bundle_debug')]
class ExternalThirdBundleController extends AbstractController
{
    private string $bg = "<script> document.querySelector('html').style.backgroundColor = '#ccc';</script>";

    #[Route('/external-third-bundle-debug-run', name: '_external-third-bundle_debug_run', methods: ['GET'])]
    public function external_third_bundle_debug_run(): Response { return new Response($this->bg . '____external-third-bundle_debug_run'); }

    #[Route('/some-external-third-bundle-process', name: '_some_external_third_bundle_process', methods: ['GET'])]
    public function some_external_third_bundle_process(UserRepository $repository, EntityManagerInterface $em): JsonResponse
    {
        $data = [ 'route_name' => '_some_external-third-bundle_process' ];
        $DEBUG_USER_NAME = 'debug_user';
        $randNumber = rand(1, 20);
        foreach ($repository->findAll() as $user) {
            if ($user->getLogin() === $DEBUG_USER_NAME) {
                $data['previous_lang'] = $user->getLanguage();

                $user->setLanguage("{$randNumber}_LN");

                $em->persist($user);
                $em->flush();
                $em->clear();

                $data['changed_lang'] = $user->getLanguage();
            }
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
