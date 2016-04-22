<?php

namespace Acme\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Acme\ShopBundle\Base\MainApiController;

/**
 * Bill controller.
 *
 * @Route("/bill")
 */
class BillController extends MainApiController   
{
    /**
     * Lists all Bill entities.
     * @Route("", name="bill")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }

    /**
     * Edit a new Bill entity.
     * @Route("/{id}", defaults={"_format"="json"}, requirements={"_method"="PUT", "id"="[\d-]+"})
     * @Method("PUT")
     */
    public function editAction(Request $request, $id)
    {
        return parent::editAction($request, $id);
    }

    /**
     * Creates a new Bill entity.
     * @Route("", defaults={"_format"="json"}, requirements={"_method"="POST"})
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        return parent::createAction($request);
    }

    /**
     * Delete a new Bill entity.
     * @Route("/{id}", defaults={"_format"="json"}, requirements={"_method"="DELETE", "id"="[\d-]+"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        return parent::deleteAction($request, $id);
    }
        
}
