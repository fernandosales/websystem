<?php


namespace AccountancyBundle\Controller;

use AccountancyBundle\Entity\Book;
use AccountancyBundle\Form\Type\BookType;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class BookController extends Controller
{
    /**
     * @Route("/", name="fnz.book.book_index")
     * @Template
     * @Acl(
     *     id="fnz.book.book_index",
     *     type="entity",
     *     class="AccountancyBundle:Book",
     *     permission="VIEW"
     * )
     */
    public function indexAction()
    {
        return array('gridName' => 'books-grid');
    }

    /**
     * @Route("/{id}", name="fnz.book.book_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("fnz.book.book_view")
     * @param Book $book
     * @return array
     */
    public function viewAction(Book $book)
    {
        return array('entity' => $book);
    }

    /**
     * @Route("/create", name="fnz.book.book_create")
     * @Template("AccountancyBundle:Book:update.html.twig")
     * @Acl(
     *     id="fnz.book.book_create",
     *     type="entity",
     *     class="AccountancyBundle:Book",
     *     permission="CREATE"
     * )
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function createAction(Request $request)
    {
        return $this->update(new Book(), $request);
    }

    /**
     * @Route("/update/{id}", name="fnz.book.book_update", requirements={"id":"\d+"}, defaults={"id":0})
     * @Template()
     * @Acl(
     *     id="fnz.book.book_update",
     *     type="entity",
     *     class="AccountancyBundle:Book",
     *     permission="EDIT"
     * )
     * @param Book $book
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function updateAction(Book $book, Request $request)
    {
        return $this->update($book, $request);
    }

    private function update(Book $book, Request $request)
    {
        $form = $this->get('form.factory')->create(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->get('oro_ui.router')->redirectAfterSave(
                array(
                    'route' => 'fnz.book.book_update',
                    'parameters' => array('id' => $book->getId()),
                ),
                array('route' => 'fnz.book.book_index'),
                $book
            );
        }

        return array(
            'entity' => $book,
            'form' => $form->createView(),
        );
    }
}
