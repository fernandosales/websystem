<?php
namespace InstitutionBundle\Controller;

use InstitutionBundle\Entity\Account;
use InstitutionBundle\Form\Type\AccountType;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class AccountController extends Controller
{
  /**
    * @Route("/", name="fnz.account.account_index")
    * @Template
    * @Acl(
    *     id="fnz.account.account_view",
    *     type="entity",
    *     class="InstitutionBundle:Account",
    *     permission="VIEW"
    * )
    */
    public function indexAction()
    {
        return array('gridName' => 'accounts-grid');
    }

    /**
     * @Route("/{id}", name="fnz.account.account_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("fnz.account.account_view")
     */
    public function viewAction(Account $account)
    {
        return array('entity' => $account);
    }

    /**
     * @Route("/create", name="fnz.account.account_create")
     * @Template("InstitutionBundle:Account:update.html.twig")
     * @Acl(
     *     id="fnz.account.account_create",
     *     type="entity",
     *     class="InstitutionBundle:Account",
     *     permission="CREATE"
     * )
     */
    public function createAction(Request $request)
    {
        return $this->update(new Account(), $request);
    }

    /**
     * @Route("/update/{id}", name="fnz.account.account_update", requirements={"id":"\d+"}, defaults={"id":0})
     * @Template()
     * @Acl(
     *     id="fnz.account.account_update",
     *     type="entity",
     *     class="InstitutionBundle:Account",
     *     permission="EDIT"
     * )
     */
    public function updateAction(Account $account, Request $request)
    {
        return $this->update($account, $request);
    }

    private function update(Account $account, Request $request)
    {
        $form = $this->get('form.factory')->create(AccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($account);
            $entityManager->flush();

            return $this->get('oro_ui.router')->redirectAfterSave(
                array(
                    'route' => 'fnz.account.account_update',
                    'parameters' => array('id' => $account->getId()),
                ),
                array('route' => 'fnz.account.account_index'),
                $account
            );
        }

        return array(
            'entity' => $account,
            'form' => $form->createView(),
        );
    }
}
