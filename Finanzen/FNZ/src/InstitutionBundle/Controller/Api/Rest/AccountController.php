<?php

namespace InstitutionBundle\Controller\Api\Rest;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;

/**
 * @RouteResource("account")
 * @NamePrefix("account_api_")
 */
class AccountController extends RestController
{

    /**
     * Delete institution
     *
     * @Acl(
     *      id="institution.account_delete",
     *      type="entity",
     *      class="InstitutionBundle:Account",
     *      permission="DELETE"
     * )
     */
    public function deleteAction($id)
    {
        return $this->handleDeleteRequest($id);
    }

    public function getForm()
    {
    }

    public function getFormHandler()
    {
    }

    public function getManager()
    {
        return $this->get('institution.account_manager.api');
    }
}
