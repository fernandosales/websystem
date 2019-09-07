<?php

namespace InstitutionBundle\Controller\Api\Rest;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;

/**
  * @RouteResource("institution")
 * @NamePrefix("institution_api_")
 */
class InstitutionController extends RestController
{

    /**
     * Delete institution
     *
     * @Acl(
     *      id="fnz.institution.institution_delete",
     *      type="entity",
     *      class="InstitutionBundle:Institution",
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
        return $this->get('fnz.institution.institution_manager.api');
    }
}
