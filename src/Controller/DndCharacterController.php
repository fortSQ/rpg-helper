<?php

namespace App\Controller;

use App\Entity\DndCharacter;
use App\Form\DndCharacterType;
use App\Repository\DndCharacterRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/dnd/character")
 * @IsGranted("ROLE_USER")
 */
class DndCharacterController extends BaseController
{
    /**
     * @Route("/", name="dnd_character_index", methods="GET")
     */
    public function index(DndCharacterRepository $dndCharacterRepository): Response
    {
        return $this->render('dnd_character/index.html.twig', [
            'dnd_characters' => $dndCharacterRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="dnd_character_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $dndCharacter = new DndCharacter();
        $form = $this->createForm(DndCharacterType::class, $dndCharacter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dndCharacter->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($dndCharacter);
            $em->flush();

            $this->addFlash('success', 'Character created');

            return $this->redirectToRoute('dnd_character_index');
        }

        return $this->render('dnd_character/new.html.twig', [
            'dnd_character' => $dndCharacter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dnd_character_show", methods="GET")
     */
    public function show(DndCharacter $dndCharacter): Response
    {
        return $this->render('dnd_character/show.html.twig', [
            'dnd_character' => $dndCharacter
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dnd_character_edit", methods="GET|POST")
     */
    public function edit(Request $request, DndCharacter $dndCharacter): Response
    {
        $form = $this->createForm(DndCharacterType::class, $dndCharacter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dnd_character_edit', [
                'id' => $dndCharacter->getId()
            ]);
        }

        return $this->render('dnd_character/edit.html.twig', [
            'dnd_character' => $dndCharacter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dnd_character_delete", methods="DELETE")
     */
    public function delete(Request $request, DndCharacter $dndCharacter, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dndCharacter->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dndCharacter);
            $em->flush();

            $this->addFlash(
                'info',
                $translator->trans('Weapons', [], 'dnd')
            );
        }

        return $this->redirectToRoute('dnd_character_index');
    }
}
