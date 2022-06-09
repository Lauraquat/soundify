<?php

namespace App\Controller;

use App\Entity\Song;
use App\Form\SongType;
use League\Flysystem\FilesystemOperator;
use App\Repository\SongRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as CoreSecurity;

#[Route('/songs')]
class SongController extends AbstractController
{
    #[Route('/', name: 'app_song_index', methods: ['GET'])]
    public function index(SongRepository $songRepository): Response
    {
        return $this->render('song/index.html.twig', [
            'songs' => $songRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_song_new', methods: ['GET', 'POST'])]
    #[Security('is_granted("IsArtiste")')]
    public function new(Request $request, SongRepository $songRepository, CoreSecurity $security, FilesystemOperator $defaultStorage): Response
    {
        $song = new Song();
        $form = $this->createForm(SongType::class, $song);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $security->getUser();
            $artiste = $user->getArtiste();
            $song->addArtist($artiste);

            /** @var UploadedFile $file */
            $file = $form->get('formFile')->getData();
            $newFilename = $song->getName().'.'.$file->guessExtension();

            if($file->isValid()){
                $stream = fopen($file->getRealPath(), 'r+');
                $defaultStorage->writeStream('songFiles/'.$newFilename, $stream);
                fclose($stream);

                $song->setFile($newFilename);
            }


            $image = $form->get('formImage')->getData();
            $newImagename = $song->getName().'.'.$image->guessExtension();

            if($image->isValid()){
                $stream = fopen($image->getRealPath(), 'r+');
                $defaultStorage->writeStream('songCovers/'.$newImagename, $stream);
                fclose($stream);

                $song->setImage($newImagename);
            }
            
                       
            $songRepository->add($song, true);

            return $this->redirectToRoute('app_song_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('song/new.html.twig', [
            'song' => $song,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_song_show', methods: ['GET'])]
    public function show(Song $song): Response
    {
        return $this->render('song/show.html.twig', [
            'song' => $song,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_song_edit', methods: ['GET', 'POST'])]
    #[Security('is_granted("IsArtiste")')]
    public function edit(Request $request, Song $song, SongRepository $songRepository, CoreSecurity $security, FilesystemOperator $defaultStorage): Response
    {
        $form = $this->createForm(SongType::class, $song, ['creationMode' => false]);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('isArtistOwner', $song);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('formFile')->getData();

            if($file !=null){

                $newFilename = $song->getName().'.'.$file->guessExtension();

                /** @var User $user */
                $user = $security->getUser();
                $artiste = $user->getArtiste();
                $song->addArtist($artiste);

                /** @var UploadedFile $file */
                $file = $form->get('formFile')->getData();
                $newFilename = $song->getName().'.'.$file->guessExtension();

                if($file->isValid()){
                    $stream = fopen($file->getRealPath(), 'r+');
                    $defaultStorage->writeStream('songFiles/'.$newFilename, $stream);
                    fclose($stream);

                    $song->setFile($newFilename);
                }
            }


            $image = $form->get('formImage')->getData();

            if($image !=null){

                $image = $form->get('formImage')->getData();
                $newImagename = $song->getName().'.'.$image->guessExtension();

                if($image->isValid()){
                    $stream = fopen($image->getRealPath(), 'r+');
                    $defaultStorage->writeStream('songCovers/'.$newImagename, $stream);
                    fclose($stream);

                    $song->setImage($newImagename);
                }

            }

            $songRepository->add($song, true);

            return $this->redirectToRoute('app_song_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('song/edit.html.twig', [
            'song' => $song,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_song_delete', methods: ['POST'])]
    #[Security('is_granted("IsArtiste")')]
    public function delete(Request $request, Song $song, SongRepository $songRepository): Response
    {
        $this->denyAccessUnlessGranted('isArtistOwner', $song);

        if ($this->isCsrfTokenValid('delete'.$song->getId(), $request->request->get('_token'))) {
            $songRepository->remove($song, true);
        }

        return $this->redirectToRoute('app_song_index', [], Response::HTTP_SEE_OTHER);
    }
}
