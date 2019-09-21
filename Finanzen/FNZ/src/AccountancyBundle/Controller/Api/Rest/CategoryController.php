<?php

namespace AccountancyBundle\Controller\Api\Rest;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;

/**
 * @RouteResource("book")
 * @NamePrefix("book_api_")
 */
class CategoryController extends RestController
{

    /**
     * Delete institution
     *
     * @Acl(
     *      id="fnz.book.book_delete",
     *      type="entity",
     *      class="AccountancyBundle:Book",
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
        return $this->get('fnz.accountancy.category_manager.api');
    }
}
