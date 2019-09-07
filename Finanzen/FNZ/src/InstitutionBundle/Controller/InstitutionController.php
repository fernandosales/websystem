<?php
namespace InstitutionBundle\Controller;

use InstitutionBundle\Entity\Institution;
use InstitutionBundle\Form\Type\InstitutionType;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class InstitutionController extends Controller
{
  /**
    * @Route("/", name="fnz.institution.institution_index")
    * @Template
    * @Acl(
    *     id="fnz.institution.institution_view",
    *     type="entity",
    *     class="InstitutionBundle:Institution",
    *     permission="VIEW"
    * )
    */
    public function indexAction()
    {
        return array('gridName' => 'institutions-grid');
    }

    /**
     * @Route("/{id}", name="fnz.institution.institution_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("fnz.institution.institution_view")
     */
    public function viewAction(Institution $institution)
    {
        return array('entity' => $institution);
    }

    /**
     * @Route("/create", name="fnz.institution.institution_create")
     * @Template("InstitutionBundle:Institution:update.html.twig")
     * @Acl(
     *     id="fnz.institution.institution_create",
     *     type="entity",
     *     class="InstitutionBundle:Institution",
     *     permission="CREATE"
     * )
     */
    public function createAction(Request $request)
    {
        return $this->update(new Institution(), $request);
    }

    /**
     * @Route("/update/{id}", name="fnz.institution.institution_update", requirements={"id":"\d+"}, defaults={"id":0})
     * @Template()
     * @Acl(
     *     id="fnz.institution.institution_update",
     *     type="entity",
     *     class="InstitutionBundle:institution",
     *     permission="EDIT"
     * )
     */
    public function updateAction(Institution $institution, Request $request)
    {
        return $this->update($institution, $request);
    }

    private function update(Institution $institution, Request $request)
    {
        $form = $this->get('form.factory')->create(InstitutionType::class, $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($institution);
            $entityManager->flush();

            return $this->get('oro_ui.router')->redirectAfterSave(
                array(
                    'route' => 'fnz.institution.institution_update',
                    'parameters' => array('id' => $institution->getId()),
                ),
                array('route' => 'fnz.institution.institution_index'),
                $institution
            );
        }

        return array(
            'entity' => $institution,
            'form' => $form->createView(),
        );
    }
}
