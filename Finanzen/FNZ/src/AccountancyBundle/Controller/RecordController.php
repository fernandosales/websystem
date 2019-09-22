<?php


namespace AccountancyBundle\Controller;

use AccountancyBundle\Entity\Record;
use AccountancyBundle\Form\Type\RecordType;
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
class RecordController extends Controller
{
    /**
     * @Route("/", name="fnz.record.record_index")
     * @Template
     * @Acl(
     *     id="fnz.record.record_index",
     *     type="entity",
     *     class="AccountancyBundle:Record",
     *     permission="VIEW"
     * )
     */
    public function indexAction()
    {
        return array('gridName' => 'records-grid');
    }

    /**
     * @Route("/{id}", name="fnz.record.record_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("fnz.record.record_view")
     * @param Record $record
     * @return array
     */
    public function viewAction(Record $record)
    {
        return array('entity' => $record);
    }

    /**
     * @Route("/create", name="fnz.record.record_create")
     * @Template("AccountancyBundle:Record:update.html.twig")
     * @Acl(
     *     id="fnz.record.record_create",
     *     type="entity",
     *     class="AccountancyBundle:Record",
     *     permission="CREATE"
     * )
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function createAction(Request $request)
    {
        return $this->update(new Record(), $request);
    }

    /**
     * @Route("/update/{id}", name="fnz.record.record_update", requirements={"id":"\d+"}, defaults={"id":0})
     * @Template()
     * @Acl(
     *     id="fnz.record.record_update",
     *     type="entity",
     *     class="AccountancyBundle:Record",
     *     permission="EDIT"
     * )
     * @param Record $record
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function updateAction(Record $record, Request $request)
    {
        return $this->update($record, $request);
    }

    private function update(Record $record, Request $request)
    {
        $form = $this->get('form.factory')->create(RecordType::class, $record);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($record);
            $entityManager->flush();

            return $this->get('oro_ui.router')->redirectAfterSave(
                array(
                    'route' => 'fnz.record.record_update',
                    'parameters' => array('id' => $record->getId()),
                ),
                array('route' => 'fnz.record.record_index'),
                $record
            );
        }

        return array(
            'entity' => $record,
            'form' => $form->createView(),
        );
    }

}
