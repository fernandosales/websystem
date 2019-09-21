<?php


namespace AccountancyBundle\Controller;

use AccountancyBundle\Entity\Category;
use AccountancyBundle\Form\Type\CategoryType;
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
class CategoryController extends Controller
{
    /**
     * @Route("/", name="fnz.category.category_index")
     * @Template
     * @Acl(
     *     id="fnz.category.category_index",
     *     type="entity",
     *     class="AccountancyBundle:Category",
     *     permission="VIEW"
     * )
     */
    public function indexAction()
    {
        return array('gridName' => 'categories-grid');
    }

    /**
     * @Route("/{id}", name="fnz.category.category_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("fnz.category.category_view")
     * @param Category $category
     * @return array
     */
    public function viewAction(Category $category)
    {
        return array('entity' => $category);
    }

    /**
     * @Route("/create", name="fnz.category.category_create")
     * @Template("AccountancyBundle:Category:update.html.twig")
     * @Acl(
     *     id="fnz.category.category_create",
     *     type="entity",
     *     class="AccountancyBundle:Category",
     *     permission="CREATE"
     * )
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function createAction(Request $request)
    {
        return $this->update(new Category(), $request);
    }

    /**
     * @Route("/widget/create", name="fnz.category.category_widget_create")
     * @Template("AccountancyBundle:Category:widget:update.html.twig")
     * @Acl(
     *     id="fnz.category.category_widget_create",
     *     type="entity",
     *     class="AccountancyBundle:Category",
     *     permission="CREATE"
     * )
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function widgetCreateAction(Request $request)
    {
        return $this->update(new Category(), $request);
    }

    /**
     * @Route("/update/{id}", name="fnz.category.category_update", requirements={"id":"\d+"}, defaults={"id":0})
     * @Template()
     * @Acl(
     *     id="fnz.category.category_update",
     *     type="entity",
     *     class="AccountancyBundle:Category",
     *     permission="EDIT"
     * )
     * @param Category $category
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function updateAction(Category $category, Request $request)
    {
        return $this->update($category, $request);
    }

    private function update(Category $category, Request $request)
    {
        $form = $this->get('form.factory')->create(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->get('oro_ui.router')->redirectAfterSave(
                array(
                    'route' => 'fnz.category.category_update',
                    'parameters' => array('id' => $category->getId()),
                ),
                array('route' => 'fnz.category.category_index'),
                $category
            );
        }

        return array(
            'entity' => $category,
            'form' => $form->createView(),
        );
    }
}
