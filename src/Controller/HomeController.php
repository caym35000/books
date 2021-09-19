<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Book;
use App\Form\BookType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;



class HomeController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $entityManager){
        $this->em = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {

        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        $message = null;
        if($form->isSubmitted() && $form->isValid()){
            $book = $form->getData();
            
        try{
            $this->em->persist($book);
            $this->em->flush();
        }catch(UniqueConstraintViolationException $e){
            $message = 'Cet ouvrage a déjà été enregistré !';
            return $this->render('home/index.html.twig', [
                'form_book' => $form->createView(),
                'message' => $message
            ]);
        }

            

        }

        return $this->render('home/index.html.twig', [
            'form_book' => $form->createView(),
        ]);
    }

    /**
     * @Route("/livres", name="books")
     */
    public function bookList(Request $request)
    {

        $books = $this->em->getRepository(Book::Class)->findAll();


        return $this->render('home/book_list.html.twig', [
            'books' => $books,
        ]);
    }
}
